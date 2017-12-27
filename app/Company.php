<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class)->orderBy('date', 'desc');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class)->orderBy('date', 'desc');
    }

    public function withdraws()
    {
        return $this->hasMany(Withdraw::class)->orderBy('date', 'desc');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class)->orderBy('date', 'desc');
    }

    /**
     * Calculate company transactions
     *
     * @return object
     */
    public static function companyCalculate(): object
    {
        $company = request()->attributes->get('company');
        $sales = $company->sales;
        $withdraws = $company->withdraws;
        $payments = $company->payments;
        $debts = round(($sales->sum('price') - $payments->sum('value')), 2);
        $profit = round((($withdraws->sum('value') - $sales->sum('cost')) * $company->tax), 2);
        $bank_value = round(($payments->sum('value') - $withdraws->sum('value')), 2);
        $company->profit = $profit;
        $company->debts = $debts;
        $company->in_bank = $bank_value;
        return $company;
    }

    /**
     * All companies profit chart
     *
     * @param $id
     * @return array
     */
    public static function companiesProfitChart($id): array
    {
        $products = Product::join('sale_items', 'sale_items.product_id', 'products.id')
            ->join('sales', 'sales.id', 'sale_items.sale_id')
            ->join('companies', 'companies.id', 'sales.company_id')
            ->where('companies.user_id', $id)
            ->selectRaw('companies.tax as tax, sales.date as date, sale_items.cost as cost, sale_items.price as price, sale_items.qtu as qtu')
            ->orderBy('sales.date')->get();
        $start = date('Y-m-d', strtotime($products->first()->date));
        $end = date('Y-m-d', strtotime($products->last()->date));
        $generate = Product::datesArray($start, $end);
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
     * Company profit chart
     *
     * @param $id
     * @return array
     */
    public static function companyProfitChart($id): array
    {
        $products = Product::join('sale_items', 'sale_items.product_id', 'products.id')
            ->join('sales', 'sales.id', 'sale_items.sale_id')
            ->join('companies', 'companies.id', 'sales.company_id')
            ->where('companies.id', $id)
            ->selectRaw('companies.tax as tax, sales.date as date, sale_items.cost as cost, sale_items.price as price, sale_items.qtu as qtu')
            ->orderBy('sales.date')->get();
        $start = date('Y-m-d', strtotime($products->first()->date));
        $end = date('Y-m-d', strtotime($products->last()->date));
        $generate = Product::datesArray($start, $end);
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
     * Company payments chart
     *
     * @param $id
     * @return array
     */
    public static function companyPaymentsChart($id): array
    {
        $products = Product::join('sale_items', 'sale_items.product_id', 'products.id')
            ->join('sales', 'sales.id', 'sale_items.sale_id')
            ->join('companies', 'companies.id', 'sales.company_id')
            ->where('companies.id', $id)
            ->selectRaw('companies.tax as tax, sales.date as date, sale_items.cost as cost, sale_items.price as price, sale_items.qtu as qtu')
            ->orderBy('sales.date')->get();
        $company_pay = Company::join('payments','payments.company_id', 'companies.id')
            ->where('companies.id', $id)
            ->orderBy('payments.date')->get();
        $start = date('Y-m-d', strtotime($products->first()->date));
        $end = date('Y-m-d', strtotime($products->last()->date));
        $generate = Product::datesArray($start, $end);
        $dates = $generate['dates'];
        $payments = $generate['values'];
        foreach ($company_pay as $payment) {
            $payment->date = date('Y-m', strtotime($payment->date));
            foreach ($dates as $key => $value) {
                if ($value == $payment->date) {
                    if ($payment->value !== null) {
                        $income = round($payment->value, 2);
                        $payments[$key] += $income;
                    }
                }
            }
        }
        return [
            'payment' => $payments,
            'dates' => $dates,
        ];
    }
}
