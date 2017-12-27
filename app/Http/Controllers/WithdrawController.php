<?php

namespace App\Http\Controllers;

use App\Http\Requests\WithdrawRequest;
use App\Http\Resources\WithdrawResource;
use App\Jobs\CacheData;
use App\Withdraw;

class WithdrawController extends Controller
{
    /**
     * WithdrawController constructor.
     */
    public function __construct()
    {

        $this->middleware('checkCompany')->except('destroy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WithdrawRequest $request
     * @return WithdrawResource
     */
    public function store(WithdrawRequest $request):WithdrawResource
    {
        $company = request()->attributes->get('company');
        $data = $company->payments()->save(new Withdraw([
            'date' => $request->input('withdraw.date'),
            'company_id' => $request->input('withdraw.company_id'),
            'description' => $request->input('withdraw.description'),
            'value' => $request->input('withdraw.value')
        ]));
        dispatch(new CacheData());
        return new WithdrawResource($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param WithdrawRequest $request
     * @param Withdraw $withdraw
     * @return WithdrawResource
     */
    public function update(WithdrawRequest $request, Withdraw $withdraw): WithdrawResource
    {
        $data = tap($withdraw)->update([
            'date' => $request->input('withdraw.date'),
            'company_id' => $request->input('withdraw.company_id'),
            'description' => $request->input('withdraw.description'),
            'value' => $request->input('withdraw.value')
        ]);
        return new WithdrawResource($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Withdraw $withdraw
     * @return WithdrawResource
     */
    public function destroy(Withdraw $withdraw)
    {
        $companies = auth()->user()->companies;
        if (!$companies->contains('id', $withdraw->company_id)) {
            return response()->json(["error" => ["Access denied"]], 401);
        }

        if (tap($withdraw)->delete()) {
            dispatch(new CacheData());
            return new WithdrawResource($withdraw);
        }
        return response()->json(["error" => ["Something wont wrong"]], 500);
    }
}
