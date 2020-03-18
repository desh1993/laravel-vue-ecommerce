<?php

namespace App\Http\Controllers;

use App\Order;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     *Fetches and Returns all the orders
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Order::with('product')->get() , 200);
    }

    /**
     * To check if order is delivered or not
     */
    public function deliverOrder(Order $order)
    {
        $order->is_delivered = true;
        $status = $order->save();
        return response()->json([
            'status' => $status ,
            'data' => $order ,
            'message' => $status ? 'Order Delivered' : 'Error in delivering Order'
        ]);
    }
    /**
     * Create a new Order Record
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
        $order = Order::create([
            'product_id' => $request->product_id , 
            'user_id' => Auth::id() , 
            'quantity' => $request->quantity , 
            'address' => $request->address , 
        ]);

        return response()->json([
            'status' => (bool) $order , 
            'data' => $order , 
            'message' => $order ? 'Successful in creating order' : 'Error in creating order'
        ]);
    }

    /**
     * Show a specific order
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return response()->json($order , 200);
    }

    /**
     * Update a specific order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //only allow to update quantity
        $status = $order->update( $request->only(['quantity']));

        // return json data
        return response()->json([
            'status' =>  $status , 
            'message' => $status ? 'Order Updated !' : 'Failed to Updated'
        ]);
    }

    /**
     * Deletes an order
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $status = $order->delete();
        return response()->json([
            'status' =>  $status , 
            'message' => $status ? 'Order Deleted !' : 'Failed to Deleted'
        ]);
    }
}
