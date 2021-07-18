<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name'          => $this->name,
            'category'      => $this->category,
            'sub_category'  => $this->sub_category,
            'image_url'     => $this->image_url,
            'description'   => $this->description,
            'price'         => $this->price,
            'is_available'  => $this->is_available,
            'created_at'    => $this->created_at->diffForHumans(),
        ];
    }
}
