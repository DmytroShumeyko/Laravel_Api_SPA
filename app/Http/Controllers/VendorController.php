<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorRequest;
use App\Http\Resources\VendorResource;
use App\Jobs\CacheData;
use App\Vendor;

class VendorController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param VendorRequest $request
     * @return VendorResource
     */
    public function store(VendorRequest $request): VendorResource
    {
        $data = auth()->user()->vendors()
            ->save(new Vendor([
                'user_id' => auth()->id(),
                'name' => $request->input('vendor.name'),
                'owner' => $request->input('vendor.owner'),
                'phone' => $request->input('vendor.phone'),
                'email' => $request->input('vendor.email'),
                'site' => $request->input('vendor.site'),
                'address' => $request->input('vendor.address'),
                'current_account' => $request->input('vendor.current_account'),
                'bank' => $request->input('vendor.bank'),
                'town' => $request->input('vendor.town'),
                'mfo' => $request->input('vendor.mfo'),
                'itn' => $request->input('vendor.itn')
            ]));
        dispatch(new CacheData());
        return new VendorResource($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VendorRequest $request
     * @param Vendor $vendor
     * @return VendorResource
     */
    public function update(VendorRequest $request, Vendor $vendor): VendorResource
    {
        $vendors = auth()->user()->vendors;
        if (!$vendors->contains('id', $vendor->id)) {
            return response()->json(["error" => ["Access denied"]], 401);
        }
        $data = tap($vendor)->update([
            'name' => $request->input('vendor.name'),
            'owner' => $request->input('vendor.owner'),
            'phone' => $request->input('vendor.phone'),
            'email' => $request->input('vendor.email'),
            'site' => $request->input('vendor.site'),
            'address' => $request->input('vendor.address'),
            'current_account' => $request->input('vendor.current_account'),
            'bank' => $request->input('vendor.bank'),
            'town' => $request->input('vendor.town'),
            'mfo' => $request->input('vendor.mfo'),
            'itn' => $request->input('vendor.itn')
        ]);
        return new VendorResource($data);
    }
}
