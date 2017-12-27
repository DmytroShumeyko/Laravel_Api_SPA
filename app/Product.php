<?php

namespace App;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function saleItem()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function productsHistory()
    {
        return $this->hasMany(ProductHistory::class);
    }

    public static function getProducts()
    {
        return auth()->user()->products;
    }

    /**
     * Product sales chart
     *
     * @param $id
     * @return array
     */
    public static function productSaleChart($id) : array
    {
        $products = Product::join('sale_items', 'sale_items.product_id', 'products.id')
            ->join('sales', 'sales.id', 'sale_items.sale_id')->where('products.id', $id)
            ->orderBy('sales.date')->get(['qtu', 'date']);
        $dates = [];
        $sales = [];
        foreach ($products as $sale) {
            if ($sale->qtu === null) {
                array_push($sales, 0);
            } else {
                array_push($sales, $sale->qtu);
            }
            array_push($dates, (string)$sale->date);
        }
        return [
            'sales' => $sales,
            'dates' => $dates,
        ];
    }

    /**
     * Product profit chart
     *
     * @param $id
     * @return array
     */
    public static function productProfitChart($id): array
    {
        $products = Product::join('sale_items', 'sale_items.product_id', 'products.id')
            ->join('sales', 'sales.id', 'sale_items.sale_id')
            ->join('companies', 'companies.id', 'sales.company_id')
            ->where('products.id', $id)
            ->selectRaw('companies.tax as tax, sales.date as date, sale_items.cost as cost, sale_items.price as price, sale_items.qtu as qtu')
            ->orderBy('sales.date')->get();
			// TODO ->groupBy('sales.date')->selectRaw(sum(companies.tax as tax)...sum...)
        $start = date('Y-m-d', strtotime($products->first()->date));
        $end = date('Y-m-d', strtotime($products->last()->date));
        $generate = self::datesArray($start, $end);
        $dates = $generate['dates'];
        $profit = $generate['values'];
        foreach ($products as $sale) {
            $sale->date = date('Y-m', strtotime($sale->date));
            foreach ($dates as $key => $value) {
                if ($value == $sale->date) {
                    if ($sale->qtu !== null) {
                        $income = round(($sale->price - $sale->cost) * $sale->qtu * $sale->tax, 2);
                        $profit[$key] += $income;
                    }
                }
            }
        }
        return [
            'profit' => $profit,
            'dates' => $dates,
        ];
    }

    /**
     * Prepare array for charts
     *
     * @param $starts
     * @param $ends
     * @return array
     */
    public static function datesArray($starts, $ends) : array
    {
        $start = date_create_from_format("Y-m-d", $starts)->modify("first day of this month");
        $end = date_create_from_format("Y-m-d", $ends)->modify("first day of this month");
        $timespan = date_interval_create_from_date_string("1 month");
        $arrDate = [];
        $values = [];
        while ($start <= $end) {
            $arrDate[] = $start->format("Y-m");
            $values[] = 0;
            $start = $start->add($timespan);
        }
        return [
            'dates' => $arrDate,
            'values' => $values
        ];
    }
}
