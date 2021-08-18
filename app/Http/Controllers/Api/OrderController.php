<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use App\OrderProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //orders with products based on branch selection
            $orders = Order::query();
            $orders->when(request('user_id'), function ($q) {
                return $q->where('user_id', request('user_id'));
            });
            $orders->with(['products']);
            $orders = $orders->get();
        } catch (Exception $e) {
            return response()->error('error', $e->getmessage());
        }
        return response()->success('Orders Data',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //validating comming request data
         $validatedData = Validator::make(
            $request->all(),
            [
                'cart' => 'required',
                'user_id' => 'required|numeric',
                'payment_method' => 'required',
                'status' => 'required',
                'grand_total' => 'required|numeric',
                'discount'=>'required|numeric',
            ]
        );
        //case for validation failure
        if ($validatedData->fails()) {
            return response()->error($validatedData->errors()->first(), $validatedData->errors()->getMessageBag());
        }
        //decoding json into array i-e cart data in request
        $cart = json_decode($request->cart, true);
        //adding order in db
        try {
            $order = Order::create([
                'user_id' => $request->user_id,
                'grand_total' => $request->grand_total,
                'discount' => $request->discount,
                'payment_method' => $request->payment_method,
                'status' => $request->status,
            ]);
            //adding order details in pivot table through loop
            //i-e one order can have multiple products so we will add those
            //products details one by one in pivot table through the loop below
            foreach ($cart as $cart_item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $cart_item['product_id'],
                    'price' => $cart_item['price'],
                    'quantity' => $cart_item['quantity'],
                ]);
            }

        } catch (Exception $e) {
            return response()->error('error', $e->getmessage());
        }
        return response()->success('Order Placed Successfully',true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
