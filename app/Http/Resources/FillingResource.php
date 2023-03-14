<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FillingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = false;
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'unit_price' => $this->unit_price,
            'min_weight' => $this->min_weight,
            'min_quantity' => $this->min_quantity,
            'updated_at' => (new DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
