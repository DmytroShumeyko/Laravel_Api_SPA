<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
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
            'vendor_id' => $this->vendor_id,
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image,
            'date' => (string)$this->craated_at,
            'old_products' => ProductHistoryResource::collection($this->productsHistory),
        ];
    }
}
