<?php

namespace App\Http\Resources;

use App\Models\BarberAvailability;
use App\Models\UserAppointment;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class BarbersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();
        $favorited = false;

        if ($user) {
            $favorite = UserFavorite::where('user_id', $user->id)
                ->where('barber_id', $this->id)
                ->first();

            if ($favorite) {
                $favorited = true;
            }
        }

        if ($request->route()->getName() === 'barbers.show') {
            //pegando a disponibilidade do barbeiro
            $availability = [];

            //pegando a disponibilidade crua
            $avails = BarberAvailability::where('barber_id',$this->id)->get();
            $availWeekdays = [];
            foreach($avails as $item){
                $availWeekdays[$item['weekday']] = explode(',',$item['hours']);
            }

            //pegando agendamento dos próximos 20 dias
            $appointments = [];
            $appQuery = UserAppointment::where('barber_id',$this->id)
                ->whereBetween('ap_datetime',[
                    date('Y-m-d').' 00:00:00',
                    date('Y-m-d', strtotime('+20 days')).' 23:59:59'
                ])
                ->get();

            foreach($appQuery as $appItem){
                $appointments[] = $appItem['ap_datetime'];
            }

            // gerar disponibilidade real
            for($q=0;$q<20;$q++){
                $timeItem = strtotime('+'.$q.' days');
                $weekday = date('w', $timeItem);

                if(in_array($weekday,array_keys($availWeekdays))){
                    $hours = [];
                    $dayItem = date('Y-m-d', $timeItem);

                    foreach($availWeekdays[$weekday] as $hourItem){
                        $dayFormated = $dayItem.' '.$hourItem.':00';
                        if(!in_array($dayFormated, $appointments)){
                            $hours[]=$hourItem;
                        }
                    }
                    if(count($hours) > 0){
                        $availability['dates'][] = [
                            'date' => $dayItem,
                            'hours' => $hours
                        ];
                    }
                }
            }

            return [
                'id' => (string) $this->id,
                'attributes' => [
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
                'favorited' => $favorited,
                'availabilities'=>$availability,
                'services' => BarberServiceResource::collection($this->whenLoaded('barberservice')),
                'photos' => BarberPhotosResource::collection($this->whenLoaded('barberphotos')),
                'testimonials' => BarberTestimonialResource::collection($this->whenLoaded('barbertestimonial')),
            ];
        } else {
            return [
                'id' => (string) $this->id,
                'attributes' => [
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
                ]
            ];
        }
    }
}
