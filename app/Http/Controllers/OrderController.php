<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(["customer"]);

        // Get current user
        $currentUser = Auth::user();

        if ($currentUser) {
            $user_orders = $currentUser->orders;
            return view('order.index', compact("user_orders"));
        } else {
            abort(401, 'This action is unauthorized.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(["customer"]);

        // Get current user
        $currentUser = Auth::user();
        //$request->all();
        dd($request->all());
        return redirect('order');

    }

    public function reorder($id){
        $order = Order::findOrFail($id);
        return view('test', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $request->user()->authorizeRoles(["customer"]);

        // Get current user
        $currentUser = Auth::user();
        $order = Order::findOrFail($id);

        if ($currentUser->id == $order->user_id) {
            return view('order.show', compact("order"));
        } else {
            abort(401, 'This action is unauthorized.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $request->user()->authorizeRoles(['manager', 'employee', 'customer']);
        $currentUser = Auth::user();
        $order = Order::findOrFail($id);

        if ($currentUser->id == $order->user_id && $order->paid == false) {
            $order->delete();
            return redirect( 'order' );
        } else {
            abort(401, 'This action is unauthorized.');
        }
    }

    public function showDeleted(){
        $orders = Order::onlyTrashed()->get();
        return view('orders.manage', compact('orders'));
    }

    public function restore($order){
        Order::onlyTrashed()->where('id', $order)->restore();
        Order::findOrFail($order)->product()->restore();
        return redirect('order');
    }

    public function forceDelete($order){
        Order::onlyTrashed()->where('id', $order)->forceDelete();
        return redirect('order');
    }
}
