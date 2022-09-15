<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Cron;
use App\Models\Notification;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use App\User;
use App\Models\Category;
use App\Models\CategoryDescription;
use App\Models\Banner;
use App\Models\Country;
use App\Models\BannerImage;
use App\Models\Product;
use App\Models\ProductRelatedAttribute;
use App\Models\ProductAttributeGroup;
use App\Models\ProductDescription;
use App\Models\Seller;
use App\Models\ProductRelated;
use App\Models\ProductSpecial;
use App\Models\ProductImage;
use App\Models\StoreProductOption;
use App\Models\Manufacturer;
use App\Models\Review;
use App\Models\DOD;
use App\Models\Page;
use App\Models\Trade;
use App\Models\News;
use App\Models\EnvironmentalVariable;
use Validator;
use File;
use DB;
use Auth;
use Carbon\Carbon;
use App\Models\ProductSellerRelation;


class GeneralApiController extends Controller
{

  public function __construct()
  {
  }

  public function getBannerImages() {
    try {
      $bannerImages = BannerImage::orderBy('sort_order','DESC')->get()->toArray();
      return ['status' => 1, 'images' => $bannerImages];
    } catch(\Exception $e) {
      return ['status'=> 0,'message'=>'Error'];
    }
  }

  //homepage api
  public function getHomePage() {

  try {

        $data = [];

        //homepage categories
        $categories = Category::select('category_id','image','parent_id','sort_order','status')
            ->with('categoryDescription:name,category_id,description,meta_description')
            ->where('status','1')->orderBy('sort_order','DESC')->get()->toArray();

         $data['categories'] =  buildTree($categories,0,9);

        //homepage banners
          $data['banners'] = Banner::with('images:image,sort_order,banner_id')->select('id','name','status')
          ->whereHas('images',function($q){
              $q->orderBy('sort_order','ASC');
            })->where('status','1')->where('name','Application Home Page Slider')->first();

          //homepage manufacturers
          $data['manufacturers'] = Manufacturer::select('id','name','status','sort_order','image')
          ->where('status','1')
          ->orderBy('sort_order','ASC')
          ->take(8)
          ->get();

        //homepage new arrival
        // $data['newProducts'] = Product::select('id','image','category_id', 'model','price', 'quantity','sort_order','status','date_available')
        //     ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date')
        //     ->withCount(['productReview as review_avg' => function($query) {
        //         $query->select(DB::raw('avg(rating)'));
        //       }])
        //     ->orderBy('created_at','DESC')
        //     ->where('date_available','<=',date('Y-m-d'))
        //     ->where('status','1')
        //     ->where(function($query) {
        //         $query->where('seller_id', 0)
        //             ->orWhereNull('seller_id');
        //     })
        //     ->take(4)
        //     ->get()->map(function($query) {
        //         $query->setRelation('productPrice', $query->productPrice->take(6));
        //         return $query;
        //     });

        // //homepage  Trending
        // $data['trendingProducts'] = Product::select('id','image','category_id', 'model','price', 'quantity','sort_order','status','date_available')
        //     ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date')
        //     ->withCount(['productReview as review_avg' => function($query) {
        //         $query->select(DB::raw('avg(rating)'));
        //       }])
        //     ->where('date_available','<=',date('Y-m-d'))
        //     ->where('status','1')
        //     ->where(function($query) {
        //         $query->where('seller_id', 0)
        //             ->orWhereNull('seller_id');
        //     })
        //     ->orderBy('viewed','DESC')
        //     ->take(4)
        //     ->get()->map(function($query) {
        //         $query->setRelation('productPrice', $query->productPrice->take(6));
        //         return $query;
        //     });

        //homepage DOD
        $data['dodProducts'] = DOD::select('id','product_id')
            ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date','productDetails:id,image,price,quantity,sort_order,status,date_available')
            ->withCount(['productReview as review_avg' => function($query) {
                $query->select(DB::raw('avg(rating)'));
              }])
            ->whereHas('productDetails',function($q){
                $q->where('date_available','<=',date('Y-m-d'));
                $q->where('status','1');
                $q->orderBy('sort_order','ASC');
              })
              ->whereHas('special',function($q){
                  $q->where('start_date','<=',date('Y-m-d'));
                  $q->where('end_date','>=',date('Y-m-d'));
                })
              ->take(4)
              ->get();

        return ['status'=> 1,'data'=>$data];

    } catch (\Exception $e) {
      
      return ['status'=> 0,'message'=>'Error'];
    }
  }

