<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Barber;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function loginUser(LoginUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::where('email', $request->email)->first();
        $barber = Barber::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            return $this->sucess([
                'user' => $user,
                'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
            ]);
        }

        if ($barber && Hash::check($request->password, $barber->password)) {
            return $this->sucess([
                'barber' => $barber,
                'token' => $barber->createToken('API Token of ' . $barber->name)->plainTextToken
            ]);
        }

        return $this->error('', 'Credentials do not match', 401);
    }

    public function registerUser(StoreUserRequest $request)
    {

        if ($request->type_user === 'cliente') {
            $request->validated($request->all());
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'endereco' => $request->endereco,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'telefone' => $request->telefone,
                'type_user' => $request->type_user,
            ]);
            return $this->sucess([
                'user' => $user,
                'token' => $user->createToken('API Token of ' . $user->name)->plainTextToken
            ]);
        } else {
            if ($request->type_user !== 'cliente') {
                $request->validated($request->all());
                $barber = Barber::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'endereco' => $request->endereco,
                    'cidade' => $request->cidade,
                    'estado' => $request->estado,
                    'telefone' => $request->telefone,
                    'type_user' => $request->type_user,
                ]);
                return $this->sucess([
                    'user' => $barber,
                    'token' => $barber->createToken('API Token of ' . $barber->name)->plainTextToken
                ]);
            }
        }
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->sucess([
            'message' => 'You have secessfully been logged outand your token has been deleted ',
        ]);
    }
}
