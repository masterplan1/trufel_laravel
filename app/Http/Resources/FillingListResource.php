<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FillingListResource extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image,
            'category' => $this->category_id,
            'unit_price' => $this->unit_price,
            'min_weight' => $this->min_weight,
            'min_quantity' => $this->min_quantity,
            'updated_at' => (new DateTime($this->updated_at))->format('Y-m-d H:i'),
        ];
    }
}
