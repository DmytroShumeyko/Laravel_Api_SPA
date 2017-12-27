<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SaleItemResource extends Resource
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
            'product_id' => $this->product_id,
            'qtu' => $this->qtu,
            'cost' => $this->cost,
            'price' => $this->price,
            'date' => (string)$this->created_at
        ];
    }
}
