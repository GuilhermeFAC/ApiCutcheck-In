<?php

namespace App\Http\Resources;

use App\Models\BarberAvailability;
use App\Models\UserAppointment;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BarberAvailabilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => (string) $this->id,
            'attributes' => [
                'barber_id' => $this->barber_id,
                'weekday' => $this->weekday,
                'active' => $this->active,
            ],
        ];

    }
}
