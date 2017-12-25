<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Order;
use App\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    /**
     * OrderController constructor.
     */
    public function __construct()
    {

        $this->middleware('checkCompany')->except('destroy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return OrderResource
     */
    public function store(OrderRequest $request)
    {
        $order = null;
        DB::transaction(function () use ($request, &$order) {
            $company = request()->attributes->get('company');
            $order = $company->orders()->save(new Order([
                'date' => $request->input('order.date'),
                'company_id' => $request->input('order.company_id'),
                'description' => $request->input('order.description'),
                'status' => $request->input('order.status')
            ]));

            foreach ($request->input('order.order_items') as $item) {
                $order->orderItems()->save(new OrderItem([
                    'description' => $item['description'],
                    'qtu' => $item['qtu'],
                    'product_id' => $item['product_id']
                ]));
            }
        });
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderRequest $request
     * @param Order $order
     * @return OrderResource
     */
    public function update(OrderRequest $request, Order $order)
    {
        DB::transaction(function () use ($request, &$order) {
            tap($order)->update([
                'date' => $request->input('order.date'),
                'company_id' => $request->input('order.company_id'),
                'description' => $request->input('order.description'),
                'status' => $request->input('order.status')
            ]);
            foreach ($order->orderItems as $item) {
                $item->delete();
            }
            foreach ($request->input('order.order_items') as $item) {
                $order->orderItems()->save(new OrderItem([
                    'description' => $item['description'],
                    'qtu' => $item['qtu'],
                    'product_id' => $item['product_id']
                ]));
            }
        });
        $order = Order::find($request->input('order.id'));
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return OrderResource
     */
    public function destroy(Order $order)
    {
        DB::transaction(function () use (&$order) {
            $companies = auth()->user()->companies;
            if (!$companies->contains('id', $order->company_id)) {
                return response()->json(["error" => ["Access denied"]], 401);
            }
            $order_copy = $order;
            if (tap($order)->delete()) {
                foreach ($order_copy->orderItems as $item) {
                    $item->delete();
                }
            }
        });
        return new OrderResource($order);
    }
}