  //new products
  public function getNewProducts() {
    try {
      $data = Product::select('id','image','category_id', 'model','price', 'manufacturer_id', 'quantity','sort_order','status','date_available')
          ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date')
          ->withCount(['productReview as review_avg' => function($query) {
              $query->select(DB::raw('avg(rating)'));
            }])
          ->with('productManufacturer')
          ->orderBy('created_at','DESC')
          ->where('date_available','<=',date('Y-m-d'))
          ->where('status','1')
          ->where(function($query) {
              $query->where('seller_id', 0)
                  ->orWhereNull('seller_id');
          })
          ->take(20)
          ->get()
          ->map(function($query) {
              $query->setRelation('productPrice', $query->productPrice()->take(6));
              return $query;
          });
      return ['status'=> 1,'data'=>$data];
    } catch (\Exception $e) {
        return ['status'=> 0,'message'=>'Error'];
    }
  }

    //new products v1
    public function getNewProductsV1() {
        try {
            $data = Product::select('id','image','category_id', 'manufacturer_id', 'model','price', 'quantity','sort_order','status','date_available', 'created_at')
                ->with('productDescription:name,id,product_id,description','special:product_id,price,start_date,end_date')
                ->withCount(['productReview as review_avg' => function($query) {
                    $query->select(DB::raw('avg(rating)'));
                }])
                ->with('productManufacturer')
                ->orderBy('created_at','DESC')
                ->where('date_available','<=',date('Y-m-d'))
                ->where('status','1')
                ->paginate(6);

            for($i = 0; $i < count($data); $i ++) {
              if($data[$i]['created_at'] >= Carbon::parse('-24 hours')) {
                $data[$i]['new'] = true;
              } else {
                $data[$i]['new'] = false;
              }
            }
            $data->getCollection()->transform(function ($product) {
                $product->setRelation('productPrice', $product->productPrice->take(6));
                return $product;
            });
            return ['status'=> 1,'productsList'=>$data];
        } catch (\Exception $e) {
            return ['status'=> 0,'message'=>'Error'];
        }
    }

  //dod products
  public function getDODProducts() {
    try {
      $data = [];
      $data = DOD::select('id','product_id')
          ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date','productDetails:id,image,price,quantity,sort_order,status,date_available')
          ->withCount(['productReview as review_avg' => function($query) {
              $query->select(DB::raw('avg(rating)'));
            }])
          ->whereHas('productDetails',function($q){
              $q->where('date_available','<=',date('Y-m-d'));
              $q->where('status','1');
              $q->orderBy('sort_order','ASC');
            })
            ->whereHas('special',function($q){
                $q->where('start_date','<=',date('Y-m-d'));
                $q->where('end_date','>=',date('Y-m-d'));
              })
            ->take(25)
            ->get();
          return ['status'=> 1,'data'=>$data];
    } catch (\Exception $e) {
        return ['status'=> 0,'message'=>'Error'];
    }
  }

  //trending products
  public function getTrendingProducts() {
    try {
      $data = [];
      $data =Product::select('id','image','category_id', 'model','price', 'manufacturer_id', 'quantity','sort_order','status','date_available')
          ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date')
          ->with('productManufacturer')
          ->withCount(['productReview as review_avg' => function($query) {
              $query->select(DB::raw('avg(rating)'));
            }])
          ->where('date_available','<=',date('Y-m-d'))
          ->where('status','1')
          ->where(function($query) {
              $query->where('seller_id', 0)
                  ->orWhereNull('seller_id');
          })
          ->orderBy('viewed','DESC')
          ->take(20)
          ->get()
          ->map(function($query) {
              $query->setRelation('productPrice', $query->productPrice->take(6));
              return $query;
          });

          return ['status'=> 1,'data'=>$data];
    } catch (\Exception $e) {
        return ['status'=> 0,'message'=>'Error'];
    }
  }

