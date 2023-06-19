<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        if ($request->route()->getName() === 'users.getAppointments') {
            return [
                'id' => $this->id,
                'user' => new UsersResource($this->whenLoaded('user')),
                'service' => new BarberServiceResource($this->whenLoaded('barberService')),
                // Outros campos do UserAppointment que você deseja retornar
                'datetime' => $this->ap_datetime,
            ];
        } else {
            return [
                'id' => $this->id,
                'barber' => new BarbersResource($this->whenLoaded('barber')),
                'service' => new BarberServiceResource($this->whenLoaded('barberService')),
                // Outros campos do UserAppointment que você deseja retornar
                'datetime' => $this->ap_datetime,
            ];
        }
    }
}
