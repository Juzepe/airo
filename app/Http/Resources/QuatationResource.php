<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuatationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'quotation_id' => $this->resource->id,
            'currency_id' => $this->resource->currency->code,
            'age' => $this->when($this->isIndexOrShow($request), $this->resource->age),
            'total' => $this->resource->total,
            'start_date' => $this->when($this->isIndexOrShow($request), $this->resource->start_date),
            'end_date' => $this->when($this->isIndexOrShow($request), $this->resource->end_date),
        ];
    }

    private function isIndexOrShow(Request $request): bool
    {
        return $request->routeIs('quotation.index') || $request->routeIs('quotation.show');
    }
}