    //trending products v1
    public function getTrendingProductsV1() {
        try {
            $data =Product::select('id','image','category_id', 'model','price', 'manufacturer_id', 'quantity','sort_order','status','date_available')
                ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date')
                ->with('productManufacturer')
                ->withCount(['productReview as review_avg' => function($query) {
                    $query->select(DB::raw('avg(rating)'));
                }])
                ->where('date_available','<=',date('Y-m-d'))
                ->where('status','1')
                ->where(function($query) {
                    $query->where('seller_id', 0)
                        ->orWhereNull('seller_id');
                })
                ->orderBy('viewed','DESC')
                ->paginate(15);
            $data->getCollection()->transform(function ($product) {
                $product->setRelation('productPrice', $product->productPrice->take(6));
                return $product;
            });
            return ['status'=> 1,'productsList'=>$data];
        } catch (\Exception $e) {
            return ['status'=> 0,'message'=>'Error'];
        }
    }

  //get categories
  public function getCategories() {
    try {
      $categories = Category::select('category_id','image','parent_id','sort_order','status')
          ->with('categoryDescription:name,category_id,description,meta_description')

          ->where('status','1')->orderBy('sort_order','ASC')->get()->toArray();

        //build tree
        $tree = buildTree($categories);

      return ['status'=> 1,'data'=>$tree];
    }
    catch (\Exception $e) {
      return ['status'=> 0,'message'=>'Error'];
    }
  }

  //get categories
  public function getManufacturers(User $user) {
    try {
      $menufacturers =Manufacturer::select('id','name','status','sort_order','image')
      ->where('status','1')
      ->orderBy('sort_order','ASC')
      ->get()
      ->toArray();

      return ['status'=> 1,'data'=>$menufacturers];
    }
    catch (\Exception $e) {
      return ['status'=> 0,'message'=>'Error'];
    }
  }

  public function getNews() {
    try {
      $news = News::orderBy('created_at', 'desc')->paginate($this->defaultPaginate);
      return ['status'=> 1,'data'=>$news];
    }
    catch (\Exception $e) {
      return ['status'=> 0,'message'=>'Error'];
    }
  }

  //search products
  public function searchProducts( Request $request) {
    try {
      $keyword = $request->get('q', '');
      $records = Product::select('id','image', 'price', 'quantity','sort_order','status', 'manufacturer_id',)
          ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date')
          ->with('productManufacturer')
          ->when($keyword , function($q) use($keyword) {
              $q->orderBy('sort_order','ASC');
              $q->whereHas('productDescription',function($q) use($keyword){
                  $q->where('name','like',"%$keyword%");
              });
          })
          ->take(10)
          ->get()
          ->map(function($query) {
              $query->setRelation('productPrice', $query->productPrice->take(6));
              return $query;
          });

      return ['status'=> 1,'data'=>$records];
    } catch (\Exception $e) {
      return ['status'=> 0,'message'=>'Error'];
    }

  }

  public function getTrades(Request $request) {
    $trade = Trade::select('quantity', 'min_reward', 'max_reward', 'quantity_trade', 'image', 'product_id', 'product_image')->get();
    return ['status' => 1, 'data' => $trade];
  }

    public function searchOtherSellersProducts(Request $request) {
        try {
            $keyword = $request->get('q', '');
            $seller_id = $request->seller_id;
            $records = Product::select('id','image', 'price', 'seller_id', 'quantity','sort_order','status', 'deleted_at', 'manufacturer_id',)

                ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date', 'seller:id,firstname,lastname,power')
                ->with('productManufacturer')
                ->when(!empty($keyword) , function($q) use($keyword) {
                    $q->whereHas('productDescription',function($q) use($keyword){
                        $q->where('name','like',"%$keyword%");
                    });
                })
                ->where(function($query) {
                    $query->where('sale', 1)
                        ->orWhere('sale_date', '<=', Carbon::parse('-6 hours'))
                        ->orWhereNull('sale_date');
                })
                ->where('seller_id', '!=', $seller_id)
                ->whereNotNull('seller_id')
                ->where('quantity', '>', 0)
                ->orderBy('sort_order','ASC')
                ->take(10)
                ->get();

            return ['status'=> 1,'data'=>$records];
        } catch (\Exception $e) {
            return ['status'=> 0,'message'=>'Error'];
        }
    }

