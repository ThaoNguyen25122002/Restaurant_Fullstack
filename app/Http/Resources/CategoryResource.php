<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends JsonResource
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
            'category_name' => $this->category_name,
            'slug' => $this->slug,
            'description' => $this->description,
            'sort' => $this->sort,
            'is_show' => $this->is_show,
            'category_image' => $this->category_image ? Storage::url($this->category_image) : null,  // Tạo URL đầy đủ cho category_image
        ];
    }
}
