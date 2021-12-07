<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\User;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request, $id)
    {
        $update_user = User::all();
        $update_user = User::find($id);

        $update_user->name = $request->name;
        $update_user->email = $request->email;

        if($request->hasFile('img')){
            $request->file('img')->move('user/',$request->file('img')->getClientOriginalName());
            $update_user->img  = $request->file('img')->getClientOriginalName();
        }

        $update_user->save();
        // dd($update_user);

        // old code
        // auth()->user()->update($request->all());
        return back()->withStatus('Profile successfully updated.');
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus('Password successfully updated.');
    }
}
