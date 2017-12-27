<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserAllDataResource;
use App\Http\Resources\UserResource;
use App\Jobs\CacheData;
use App\User;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserRequest $request, User $user): UserResource
    {
        $data = tap(auth()->user())->update([
            'name' => $request->input('user.name'),
            'phone' => $request->input('user.phone'),
            'email' => $request->input('user.email'),
            'site' => $request->input('user.site'),
            'address' => $request->input('user.address'),
            'current_account' => $request->input('vendor.current_account'),
            'bank' => $request->input('user.bank'),
            'town' => $request->input('user.town'),
            'mfo' => $request->input('user.mfo'),
            'itn' => $request->input('user.itn')
        ]);
        dispatch(new CacheData(auth()->user()));
        return new UserResource($data);
    }

    /**
     * Get all user's data (vendors, companies).
     *
     * @return \App\Http\Resources\UserAllDataResource
     */
    public function getAllUserData()
    {
//        Cache::forget('data'.auth()->id());
        return Cache::rememberForever('data' . auth()->id(), function () {
            return json_encode(new UserAllDataResource(auth()->user()));
        });
    }
}
