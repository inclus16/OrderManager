<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrder;
use App\Http\Requests\UpdateOrderStatus;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        return Response::json(Order::all()->load('status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrder $createOrder) : JsonResponse
    {
        $model = Order::initModel($createOrder->getDescription());
        $model->save();
        return Response::json($model->load('status'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order) : JsonResponse
    {
        return Response::json($order->load('status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(UpdateOrderStatus $udpateOrderStatus, Order $order) : JsonResponse
    {
        $order->status_id=$udpateOrderStatus->getStatusId();
        $order->save();
        return Response::json($order->load('status'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
    }
}
