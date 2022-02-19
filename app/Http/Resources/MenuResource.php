<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource {
    public function toArray($request) {
        $products = $this->products->makeHidden(['amount']);
        foreach ($products as $product){
            $product->quantity = $product->pivot->quantity;
            unset($product->pivot);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'amount' => $this->amount,
            'description' => $this->description,
            'products' => $products
        ];
    }
}
