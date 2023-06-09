<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UsersResource;
use App\Models\Barber;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
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
                $user['avatar'] =  url('media/avatars/' . $request->avatar);
            }
            return new UsersResource($user);
        }
        return $this->error('', 'O campo email já está sendo utilizado.', 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
