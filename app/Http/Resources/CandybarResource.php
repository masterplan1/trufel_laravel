<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandybarResource extends JsonResource
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
            'image' => $this->fillings[0]->image,
            'fillings' => $this->fillings,
            'min_quantity' => $this->fillings[0]->min_quantity,
            'title' => $this->name,
            'type_id' => $this->type->id,
            'type_is_candybar' => $this->type->is_candybar,
            'type_name' => $this->type->name,
            'type_weight_quantity' => $this->type->weight_quantity,
            'unit_price' => $this->fillings[0]->unit_price,
        ];
    }
}
