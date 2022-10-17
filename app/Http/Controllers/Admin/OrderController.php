<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\ProductDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->get('name', null);
        $filterStatus = null;
        if ($request->filterStatus && $request->filterStatus != 'all') {
            $find = OrderStatus::where('name', 'like', '%' . substr($request->filterStatus, 0, 6) . '%')->first();
            $filterStatus = $find->id;
        }

        $user = Auth::user();
        $seller = $user->seller->first();

        $records = Order::select('id', 'firstname', 'lastname', 'payment_method', 'invoice_no', 'invoice_prefix', 'shipping_name', 'order_date', 'order_status_id', 'total', 'grand_total');

        $records = $user->hasRole('Admin') || empty($seller) ? $records : $records->where('seller_id', 1);

        $records = $records->withCount('productRelation')
            ->with('orderStatus:name,id');

        if ($name) {
            $records = $records->where('firstname', 'like', "%$name%")->orWhere('email', 'like', "%$name%");
        }

        $records = $records->when($filterStatus != null, function ($q) use ($filterStatus) {
            $q->whereHas('orderStatus', function ($q) use ($filterStatus) {
                $q->where('id', $filterStatus);
            });
        });

        $records = $records->orderBy('order_date', 'DESC')->paginate($this->defaultPaginate);

        $orderStatus = OrderStatus::getActivePluck();

        return view('admin.order.index', ['records' => $records, 'orderStatus' => $orderStatus]);
    }

    public function add()
    {
        $data['customers'] = Customer::getActivePluck();
        $data['products'] = ProductDescription::getActivePluck();
        $data['country'] = Country::getActivePluck();
        $data['order_status'] = OrderStatus::getActivePluck();
        return view('admin.order.add', ['data' => $data]);
    }

    protected function validateData($request)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
        ]);
    }

    public function store(Request $request)
    {

        $this->validateData($request);

        //Order Create

        $order = new Order($request->only(Order::$fillableValue));
        $order->invoice_prefix = Order::INVOICE_PREFIX;
        $order->ip = $request->ip();
        $order->save();

        $this->createOrderProduct($order->id); //Order Product Create

        $this->createOrderHistory($order->id); //Order History Create

        return response()->json([
            'code' => 200,
            'msg' => 'Order Created Successfully',
            'route' => route('order'),
        ]
            , 200);
    }

    protected function createOrderHistory($orderId)
    {
        $orderHistory = new OrderHistory(request()->only('order_status_id', 'comment'));
        $orderHistory->order_id = $orderId;
        $orderHistory->save();
    }

    protected function createOrderProduct($orderId)
    {

        $productArray = array_filter(json_decode(request()->productData, true));
        data_set($productArray, '*.order_id', $orderId);
        OrderProduct::insert($productArray);
    }

    public function edit($id)
    {

        $data['customers'] = Customer::getActivePluck();
        $data['products'] = ProductDescription::getActivePluck();
        $data['country'] = Country::getActivePluck();
        $data['order_status'] = OrderStatus::getActivePluck();
        $data['order'] = Order::with('productRelation')->findOrFail($id);
//        dd($data['order']->toArray());
        return view('admin.order.edit', [
            'data' => $data,
        ]);
    }

    public function view(Request $request)
    {
        $order = Order::with('orderStatus:name,id', 'orderCountry:name', 'products:name,quantity,image,order_id,product_id,total')
            ->where('id', $request->id)
            ->first();
        $orderProducts = OrderProduct::where('order_id', $request->id)->get();
        $orderStatus = OrderStatus::where('status', '1')->get();
        $orderHistory = OrderHistory::where('order_id', $request->id)->orderBy('created_at', 'Desc')->get();

        return view('admin.order.view', compact('order', 'orderProducts', 'orderStatus', 'orderHistory'));

    }

    public function update(Request $request, $id)
    {

        $order = Order::findOrFail($id);
        $order->invoice_prefix = Order::INVOICE_PREFIX;
        $order->ip = $request->ip();
        $order->fill($request->only(Order::$fillableValue))->save();

        //Order Product Create
        OrderProduct::whereOrderId($order->id)->delete();
        $this->createOrderProduct($order->id);

        $this->createOrderHistory($order->id);

        return response()->json([
            'code' => 200,
            'msg' => 'Order Updated Successfully',
            'route' => route('order'),
        ]
            , 200);
    }

    public function delete($id)
    {
        if (!$data = Order::whereId($id)->first()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        OrderProduct::whereOrderId($data->id)->delete();
        OrderHistory::whereOrderId($data->id)->delete();
        $data->delete();
        return redirect(route('order'))->with('success', 'Order  Deleted Successfully');
    }

    public function updateStatus($id, Request $request)
    {

        OrderHistory::create([
            'order_id' => $id,
            'order_status_id' => $request->order_status_id,
            'comment' => $request->comment,
        ]);

        Order::where('id', $id)->update([
            'order_status_id' => $request->order_status_id,
        ]);
        return redirect()->back()->with('success', 'Order Status Successfully Updated!');

    }
}
