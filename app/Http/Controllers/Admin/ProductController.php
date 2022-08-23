<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryDescription;
use App\Models\LengthClass;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductAttributeGroup;
use App\Models\ProductDescription;
use App\Models\ProductDiscount;
use App\Models\ProductImage;
use App\Models\ProductPrice;
use App\Models\ProductRelated;
use App\Models\StoreProductOption;
use App\Models\ProductRelatedAttribute;
use App\Models\ProductSpecial;
use App\Models\StockStatus;
use App\Models\TaxRate;
use App\Models\WeightClass;
use App\Traits\CustomFileTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    use CustomFileTrait;
    protected $path = '';
    protected $customDateFormat = '';
    protected $databaseDateFormat = '';

    public function __construct()
    {
        $this->path = public_path(config('constant.file_path.product'));
        $this->customDateFormat = config('constant.date_format')['custom_date_format'];
        $this->databaseDateFormat = config('constant.date_format')['database_date_format'];
    }

    public function index(Request $request) {
        $user = Auth::user();
        $seller = $user->seller->first();
        $name = $request->get('name', '');
        $model = $request->get('model', '');
        $quantity = $request->get('quantity', '');
        $status = $request->get('status', '1');

        $records = Product::select('id','image','category_id', 'model','price', 'min_price', 'max_price', 'location', 'quantity','sort_order','status');
        $records = $user->hasRole('Admin') || empty($seller) ? $records->where('seller_id', 0)->orWhereNull('seller_id') : $records->where('seller_id', 1);
        $records = $records->with('productDescription:name,id,product_id','category:name,category_id')
            ->when($name != ''|| $model != '' || $quantity != '' || $status != ''  , function($q) use($name,$model,$quantity,$status) {
                $q->where('model','like',"%$model%");
                $q->where('quantity','like',"%$quantity%");
                $status != '2' ?  $q->where('status','like',"%$status%") : null;
                $q->whereHas('productDescription',function($q) use($name){
                    $q->where('name','like',"%$name%");
                });
            })->orderBy('created_at','DESC')->paginate($this->defaultPaginate);

        return view('admin.product.index',['records' => $records,'status' => $status]);
    }

    protected function getRequiredData () {
        $data['category'] =  Category::getActivePluck();
        $data['stock_status'] =  StockStatus::getActivePluck();
        $data['manufacturer'] =  Manufacturer::getActivePluck();
        $data['tax_rate'] =  TaxRate::getActivePluck();
        $data['lenght_class'] =  LengthClass::getActivePluck();
        $data['weight_class'] =  WeightClass::getActivePluck();
        $data['pluckProducts'] =  ProductDescription::getActivePluck();
        $data['product_options'] =  ProductOption::getActivePluck();
        $data['attributeArray'] =  ProductAttributeGroup::with('relationAttributes:name,id,group_id')->has('relationAttributes')->select('name','id')->get();

        return $data;
    }

    public function add() {
        $data = $this->getRequiredData();
        return view('admin.product.add',['data' => $data]);
    }

    public function store(Request $request) {

        $this->validateData($request);

        $product = new Product($request->only('model', 'quantity', 'price','category_id', 'points', 'min_price', 'max_price'));

        //if has main image
        if($request->hasFile('main_image')) {
          $this->createDirectory($this->path);
          $product->image = $this->saveCustomFileAndGetImageName(request()->file('main_image'),$this->path);
        }

        $product->stock_status_id  = $request->stock_status_id ? $request->stock_status_id : 0;
        $product->manufacturer_id  = $request->manufacturer_id ? $request->manufacturer_id : 0;
        $product->tax_rate_id  = $request->tax_rate_id ? $request->tax_rate_id : 0;
        if($request->date_available) {
          $product->date_available  =   $request->date_available;
        }
        else {
          $product->date_available  =   date('d/m/Y');
        }

        $product->length  = $request->length ? $request->length : 0;
        $product->width  = $request->width ? $request->width : 0;
        $product->height  = $request->height ? $request->height : 0;
        $product->weight_class_id  = $request->weight_class_id ?
            $request->weight_class_id : 0;
        $product->weight  = $request->weight ? $request->weight : 0;
        $product->status  = $request->status ? $request->status : 0;
        $product->sort_order  = $request->sort_order ? $request->sort_order : 0;


        $product->save();

        // Save Description
        $description = new ProductDescription($request->only('name','description','meta_title','meta_description','meta_keyword'));
        $description->product_id = $product->id;
        $description->save();

        // Save Attributes
        $attributesArray = $this->getAttributeProductData($product->id,$request->attributesArray);
        if(count($attributesArray) > 0) {
          ProductRelatedAttribute::insert($attributesArray);
        }

        // Save Related Product
        $relatedProducts = $this->getRelatedProductData($product->id,$request->related_id);
        ProductRelated::insert($relatedProducts);

        // Save Product Image
        if(array_key_exists('image',$request->product_image)) {
          $productImages = $this->getproductImages($product->id,$request->product_image);
          ProductImage::insert($productImages);
        }

        // Save Product Special
        if($request->special_price != null) {
          $specialProduct = [
              'product_id' => $product->id,
              'price' => $request->special_price,
              'start_date' => $this->changeDateFormat($request->start_date,$this->customDateFormat,$this->databaseDateFormat),
              'end_date' => $this->changeDateFormat($request->end_date,$this->customDateFormat,$this->databaseDateFormat)
          ];
          ProductSpecial::insert($specialProduct);
        }

        //save Options
        $optionArr = [];
        if($request->optionPost) {
          $postOptions = explode(',', $request->optionPost);
          foreach ($postOptions as $key => $value) {
            for ($i=0; $i<count($request->option[$value]['label']);$i++) {
              if($request->option[$value]['label'][$i] != null){
                $optionArr [] = [
                    'label' => $request->option[$value]['label'][$i],
                    'price' => $request->option[$value]['price'][$i],
                    'color_code' => array_key_exists('color_code',$request->option[$value]) ? $request->option[$value]['color_code'][$i] : '',
                    'option_id' => $value,
                    'product_id' =>$product->id
                ];
              }
            }
          }
        }

        if(count($optionArr) > 0) {
          StoreProductOption::insert($optionArr);
        }

        $today = Carbon::today();
        $new_price = new ProductPrice(array('product_id' => $product->id, 'price' => $product->price, 'date' => $today));
        $new_price->save();

        return redirect(route('product'))->with('success','Product Created Successfully');
    }

    public function edit($id) {

        $data = $this->getRequiredData();
        $data['relatedIds'] = ProductRelated::getRelatedIds($id);
        $data['productRelatedAttribute'] = ProductRelatedAttribute::pluckByProduct($id);
        $data['attributeIds'] = array_keys($data['productRelatedAttribute']);
        $data['productOptions'] = StoreProductOption::where('product_id',$id)->get();

        //get unique id
        $optionids = [];
        $optionID = 0;
        $optionCommaSeprate ='';

        foreach ($data['productOptions'] as $key => $value) {
            if($value->option_id != $optionID) {
              $optionids []=$value->option_id;
            }
            $optionID = $value->option_id;
        }

        $optionids = array_unique($optionids);

        $data['optionCommaSeprate'] = implode(',',$optionids);
        $data['optionIDArr'] = $optionids;

        $data['options'] = ProductOption::whereIn('id',$optionids)->get();

        $data['data'] = Product::with('category','productDescription','images','special','discountProduct')->findOrFail($id);

        return view('admin.product.edit',[
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id) {

        $this->validateData($request);

        $product = Product::whereId($id)->first();

        if($request->hasFile('main_image')) {
            //$this->removeOldImage($product->image,$this->path);
            $product->image = $this->saveCustomFileAndGetImageName(request()->file('main_image'),$this->path);
        }

        $product->fill($request->only(Product::$fillableValue))->save();

        $product->productRelated()->delete();

        // Save Related Product
        $relatedProducts = $this->getRelatedProductData($product->id,$request->related_id);
        ProductRelated::insert($relatedProducts);

        // Save Attributes
        ProductRelatedAttribute::deleteByProduct($id);

        $attributesArray = $this->getAttributeProductData($product->id,$request->attributesArray);
        if(count($attributesArray) > 0) {
          ProductRelatedAttribute::insert($attributesArray);
        }

        // Save Description
        $description = ProductDescription::where('product_id',$id)->first();
        $description->fill($request->only('description','name','meta_title','meta_description','meta_keyword'))->save();

        //update Options
        StoreProductOption::where('product_id',$id)->delete();
        $optionArr = [];
        if($request->optionPost) {
          $postOptions = explode(',', $request->optionPost);

          foreach ($postOptions as $key => $value) {
            for ($i=0; $i<count($request->option[$value]['label']);$i++) {
              if($request->option[$value]['label'][$i] != null){
                $optionArr [] = [
                    'label' => $request->option[$value]['label'][$i],
                    'price' => $request->option[$value]['price'][$i],
                    'color_code' => array_key_exists('color_code',$request->option[$value]) ? $request->option[$value]['color_code'][$i] : '',
                    'option_id' => $value,
                     'product_id' =>$product->id
                ];
              }
            }
          }
        }

        if(count($optionArr) > 0) {
          StoreProductOption::insert($optionArr);
        }

        //image update
        $oldImagesData  = ProductImage::where('product_id',$id)->get();
        $oldImageIds = $oldImagesData->pluck('id')->toArray();
        $productImageIds = [];
        $newImageArray = [];
        if($request->product_image['sort_order_image']) {
          foreach ($request->product_image['sort_order_image'] as $key => $value ) {
              if (isset($request->product_image['id'][$key])) {
                  $imageId = $request->product_image['id'][$key];
                  $productImageIds[] = $imageId;
                  $productImage = ProductImage::whereId($imageId)->first();
                  if(isset($request->product_image['image'][$key])) {
                    $image = $request->product_image['image'][$key];
                    //$this->removeOldImage($productImage->image,$this->path);
                    $productImage->image = $this->saveCustomFileAndGetImageName($image,$this->path);
                  }
                  $productImage->sort_order_image = $request->product_image['sort_order_image'][$key];
                  $productImage->save();
              }
              else {
                if(array_key_exists('image',$request->product_image)) {
                  $image = $request->product_image['image'][$key];
                  $imageName = $this->saveCustomFileAndGetImageName($image,$this->path);
                  $newImageArray[] = [
                      'product_id' => $id,
                      'sort_order_image' => $request->product_image['sort_order_image'][$key],
                      'image' => $imageName
                  ];
                }

              }
          }
        }

        $deletedImageIds = array_diff($oldImageIds,$productImageIds);
        $oldProductImages = $oldImagesData->pluck('image','id')->toArray();

        ProductImage::whereIn('id',$deletedImageIds)->delete();
        ProductImage::insert($newImageArray);

        //      Remove deleted Images
        foreach($deletedImageIds as $key => $value) {
            //$this->removeOldImage($oldProductImages[$value],$this->path);
        }

        if($request->special_price != null) {
          ProductSpecial::where('product_id',$id)->delete();
          $newSpecialArray[] = [
              'product_id' => $id,
              'price' => $request->special_price,
              'start_date' => $this->changeDateFormat($request->start_date,$this->customDateFormat,$this->databaseDateFormat),
              'end_date' => $this->changeDateFormat($request->end_date,$this->customDateFormat,$this->databaseDateFormat)
          ];

          ProductSpecial::insert($newSpecialArray);
        }

        $today = Carbon::today();
        $new_price = new ProductPrice(array('product_id' => $product->id, 'price' => $product->price, 'date' => $today));
        $new_price->save();
        // update product price for child products
        Product::where('origin_id', $product->id)->update(['price'=> $product->price]);
        return redirect(route('product'))->with('success','Product Updated Successfully');
    }

    protected function updateDiscountProduct($request,$productId) {
        $existIds = [];
        $newDiscountArray = [];
        foreach ($request->discount['discount_price'] as $key => $value ) {
            if (isset($request->discount['id'][$key])) {
                $discountid = $request->discount['id'][$key];
                $existIds[] = $discountid;
                $productDiscount = ProductDiscount::whereId($discountid)->first();

                $productDiscount->sort_order_discount = $request->discount['sort_order_discount'][$key];
                $productDiscount->price = $request->discount['discount_price'][$key];
                $productDiscount->quantity = $request->discount['quantity'][$key];
                $productDiscount->start_date = $this->changeDateFormat($request->discount['start_date'][$key],$this->customDateFormat,$this->databaseDateFormat);
                $productDiscount->end_date = $this->changeDateFormat($request->discount['end_date'][$key],$this->customDateFormat,$this->databaseDateFormat);
                $productDiscount->save();
            } else {
                $newDiscountArray[] = [
                    'product_id' => $productId,
                    'sort_order_discount' => $request->discount['sort_order_discount'][$key],
                    'price' => $request->discount['discount_price'][$key],
                    'quantity' => $request->discount['quantity'][$key],
                    'start_date' => $this->changeDateFormat($request->discount['start_date'][$key],$this->customDateFormat,$this->databaseDateFormat),
                    'end_date' => $this->changeDateFormat($request->discount['end_date'][$key],$this->customDateFormat,$this->databaseDateFormat)
                ];
            }
        }
        ProductDiscount::whereNotIn('id',$existIds)->where('product_id', $productId)->delete();
        ProductDiscount::insert($newDiscountArray);
    }

    public function delete($id) {
        if(! $data = Product::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        //$this->removeOldImage($data->image,$this->path);
        $images = $data->images()->pluck('image');
        if(count($images) > 0){
          foreach($images as $key => $value) {
              //$this->removeOldImage($value,$this->path);
          }
        }

        $data->productRelated()->delete();
        $data->special()->delete();
        $data->images()->delete();
        $data->productDescription()->delete();
        $data->delete();
        return redirect(route('product'))->with('success', 'Product Deleted Successfully');
    }

    public function getDetail(Request  $request) {
        return Product::select('model','price','id')->with('productDescription:name,product_id')->whereId($request->id)->first();
    }


    protected function getRelatedProductData($productId,$relatedIds) {
        $dataArray = [];
        if(isset($relatedIds)) {
            foreach($relatedIds as $key => $value) {
                $dataArray[] = [
                    'product_id' => $productId,
                    'related_id' => $value
                ];
            }
        }
        return $dataArray;
    }

    protected function getDiscountProductData($productId,$discount) {
        $dataArray = [];
        foreach($discount['discount_price'] as $key => $value) {
            $dataArray[] = [
                'product_id' => $productId,
                'quantity' => $discount['quantity'][$key],
                'sort_order_discount' => $discount['sort_order_discount'][$key],
                'price' => $discount['discount_price'][$key],
                'start_date' => $this->changeDateFormat($discount['start_date'][$key],$this->customDateFormat,$this->databaseDateFormat),
                'end_date' => $this->changeDateFormat($discount['end_date'][$key],$this->customDateFormat,$this->databaseDateFormat)
            ];
        }
        return $dataArray;
    }

    protected function getAttributeProductData($productId,$attributesArray) {
        $dataArray = [];

        foreach($attributesArray as $key => $value) {
				if($value['text'] != null) {
					 $dataArray[] = [
            	   	  'product_id' => $productId,
              		  'attribute_id' => $value['attribute_id'] ?? 2,
              		  'text' => $value['text'],
           			 ];
				}

        }
        return $dataArray;
    }

    protected function getproductImages($productId,$productImages) {
        $dataArray = [];

        foreach($productImages['sort_order_image'] as $key => $value) {
            $image = $this->saveCustomFileAndGetImageName($productImages['image'][$key],$this->path);
            $dataArray[] = [
                'product_id' => $productId,
                'sort_order_image' => $value,
                'image' => $image
            ];
        }
        return $dataArray;
    }

    protected function validateData ($request) {

        $conditionArray = [];

        $validateFields = [
            'name' => ['required'],
            'category_id' => ['required'],
            'model' => ['required'],
            'quantity' => ['required'],
            'price' => ['required'],
            'min_price' => ['required'],
            'max_price' => ['required'],
        ];

        $validationArray = array_merge($conditionArray,$validateFields);
        $this->validate($request,$validationArray);
    }

}
