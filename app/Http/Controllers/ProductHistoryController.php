<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductHistoryRequest;
use App\Http\Resources\ProductHistoryResource;
use App\ProductHistory;
use App\Product;

class ProductHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Product $product
     * @return \App\Http\Resources\ProductHistoryResource
     */
    public function index(Product $product)
    {
        return ProductHistoryResource::collection($product->productsHistory());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductHistoryRequest  $request
     * @param  \App\Product $product
     * @return \App\Http\Resources\ProductHistoryResource
     */
    public function store(ProductHistoryRequest $request, Product $product)
    {
        $data = $product->productsHistory()->save(new ProductHistory(request()->only(array_keys($request->rules()))));
        return new ProductHistoryResource($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductHistory  $productHistory
     * @param  \App\Product $product
     * @return \App\Http\Resources\ProductHistoryResource
     */
    public function show(Product $product, ProductHistory $productHistory)
    {
        return new ProductHistoryResource($productHistory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductHistoryRequest  $request
     * @param  \App\Product $product
     * @param  \App\ProductHistory  $productHistory
     * @return \App\Http\Resources\ProductHistoryResource
     */
    public function update(ProductHistoryRequest $request, Product $product, ProductHistory $productHistory)
    {
        $data = tap($productHistory)->update(request()->only(array_keys($request->rules())));
        return new ProductHistoryResource($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @param  \App\ProductHistory  $productHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, ProductHistory $productHistory)
    {
        if ($productHistory->delete()){
            return response()->json(["status" => ["Success"]], 200);
        }
        return response()->json(["error" => ["Something wont wrong"]], 500);
    }
}
