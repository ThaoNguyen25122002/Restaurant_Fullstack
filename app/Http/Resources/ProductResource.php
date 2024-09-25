<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => new CategoryResource($this->whenLoaded('category')),  
            'image_url' =>  url('storage/'.$this->image_url), 
        ];
    }
}
