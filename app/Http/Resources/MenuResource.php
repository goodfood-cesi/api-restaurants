<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource {
    public function toArray($request) {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'amount' => $this->amount,
            'description' => $this->description,
            'products' => $this->products->makeHidden(['amount', 'pivot'])
        ];
    }
}
