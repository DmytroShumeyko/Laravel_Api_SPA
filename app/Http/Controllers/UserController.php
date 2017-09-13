<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserAllDataResource;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \App\Http\Resources\UserResource
     */
    public function show($id)
    {
        return new UserResource(auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  int  $id
     * @return \App\Http\Resources\UserResource
     */
    public function update(UserRequest $request, $id)
    {
        $data = tap(auth()->user())->update(request()->only(array_keys($request->rules())));
        return new UserResource($data);
    }

    /**
     * Get all user's data (vendors, companies).
     *
     * @return \App\Http\Resources\UserAllDataResource
     */
    public function getAllUserData(){
        return new UserAllDataResource(auth()->user());
    }
}