<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarberAvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string)$this->id,
            'atributes' => [
                'barber_id' => $this->barber_id,
                'weekday' => $this->weekday,
                'hours' => $this->hours,
                'active' => $this->active,
            ],
        ];
    }
}