    public function getMarketplaceProducts(Request $request) {
        // try {
            $keyword = $request->get('q', '');
            $seller_id = $request->seller_id;
            $records = ProductSellerRelation::with(['product' => function($query) use ($keyword) {
              $query->select('id','image', 'price', 'quantity','sort_order','status', 'deleted_at', 'manufacturer_id')
              ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date', 'seller:id,firstname,lastname,power')
              ->with('productManufacturer')
              ->when(!empty($keyword) , function($q) use($keyword) {
                  $q->whereHas('productDescription',function($q) use($keyword){
                    $q->where('name','like',"%$keyword%");
                  });
                });
              }])
              ->where(function($query) {
                $query->where('sale', 1)
                  ->orWhere('sale_date', '<=', Carbon::parse('-6 hours'));
              })
              ->where('quantity', '>', 0)
              ->orderBy('created_at','ASC')
              ->paginate($this->defaultPaginate);
            // $records = Product::select('id','image', 'price', 'seller_id', 'quantity','sort_order','status', 'deleted_at', 'manufacturer_id', 'origin_id')

            //     ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date', 'seller:id,firstname,lastname,power')
            //     ->with('productManufacturer')
            //     ->when(!empty($keyword) , function($q) use($keyword) {
            //         $q->whereHas('productDescription',function($q) use($keyword){
            //             $q->where('name','like',"%$keyword%");
            //         });
            //     })
            //     ->where(function($query) {
            //         $query->where('sale', 1)
            //             ->orWhere('sale_date', '<=', Carbon::parse('-6 hours'));
            //     })
            //     ->whereNotNull('seller_id')
            //     ->where('quantity', '>', 0)
            //     ->orderBy('sort_order','ASC')
            //     ->orderBy('created_at','ASC')
            //     ->paginate($this->defaultPaginate);

            return ['status'=> 1,'data'=>$records];
        // } catch (\Exception $e) {
        //     return ['status'=> 0,'message'=>'Error'];
        // }
    }

  public function productPrices($id) {
    $product = Product::where('id', $id)->first();
    return $product->productPrice()->paginate(8);
  }

  //get product details
  public function productDetails($id) {

  try {
      $data = [];
      if(Product::find($id)) {
        $relatedIds = ProductRelated::getRelatedIds($id);
        $data['reletedProducts'] = [];
        $data['productImages'] = [];
        if(count($relatedIds) > 0){
          $data['reletedProducts'] = Product::select('id','image','price', 'quantity','sort_order','status','date_available', 'manufacturer_id',)
          ->withCount(['productReview as review_avg' => function($query) {
              $query->select(DB::raw('avg(rating)'));
            }])
          ->with('productManufacturer')
          ->with('productDescription:name,id,product_id','special:product_id,price,start_date,end_date')
          ->orderBy('sort_order','ASC')
		  ->whereIn('id',$relatedIds)->get();
        }

        $productRelatedAttribute = ProductRelatedAttribute::
        join('product_attributes','product_attributes.id','=','product_related_attributes.attribute_id')
        ->join('product_attribute_groups','product_attribute_groups.id','=','product_attributes.group_id')
        ->select('product_related_attributes.*','product_attributes.group_id','product_attributes.name','product_attribute_groups.name as groupName')->where('product_related_attributes.product_id',$id)->get()->toArray();

        $result = array();
        foreach ($productRelatedAttribute as $element) {
            $result[$element['groupName']][] = $element;
        }

        $data['productAttributes'] = $result;
        $data['productSpecial'] = ProductSpecial::where('start_date','<=',date('Y-m-d'))->where('end_date','>=',date('Y-m-d'))->where('product_id',$id)->first();
        $data['productImages'] = ProductImage::where('product_id',$id)->orderBy('sort_order_image','ASC')->take(10)->get();
        $data['data'] = Product::with('category:name,category_id','productDescription:id,product_id,name,description')->findOrFail($id);
        $productOptionsData = StoreProductOption::where('product_id',$id)->select('store_product_option.*','product_options.name','product_options.type')->join('product_options','product_options.id','=','store_product_option.option_id')->get();
        $reviews = Review::where('product_id',$id)->where('status',1)->get();
        $data['totalReviews'] = count($reviews);
        $sumReview = 0;
        $star1 = 0;
        $star2 = 0;
        $star3 = 0;
        $star4 = 0;
        $star5 = 0;

        foreach ($reviews as $key => $value) {

          $sumReview += $value->rating;
          if($value->rating > 0 && $value->rating <= 1.9) {
              $star1++;
          }
          else if($value->rating >= 2 && $value->rating <= 2.9) {
            $star2++;
          }
          else if($value->rating >= 3 && $value->rating <= 3.9) {
              $star3++;
          }
          else if($value->rating >= 4 && $value->rating <= 4.9) {
              $star4++;
          }
          else if($value->rating >= 4.9 && $value->rating <= 5) {
              $star5 ++;
          }
        }

        $data['star1'] =$star1  > 0 ?   number_format($star1 / $data['totalReviews']  * 100,2) : 0;
        $data['star2'] =$star2  > 0 ? number_format($star2 / $data['totalReviews']  * 100,2) : 0;
        $data['star3'] =$star3  > 0 ? number_format($star3 / $data['totalReviews']  * 100,2) : 0;
        $data['star4'] =$star4  > 0 ? number_format($star4 / $data['totalReviews']  * 100,2) : 0;
        $data['star5'] =$star5  > 0 ? number_format($star5 / $data['totalReviews']  * 100,2) : 0;

        $data['avgReview'] = $sumReview > 0 ? number_format($sumReview/$data['totalReviews'],2) : 0;

        $productOptions = [];
        $optionName = '';
        foreach ($productOptionsData as $key => $value) {
              $productOptions[$value->name][] = $value;
        }
        $data['productOptions'] = $productOptions;

        return ['status'=> 1,'data'=>$data];
      }
      else {
        return ['status'=> 0,'data'=>'Product not found!'];
      }
     } catch (\Exception $e) {
       return ['status'=> 0,'message'=>'Error'];
    }
  }

