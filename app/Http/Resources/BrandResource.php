<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class BrandResource extends JsonResource
{
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'slug' => $this->resource->slug
        ];
    }
}
