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
            $typeUser = $this->barber->type_user;

            $data = [
                'id' => $this->id,
                'user' => null, // Definimos como nulo inicialmente, preencheremos de acordo com o tipo de usuário
                'service' => new BarberServiceResource($this->whenLoaded('barberService')),
                'datetime' => $this->ap_datetime,
            ];

            if ($typeUser === 'barbearia') {
                $data['user'] = [
                    'name' => $this->user->name,
                    'avatar' => $this->user->avatar,
                    'telefone' => $this->user->telefone,
                ];
            } elseif ($typeUser === 'barbeiro') {
                $data['user'] = [
                    'name' => $this->user->name,
                    'avatar' => $this->user->avatar,
                    'endereco' => $this->user->endereco,
                    'cidade' => $this->user->cidade,
                    'telefone' => $this->user->telefone,
                ];
            }

            return $data;
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
