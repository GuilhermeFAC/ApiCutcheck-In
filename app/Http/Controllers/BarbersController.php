<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BarberAvailabilityRequest;
use App\Http\Requests\BarberServiceRequest;
use App\Http\Requests\StoreBarberRequest;
use App\Http\Requests\UserAppointmentRequest;
use App\Http\Resources\BarberAvailabilityResource;
use App\Http\Resources\BarberServiceResource;
use App\Http\Resources\BarbersResource;
use App\Http\Resources\UserAppointmentResource;
use App\Models\Barber;
use App\Models\BarberAvailability;
use App\Models\BarberService;
use App\Models\User;
use App\Models\UserAppointment;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BarbersController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BarbersResource::collection(Barber::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Barber $barber)
    {
        $barber->load('barberavailability', 'barberphotos', 'barbertestimonial', 'barberservice');
        return new BarbersResource($barber);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBarberRequest  $request, Barber $barber)
    {
        $user = User::where('email', $request->email)->count();
        if ($user === 0) {
            $request->validated($request->all());

            $barber->update($request->all());

            if ($request->password) {
                $barber['password'] = Hash::make($request->password);
            }
            if ($request->avatar) {
                $barber['avatar'] =  'http://169.46.123.222/media/avatars/' . $request->avatar;
            }
            return new BarbersResource($barber);
        }
        return $this->error('', 'O campo email já está sendo utilizado.', 422);
    }

    public function updateAvailability(BarberAvailabilityRequest $request, BarberAvailability $availabilityId)
    {
        $availabilityExist = BarberAvailability::findOrFail($availabilityId->id);

        $availabilityExist->update($request->validated());

        return new BarberAvailabilityResource($availabilityExist);
    }

    public function getAvailabilities(BarberAvailability $barber)
    {
        $availabilities = BarberAvailability::where('barber_id', $barber->id)->get();

        return BarberAvailabilityResource::collection($availabilities);
    }

    public function addServices(BarberServiceRequest $request)
    {
        $request->validated($request->all());
        $service = BarberService::create([
            'barber_id' => $request->barber_id,
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return new BarberServiceResource($service);
    }

    public function getServices(BarberService $barber)
    {
        $services = BarberService::where('barber_id', $barber->id)->get();

        return BarberServiceResource::collection($services);
    }

    public function updateService(BarberServiceRequest $request, BarberService $serviceId)
    {
        $service = BarberService::findOrFail($serviceId->id);

        $service->update($request->validated());

        return new BarberServiceResource($service);
    }

    public function destroyaService(string $serviceId)
    {
        $service = BarberService::findOrFail($serviceId);
        $service->delete();
    }

    public function setAppointments(UserAppointmentRequest $request, Barber $barber)
    {
        $request->validated($request->all());
        $appointment = UserAppointment::create([
            'barber_id' => $barber->id,
            'user_id' => Auth::user()->id,
            'service_id' => $request->service_id,
            'ap_datetime' => $request->ap_datetime
        ]);

        return $this->sucess([
            'message' => 'Check-in realizado com sucesso',
        ]);
    }

    public function getAppointmentsBarbers($barber)
    {

        $appointments = UserAppointment::with('barberService', 'user')
            ->where('barber_id', $barber)
            ->get();

        return UserAppointmentResource::collection($appointments);
    }

    public function deleteAppointment($appointmentId)
{
    $appointment = UserAppointment::find($appointmentId);

    if (!$appointment) {
        return $this->error('','Check-in não encontrado', 404);
    }

    $appointment->delete();

    return $this->sucess([
        'message' => 'Check-in Cancelado',
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
