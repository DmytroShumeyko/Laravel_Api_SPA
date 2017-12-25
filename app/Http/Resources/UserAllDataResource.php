<?php

namespace App\Http\Resources;

use App\Company;
use Illuminate\Http\Resources\Json\Resource;

class UserAllDataResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'site' => $this->site,
            'address' => $this->address,
            'current_account' => $this->current_account,
            'bank' => $this->bank,
            'town' => $this->town,
            'mfo' => $this->mfo,
            'itn' => $this->itn,
            'companies' => CompanyAllDataResource::collection($this->companies),
            'vendors' => VendorResource::collection($this->vendors),
            'products' => ProductAllDataResource::collection($this->products),
            'orders' => OrderResource::collection($this->orders),
            'sales' => SaleResource::collection($this->sales),
            'chart' => Company::companiesProfitChart($this->id)
        ];
    }
}
