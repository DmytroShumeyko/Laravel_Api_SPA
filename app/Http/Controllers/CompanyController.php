<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyAllDataResource;
use App\Http\Resources\CompanyResource;
use App\Jobs\CacheData;

class CompanyController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     * @return CompanyResource
     */
    public function store(CompanyRequest $request): CompanyResource
    {
        $data = auth()->user()->companies()
            ->save(new Company([
                'user_id' => auth()->id(),
                'name' => $request->input('company.name'),
                'owner' => $request->input('company.owner'),
                'phone' => $request->input('company.phone'),
                'email' => $request->input('company.email'),
                'site' => $request->input('company.site'),
                'address' => $request->input('company.address'),
                'current_account' => $request->input('company.current_account'),
                'bank' => $request->input('company.bank'),
                'town' => $request->input('company.town'),
                'mfo' => $request->input('company.mfo'),
                'itn' => $request->input('company.itn'),
                'tax' => $request->input('company.tax')
            ]));
        dispatch(new CacheData(auth()->user()));
        return new CompanyResource($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyRequest $request
     * @param Company $company
     * @return CompanyAllDataResource
     */
    public function update(CompanyRequest $request, Company $company): CompanyAllDataResource
    {
        $companies = auth()->user()->companies;
        if (!$companies->contains('id', $company->id)) {
            return response()->json(["error" => ["Access denied"]], 401);
        }
        $data = tap($company)->update([
            'name' => $request->input('company.name'),
            'owner' => $request->input('company.owner'),
            'phone' => $request->input('company.phone'),
            'email' => $request->input('company.email'),
            'site' => $request->input('company.site'),
            'address' => $request->input('company.address'),
            'current_account' => $request->input('company.current_account'),
            'bank' => $request->input('company.bank'),
            'town' => $request->input('company.town'),
            'mfo' => $request->input('company.mfo'),
            'itn' => $request->input('company.itn'),
            'tax' => $request->input('company.tax')
        ]);
        dispatch(new CacheData(auth()->user()));
        return new CompanyAllDataResource($data);
    }

    /**
     * Get all user's data (vendors, companies).
     *
     * @return CompanyAllDataResource
     */
    public function getAllCompanyData(): CompanyAllDataResource
    {
        $company = request()->attributes->get('company');
        return new CompanyAllDataResource($company);
    }
}
