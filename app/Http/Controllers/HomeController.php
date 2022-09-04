<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Seller;
use App\Models\Special;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductSellerRelation;
use DB;
use Hash;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
       $user = \Auth::user();

      //  dd(Hash::make("otrix@2022AP"));

        $data = [];
        $totalInventoryBalance = 0;
        $data['totalOrders'] = Notification::select('*')->whereRelation('product', 'seller_id', '=', null)->count();

        $data['totalSale'] = Notification::select('*')->whereRelation('product', 'seller_id', '=', null)->sum(DB::raw('price * quantity'));

        $data['totalCustomer'] = Seller::count();
        $data['totalProduct'] = Product::count();
        $data['totalBalanceOfCustomer'] = Seller::whereNotNull('balance')->sum('balance');
        $records = Product::select('id','image','category_id', 'model','price', 'min_price', 'max_price', 'location', 'quantity','sort_order','status', 'points');
        $records = $user->hasRole('Admin') || empty($seller) ? $records->where('seller_id', 0)->orWhereNull('seller_id') : $records->where('seller_id', 1);
        $records = $records->get();
        for ($i = 0; $i < count($records); $i ++)
        {
          if ($records[$i]['points'] > 0) {
            $sum = Special::where('product_id',$records[$i]->id)->sum('quantity');
          } else {
            $sum = ProductSellerRelation::where([['product_id', $records[$i]->id]])->sum('quantity');
          }
          $totalInventoryBalance += $sum * $records[$i]['price'];
        }
        $data['totalInventoryBalance'] = $totalInventoryBalance;
        $data['latestOrders'] = Order::select('id','firstname', 'lastname','payment_method','shipping_name','order_status_id','total','order_date','grand_total','invoice_prefix','invoice_no')
           ->withCount('productRelation')
           ->with('orderStatus:name,id')
           ->orderBy('created_at','DESC')->take(10)->get();

        $salesChart  = Order::select(
               DB::raw('sum(grand_total) as sums'),
               DB::raw("DATE_FORMAT(order_date,'%m %Y') as months")
     )
     ->groupBy('months')
     ->whereYear('order_date',date('Y'))
     ->get();
     $buildChartArr = [];
     foreach ($salesChart as $key => $value) {

       if($value->months == '01 '.date('Y')) {
          $buildChartArr[]= ['label' =>  'January','value' => $value->sums];
          continue;
       }
        if($value->months == '02 '.date('Y')) {
          $buildChartArr[]= ['label' =>  'February','value' => $value->sums];
          continue;
       }
       if($value->months == '03 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'March','value' => $value->sums];
         continue;
       }
       if($value->months == '04 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'April','value' => $value->sums];
         continue;
       }
       if($value->months == '05 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'May','value' => $value->sums];
         continue;
       }

       if($value->months == '06 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'June','value' => $value->sums];
         continue;

       }

       if($value->months == '07 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'July','value' => $value->sums];
         continue;

       }

       if($value->months == '08 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'August','value' => $value->sums];
         continue;

       }

       if($value->months == '09 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'September','value' => $value->sums];
         continue;

       }

       if($value->months == '10 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'October','value' => $value->sums];
         continue;

       }

       if($value->months == '11 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'November','value' => $value->sums];
         continue;

       }

       if($value->months == '12 '.date('Y')) {
         $buildChartArr[]= ['label' =>  'December','value' => $value->sums];
         continue;
       }
     }

     $data['salesChartData'] = $buildChartArr;

     $customerChart  = Customer::select(
            DB::raw('count(id) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%m %Y') as months")
        )
        ->groupBy('months')
        ->whereYear('created_at',date('Y'))
        ->get();


        $buildCustomerChart = [];
        foreach ($customerChart as $key => $value) {
          if($value->months == '01 '.date('Y')) {
             $buildCustomerChart[]= ['label' =>  'January','value' => $value->sums];
             continue;
          }

          if($value->months == '02 '.date('Y')) {
             $buildCustomerChart[]= ['label' =>  'February','value' => $value->sums];
             continue;

          }


          if($value->months == '03 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'March','value' => $value->sums];
            continue;

          }

          if($value->months == '04 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'April','value' => $value->sums];
            continue;

          }

          if($value->months == '05 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'May','value' => $value->sums];
            continue;

          }

          if($value->months == '06 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'June','value' => $value->sums];
            continue;

          }

          if($value->months == '07 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'July','value' => $value->sums];
            continue;

          }

          if($value->months == '08 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'August','value' => $value->sums];
            continue;

          }

          if($value->months == '09 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'September','value' => $value->sums];
            continue;

          }


          if($value->months == '10 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'October','value' => $value->sums];
            continue;

          }

          if($value->months == '11 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'November','value' => $value->sums];
            continue;

          }


          if($value->months == '12 '.date('Y')) {
            $buildCustomerChart[]= ['label' =>  'December','value' => $value->sums];
            continue;

          }

          break;
        }

        $data['customerChartData'] = $buildCustomerChart;

      return view('dashboard',compact('data'));
    }
}
