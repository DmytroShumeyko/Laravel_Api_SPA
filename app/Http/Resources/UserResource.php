<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request): array
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
        ];
    }
}
