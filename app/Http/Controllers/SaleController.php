<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Jobs\CacheData;
use App\Sale;
use App\SaleItem;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * SaleController constructor.
     */
    public function __construct()
    {

        $this->middleware('checkCompany')->except('destroy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaleRequest $request
     * @return SaleResource
     */
    public function store(SaleRequest $request)
    {
        $sale = null;
        DB::transaction(function () use ($request, &$sale) {
            $company = request()->attributes->get('company');
            $sale = $company->sales()->save(new Sale([
                'date' => $request->input('sale.date'),
                'company_id' => $request->input('sale.company_id'),
                'description' => $request->input('sale.description'),
                'price' => $request->input('sale.price'),
                'cost' => $request->input('sale.cost'),
                'payed' => $request->input('sale.payed'),
                'ttn' => $request->input('sale.ttn')
            ]));

            foreach ($request->input('sale.sale_items') as $item) {
                $sale->saleItems()->save(new SaleItem([
                    'qtu' => $item['qtu'],
                    'cost' => $item['cost'],
                    'price' => $item['price'],
                    'product_id' => $item['product_id']
                ]));
            }
        });
        dispatch(new CacheData());
        return new SaleResource($sale);
    }


    /**
     *  Update the specified resource in storage.
     *
     * @param SaleRequest $request
     * @param Sale $sale
     * @return SaleResource
     */
    public function update(SaleRequest $request, Sale $sale)
    {
        DB::transaction(function () use ($request, &$sale) {
            tap($sale)->update([
                'date' => $request->input('sale.date'),
                'company_id' => $request->input('sale.company_id'),
                'description' => $request->input('sale.description'),
                'price' => $request->input('sale.price'),
                'cost' => $request->input('sale.cost'),
                'payed' => $request->input('sale.payed'),
                'ttn' => $request->input('sale.ttn')
            ]);
            foreach ($sale->saleItems as $item) {
                $item->delete();
            }
            foreach ($request->input('sale.sale_items') as $item) {
                $sale->saleItems()->save(new saleItem([
                    'qtu' => $item['qtu'],
                    'cost' => $item['cost'],
                    'price' => $item['price'],
                    'product_id' => $item['product_id']
                ]));
            }
        });
        $sale = Sale::find($request->input('sale.id'));
        dispatch(new CacheData());
        return new SaleResource($sale);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sale $sale
     * @return mixed
     */
    public function destroy(Sale $sale)
    {
        DB::transaction(function () use (&$sale) {
            $companies = auth()->user()->companies;
            if (!$companies->contains('id', $sale->company_id)) {
                return response()->json(["error" => ["Access denied"]], 401);
            }
            $sale_copy = $sale;
            if (tap($sale)->delete()) {
                foreach ($sale_copy->saleItems as $item) {
                    $item->delete();
                }
            }
        });
        dispatch(new CacheData());
        return new SaleResource($sale);
    }
}
