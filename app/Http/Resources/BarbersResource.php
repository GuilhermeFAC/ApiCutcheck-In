<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BarbersResource extends JsonResource
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
                'name' => $this->name,
                'email' => $this->email,
                'endereco' => $this->endereco,
                'cidade' => $this->cidade,
                'estado' => $this->estado,
                'telefone' => $this->telefone,
                'type_user' => $this->type_user,
                'avatar' => $this->avatar,
                'stars' => $this->stars,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
