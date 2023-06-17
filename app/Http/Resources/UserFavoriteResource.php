<?php

namespace App\Http\Resources;

use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserFavoriteResource extends JsonResource
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
            'attributes' => [
                'barber_id' => $this->barber_id,
                'user_id' => $this->user_id,
            ]
        ];
    }
}
