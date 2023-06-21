<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UserFavoriteRequest;
use App\Http\Resources\UserAppointmentResource;
use App\Http\Resources\UserFavoriteResource;
use App\Http\Resources\UsersResource;
use App\Models\Barber;
use App\Models\User;
use App\Models\UserAppointment;
use App\Models\UserFavorite;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UsersResource::collection(User::all());
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
    public function show(User $user)
    {
        return new UsersResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUserRequest $request, User $user)
    {
        $barber = Barber::where('email', $request->email)->count();
        if ($barber === 0) {
            $request->validated($request->all());

            $user->update($request->all());

            if ($request->password) {
                $user['password'] = Hash::make($request->password);
            }
            if ($request->avatar) {
                $user['avatar'] =  'http://169.46.123.222/media/avatars/' . $request->avatar;
            }
            return new UsersResource($user);
        }
        return $this->error('', 'O campo email já está sendo utilizado.', 422);
    }

    public function addFavorite(UserFavoriteRequest $request)
    {
        // Validar os dados da solicitação
        $validatedData = $request->validated();

        $userId = Auth::user()->id;
        $barberId = $validatedData['barber_id'];

        // Verificar se o registro já existe
        $existingFavorite = UserFavorite::where('user_id', $userId)
            ->where('barber_id', $barberId)
            ->first();

        if ($existingFavorite) {
            // O registro já existe, então remova-o
            $existingFavorite->delete();
            // Retorne uma resposta adequada, se necessário
            return $this->sucess(['message' => 'Retirado dos favoritos']);
        } else {
            // O registro não existe, então crie um novo registro
            UserFavorite::create([
                'user_id' => $userId,
                'barber_id' => $barberId,
            ]);
            return $this->sucess(['message' => 'Adicionado aos favoritos']);
            // Retorne uma resposta adequada, se necessário
        }
    }

    public function getAppointments($user)
    {

        $appointments = UserAppointment::with('barber', 'barberService')
            ->where('user_id', $user)
            ->get();

        return UserAppointmentResource::collection($appointments);
    }

    public function getFavorites($user)
    {

        $favorites = UserFavorite::with('barber')
            ->where('user_id', $user)
            ->get();

        return UserFavoriteResource::collection($favorites);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
