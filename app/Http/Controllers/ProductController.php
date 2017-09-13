<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use App\Vendor;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Vendor $vendor
     * @return \App\Http\Resources\ProductResource
     */
    public function index(Vendor $vendor)
    {
        return ProductResource::collection($vendor->products()->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  \App\Vendor $vendor
     * @return \App\Http\Resources\ProductResource
     */
    public function store(ProductRequest $request, Vendor $vendor)
    {
        $data = $vendor->products()->save(new Product(request()->only(array_keys($request->rules()))));
        return new ProductResource($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @param  \App\Vendor $vendor
     * @return \App\Http\Resources\ProductResource
     */
    public function show(Vendor $vendor, Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  \App\Vendor $vendor
     * @param  \App\Product  $product
     * @return \App\Http\Resources\ProductResource
     */
    public function update(ProductRequest $request, Vendor $vendor, Product $product)
    {
        $product->productsHistory()->save($product->except('image','vendor_id'));
        $data = tap($product)->update(request()->only(array_keys($request->rules())));
        return new ProductResource($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor $vendor
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor, Product $product)
    {
        $product_copy = $product;
        if ($product->delete()){
            foreach($product_copy->productsHistory as $item){
                $item->delete();
            }
            return response()->json(["status" => ["Success"]], 200);
        }
        return response()->json(["error" => ["Something wont wrong"]], 500);
    }
    public static function getProducts()
    {
        return new ProductResource(auth()->user()->products);
    }
}
