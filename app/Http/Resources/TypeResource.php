<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    public static $wrap = false;

    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'weight_quantity'   => $this->weight_quantity,
            'is_candybar'       => (bool) $this->is_candybar,
            'is_candybar_group' => (bool) $this->is_candybar_group,
            'image'             => $this->image,
        ];
    }
}
