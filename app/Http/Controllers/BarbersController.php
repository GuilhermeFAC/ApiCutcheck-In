<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBarberRequest;
use App\Http\Resources\BarbersResource;
use App\Models\Barber;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
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
            return new BarbersResource($barber);
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
