<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Jobs\CacheData;
use App\Payment;

class PaymentController extends Controller
{
    /**
     * PaymentController constructor.
     */
    public function __construct()
    {

        $this->middleware('checkCompany')->except('destroy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentRequest $request
     * @return PaymentResource
     */
    public function store(PaymentRequest $request): PaymentResource
    {
        $company = request()->attributes->get('company');
        $data = $company->payments()->save(new Payment([
            'date' => $request->input('payment.date'),
            'company_id' => $request->input('payment.company_id'),
            'description' => $request->input('payment.description'),
            'value' => $request->input('payment.value')
        ]));
        dispatch(new CacheData(auth()->user()));
        return new PaymentResource($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentRequest $request
     * @param Payment $payment
     * @return PaymentResource
     */
    public function update(PaymentRequest $request, Payment $payment): PaymentResource
    {
        $data = tap($payment)->update([
            'date' => $request->input('payment.date'),
            'company_id' => $request->input('payment.company_id'),
            'description' => $request->input('payment.description'),
            'value' => $request->input('payment.value')
        ]);
        dispatch(new CacheData(auth()->user()));
        return new PaymentResource($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Payment $payment
     * @return PaymentResource
     */
    public function destroy(Payment $payment): PaymentResource
    {
        $companies = auth()->user()->companies;
        if (!$companies->contains('id', $payment->company_id)) {
            return response()->json(["error" => ["Access denied"]], 401);
        }

        if (tap($payment)->delete()) {
            dispatch(new CacheData(auth()->user()));
            return new PaymentResource($payment);
        }
        return response()->json(["error" => ["Something wont wrong"]], 500);
    }
}
