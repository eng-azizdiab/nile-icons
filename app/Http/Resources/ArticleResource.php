<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'visible' => $this->visible,
            'created_at' => $this->created_at,
            'user_name' => $this->user_name, // Add user_name attribute
            'image_url' => $this->image_url, // Add image_url attribute
            'category_title' => $this->category_title, // Add category_title attribute
        ];
    }
}
