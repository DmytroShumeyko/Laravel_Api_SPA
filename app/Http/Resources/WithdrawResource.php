<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class WithdrawResource extends Resource
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
            'company_id' => $this->company_id,
            'description' => $this->description,
            'date' => $this->date,
            'value' => $this->value
        ];
    }
}