    //increment product view count
    public function incrementProductView($id) {
      try {
          Product::where('id',$id)->increment('viewed',1);
          return ['status'=>1];
      } catch (\Exception $e) {
        return ['status'=> 0,'message'=>'Error'];
      }
    }

    //get product by category id
    public function getProductByCategory($id) {

        try {

          $ids =[(int)$id];

          //check if parent cat
          $getChildCats = Category::where('parent_id',$id)->select('category_id')->get()->toArray();

          foreach ($getChildCats as $key => $value) {
                $ids[]  =  $value['category_id'];
          }

          $data = Product::with('category:name,category_id','productDescription:id,product_id,name','special:product_id,price,start_date,end_date', 'productManufacturer')
            ->withCount(['productReview as review_avg' => function($query) {
                $query->select(DB::raw('avg(rating)'));
              }])
            ->select('id','image','category_id', 'model','price', 'quantity','sort_order','status','date_available', 'manufacturer_id')
            ->whereIn('category_id',$ids)
            ->orderBy('created_at','DESC')
            ->where('date_available','<=',date('Y-m-d'));

             if(!empty($request->filterPrice )) {
                 $data = $data->where('price','<=',$request->filterPrice);
             }
              if(!empty($request->filterPriceRange)) {
               $getRange  = explode(',',$request->filterPriceRange);
               $data = $data->where('price','>=',$getRange[0])->where('price','<=',$getRange[1]);
             }
              if(!empty($request->filterRating)) {
               $data = $data->whereHas('productReview',function($q) use($request) {
                   $q->where('rating','>=',$request->filterRating-1);
                   $q->where('rating','<=',$request->filterRating);
                 });
             }

              $data = $data->where('status','1')->paginate($this->defaultPaginate);
            $data->getCollection()->transform(function ($product) {
                $product->setRelation('productPrice', $product->productPrice->take(6));
                return $product;
            });

             return ['status'=> 1,'productsList'=>$data];

        } catch (\Exception $e) {
          return ['status'=> 0,'message'=>'Error'];
        }

    }

    // public function productRandomPrice(Request $request) {

    //     $products = Product::where('status', 1)
    //         ->where(function($query) {
    //             $query->where('seller_id', 0)
    //                 ->orWhereNull('seller_id');
    //         })
    //         ->get();

    //     $date = !empty($request->date) ? Carbon::parse($request->date) : Carbon::today();

    //     foreach ($products as $product) {
    //       $min_price = $product->min_price ?? 0;
    //       $max_price = $product->max_price ?? 1000;
    //       $random_price = rand($min_price, $max_price);
    //       $product->price = $random_price;
    //       $product->save();
    //       $new_price = new ProductPrice(array('product_id' => $product->id, 'price' => $random_price, 'date' => $date));
    //       $new_price->save();
    //       Product::where('origin_id', $product->id)->update(['price'=> $product->price]);
    //     }
    //     return ['status'=> 1,'message'=>'Updated'];
    // }

