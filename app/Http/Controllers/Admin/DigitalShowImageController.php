<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DigitalShowImage;
use App\Models\LengthClass;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductAttributeGroup;
use App\Models\ProductDescription;
use App\Models\ProductOption;
use App\Models\ProductPrice;
use App\Models\ProductRelated;
use App\Models\StockStatus;
use App\Models\TaxRate;
use App\Models\WeightClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DigitalShowImageController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $records = DigitalShowImage::orderBy('created_at', 'DESC')
            ->whereHas('owner', function ($query) use ($keyword) {
                $query->where('email', 'like', '%' . $keyword . '%');
            })
            ->with(['owner' => function ($query) use ($keyword) {
                $query->select('id', 'firstname', 'lastname', 'email');
            }])
            ->withCount('comments')->withCount(['sellers' => function ($query) {
            $query->where('heart', true);
        }])
            ->paginate($this->defaultPaginate);
        return view('admin.digital.index', ['records' => $records]);
    }

    public function createProduct($id)
    {
        $data = $this->getRequiredData();
        return view('admin.digital.add', ['data' => $data, 'id' => $id]);
    }

    public function storeProduct(Request $request, $id)
    {
        $this->validateData($request);

        $product = new Product($request->only('model', 'quantity', 'price', 'category_id', 'points', 'min_price', 'max_price', 'amount', 'power', 'change_amount', 'range_quantity', 'auto_stock_amount', 'image_profit'));

        $digital = DigitalShowImage::where('id', $id)->first();

        if ($digital) {
            $source = public_path('/uploads/user/' . $digital->image);
            $dist = public_path('/uploads/product/' . $digital->image);
            copy($source, $dist);
            $product->image = $digital->image;
        }

        $product->stock_status_id = $request->stock_status_id ? $request->stock_status_id : 0;
        $product->manufacturer_id = $request->manufacturer_id ? $request->manufacturer_id : 0;
        $product->tax_rate_id = $request->tax_rate_id ? $request->tax_rate_id : 0;
        $product->origin_price = $request->price;
        if ($request->date_available) {
            $product->date_available = $request->date_available;
        } else {
            $product->date_available = date('d/m/Y');
        }

        $product->length = $request->length ? $request->length : 0;
        $product->width = $request->width ? $request->width : 0;
        $product->height = $request->height ? $request->height : 0;
        $product->weight_class_id = $request->weight_class_id ?
        $request->weight_class_id : 0;
        $product->weight = $request->weight ? $request->weight : 0;
        $product->status = $request->status ? $request->status : 0;
        $product->sort_order = $request->sort_order ? $request->sort_order : 0;

        $product->save();

        // Save Description
        $description = new ProductDescription($request->only('name', 'description', 'meta_title', 'meta_description', 'meta_keyword'));
        $description->product_id = $product->id;
        $description->save();

        // Save Attributes
        $attributesArray = $this->getAttributeProductData($product->id, $request->attributesArray);
        if (count($attributesArray) > 0) {
            ProductRelatedAttribute::insert($attributesArray);
        }

        // Save Related Product
        $relatedProducts = $this->getRelatedProductData($product->id, $request->related_id);
        ProductRelated::insert($relatedProducts);

        // Save Product Image
        if (array_key_exists('image', $request->product_image)) {
            $productImages = $this->getproductImages($product->id, $request->product_image);
            ProductImage::insert($productImages);
        }

        // Save Product Special
        if ($request->special_price != null) {
            $specialProduct = [
                'product_id' => $product->id,
                'price' => $request->special_price,
                'start_date' => $this->changeDateFormat($request->start_date, $this->customDateFormat, $this->databaseDateFormat),
                'end_date' => $this->changeDateFormat($request->end_date, $this->customDateFormat, $this->databaseDateFormat),
            ];
            ProductSpecial::insert($specialProduct);
        }

        //save Options
        $optionArr = [];
        if ($request->optionPost) {
            $postOptions = explode(',', $request->optionPost);
            foreach ($postOptions as $key => $value) {
                for ($i = 0; $i < count($request->option[$value]['label']); $i++) {
                    if ($request->option[$value]['label'][$i] != null) {
                        $optionArr[] = [
                            'label' => $request->option[$value]['label'][$i],
                            'price' => $request->option[$value]['price'][$i],
                            'color_code' => array_key_exists('color_code', $request->option[$value]) ? $request->option[$value]['color_code'][$i] : '',
                            'option_id' => $value,
                            'product_id' => $product->id,
                        ];
                    }
                }
            }
        }

        if (count($optionArr) > 0) {
            StoreProductOption::insert($optionArr);
        }

        $today = Carbon::today();
        $new_price = new ProductPrice(array('product_id' => $product->id, 'price' => $product->price, 'date' => $today));
        $new_price->save();
        return redirect(route('digital'))->with('success', 'Product Created Successfully');
    }

    protected function getRequiredData()
    {
        $data['category'] = Category::getActivePluck();
        $data['stock_status'] = StockStatus::getActivePluck();
        $data['manufacturer'] = Manufacturer::getActivePluck();
        $data['tax_rate'] = TaxRate::getActivePluck();
        $data['lenght_class'] = LengthClass::getActivePluck();
        $data['weight_class'] = WeightClass::getActivePluck();
        $data['pluckProducts'] = ProductDescription::getActivePluck();
        $data['product_options'] = ProductOption::getActivePluck();
        $data['attributeArray'] = ProductAttributeGroup::with('relationAttributes:name,id,group_id')->has('relationAttributes')->select('name', 'id')->get();

        return $data;
    }

    protected function validateData($request)
    {

        $conditionArray = [];

        $validateFields = [
            'name' => ['required'],
            'category_id' => ['required'],
            'model' => ['required'],
            'quantity' => ['required'],
            'range_quantity' => ['required'],
            'auto_stock_amount' => ['required'],
            'price' => ['required'],
            'min_price' => ['required'],
            'max_price' => ['required'],
            'change_amount' => [],
            'image_profit' => ['required'],
        ];

        $validationArray = array_merge($conditionArray, $validateFields);
        $this->validate($request, $validationArray);
    }

    protected function getAttributeProductData($productId, $attributesArray)
    {
        $dataArray = [];

        foreach ($attributesArray as $key => $value) {
            if ($value['text'] != null) {
                $dataArray[] = [
                    'product_id' => $productId,
                    'attribute_id' => $value['attribute_id'] ?? 2,
                    'text' => $value['text'],
                ];
            }

        }
        return $dataArray;
    }

    protected function getRelatedProductData($productId, $relatedIds)
    {
        $dataArray = [];
        if (isset($relatedIds)) {
            foreach ($relatedIds as $key => $value) {
                $dataArray[] = [
                    'product_id' => $productId,
                    'related_id' => $value,
                ];
            }
        }
        return $dataArray;
    }
}
