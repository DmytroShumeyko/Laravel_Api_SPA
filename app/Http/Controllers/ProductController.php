<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductAllDataResource;
use App\Http\Resources\ProductResource;
use App\Jobs\CacheData;
use App\Product;
use App\Vendor;

class ProductController extends Controller
{

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->middleware('checkVendor')->except('destroy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return ProductResource
     */
    public function store(ProductRequest $request)
    {
        $vendor = request()->attributes->get('vendor');
        $product = $vendor->products()->save(new Product([
            'name' => $request->input('product.name'),
            'vendor_id' => $request->input('product.vendor_id'),
            'description' => $request->input('product.description'),
            'price' => $request->input('product.price'),
            'cost' => $request->input('product.cost'),
            'image' => $request->input('product.image'),
        ]));
        dispatch(new CacheData(auth()->user()));
        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return ProductAllDataResource
     */
    public function update(ProductRequest $request, Product $product)
    {
//        $product->productsHistory()->save($product->except('image', 'vendor_id'));
        tap($product)->update([
            'name' => $request->input('product.name'),
            'vendor_id' => $request->input('product.vendor_id'),
            'description' => $request->input('product.description'),
            'price' => $request->input('product.price'),
            'cost' => $request->input('product.cost'),
            'image' => $request->input('product.image'),
        ]);
        dispatch(new CacheData(auth()->user()));
        return new ProductAllDataResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Vendor $vendor
     * @param Product $product
     * @return ProductResource
     */
    public function destroy(Vendor $vendor, Product $product)
    {
        $vendors = auth()->user()->vendors;
        if (!$vendors->contains('id', $product->vendor_id)) {
            return response()->json(["error" => ["Access denied"]], 401);
        }
        $product_copy = $product;
        if (tap($product)->delete()) {
            foreach ($product_copy->productsHistory as $item) {
                $item->delete();
            }
        }
        dispatch(new CacheData(auth()->user()));
        return new ProductResource($product);
    }

    public static function getProducts()
    {
        return new ProductResource(auth()->user()->products);
    }

    public function allProducts()
    {
        return ProductResource::collection(auth()->user()->products);
    }

}