    //get product by manufacturer id
    public function getProductByManufacturer(Request $request,$id) {

      try {
        $data = Product::with('category:name,category_id','productDescription:id,product_id,name','special:product_id,price,start_date,end_date')
        ->withCount(['productReview as review_avg' => function($query) {
            $query->select(DB::raw('avg(rating)'));
          }])
        ->select('id','image','category_id', 'model','price', 'quantity','sort_order','status','date_available')
        ->whereHas('productManufacturer',function($q) use($id) {
            $q->where('id',$id);
          });

          //if filter applied
          if(!empty($request->filterPrice )) {
              $data = $data->where('price','<=',$request->filterPrice);
          }
           if(!empty($request->filterPriceRange)) {
            $getRange  = explode(',',$request->filterPriceRange);
            $data = $data->where('price','>=',$getRange[0])->where('price','<=',$getRange[1]);
          }
           if(!empty($request->filterRating)) {
            $data = $data->whereHas('productReview',function($q) use($request) {
                $q->where('rating','>=',$request->filterRating-1);
                $q->where('rating','<=',$request->filterRating);
              });
          }

          $data = $data->orderBy('created_at','DESC')
           ->where('date_available','<=',date('Y-m-d'))
           ->where('status','1')->paginate($this->defaultPaginate);

           return ['status'=> 1,'productsList'=>$data];

      } catch (\Exception $e) {
        return ['status'=> 0,'message'=>'Error'];
      }
    }

    //cms pages
    public function getPages($id) {
        try {
            $data = Page::findOrFail($id);
            if($data) {
              return ['status' => 1,'data'=>$data];
            }
            else {
              return ['status'=> 0,'message'=>'Not found!'];
            }
        } catch (\Exception $e) {
          return ['status'=> 0,'message'=>'Error'];
        }
    }

    public function something( Request $request) { // terrible naming change later.
        $env = EnvironmentalVariable::first();
        $old_products = ProductSellerRelation::where('sale', 0)
            ->Where('updated_at', '<=', Carbon::parse('-6 hours'))->get();
        foreach($old_products as $product) {
            $seconds = rand($env->min_time, $env->max_time);
            $sell_date = Carbon::now()->addSeconds($seconds);
            $product->sell_date = $sell_date;
            $product->sale = 1;
            $product->save();
        }
        $products = ProductSellerRelation::where('sell_date', '<', Carbon::now())
            ->with('product')
            ->whereNotNull('sell_date')
            ->where('quantity', '>', 0)->get();

        foreach($products as $product) {
            $amount = (float)$product->product->price * (int)$product->quantity;
            $seller = Seller::find($product->seller_id);
            if ($seller) {
              $seller_balance = (float)$seller->balance;
              if (!empty($seller)) {
                  $seller->balance = $seller_balance + $amount;
                  $seller->save();
              }
              $notification_data = array(
                  'type' => $product->points > 0 ? 'special_item_sell_auto' : 'item_sell_auto',
                  'product_id' => $product->product->id,
                  'seller_id' => $product->seller->id ?? null,
                  'quantity' => $product->quantity,
                  'price' => $product->product->price,
                  'balance' => $seller_balance,
                  'seen' => 0,
              );
              $new_notification = new Notification($notification_data);
              $new_notification->save();
            }
            $product->quantity = 0;
            $product->save();
        }

        return ['status'=> 1,'message'=> 'Success'];
    }

    public function something2( Request $request) { // terrible naming change later.

      $products = Product::whereNotNull('seller_id')->orderBy('id', 'ASC')->get();
      foreach($products as $product) {
          $origin_product = Product::whereNull('seller_id')->where('category_id', $product->category_id)->where('image', $product->image)->where('model', $product->model)->first();

          if (!empty($origin_product)) {
              $product->price = $origin_product->price;
              $product->save();
          } else {
              $origin_product = Product::find($product->origin_id);
              $product->price = $origin_product->price;
              $product->save();
          }

      }

      return ['status'=> 1,'message'=> '$products'];
    }

  }

//cat parent child function
function buildTree( $elements, $parentId = 0,$limit = 100) {
     $branch = array();
     $i= 1;
     foreach ($elements as $element) {
         if ($element['parent_id'] == $parentId) {
            if($i < $limit) {
              $children =buildTree($elements, $element['category_id']);

              if ($children) {
                  $element['children'] = $children;
              }
              $branch[] = $element;
            }
            $i++;
         }
     }

     return $branch;
 }
