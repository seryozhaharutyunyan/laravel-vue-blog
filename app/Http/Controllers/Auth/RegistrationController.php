<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\ResetRequest;
use App\Http\Requests\Registration\StoreRequest;
use App\Http\Requests\Registration\UpdateAccountRequest;
use App\Http\Requests\Registration\UpdatePasswordRequest;
use App\Mail\PasswordMail;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function index()
    {
        $countries = Country::all();

        return \response()->json($countries);
    }

    public function store(StoreRequest $request)
    {
        $data  = $request->validated();
        $roles = Role::all();
        unset($data['edge_id']);

        $data['img']= ('storage/' . Storage::disk('public')->
            put('img/users/' . $data['email'], $data['img']));


        foreach ($roles as $role) {
            if ($role->role === 'user') {
                $data['role_id'] = $role->id;
            }
        }

        $password         = Str::random(10);
        $data['password'] = Hash::make($password);

        User::create($data);
        Mail::to($data['email'])->send(new PasswordMail($password));

        return \response('Your password has been sent to your email address.');
    }

    public function resetPassword(ResetRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        $password      = Str::random(10);
        $data_password = Hash::make($password);

        $user->update(['password' => $data_password]);
        Mail::to($data['email'])->send(new PasswordMail($password));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $data = $request->validated();

        unset($data['passwordNew_confirmation']);
        $data['passwordNew'] = Hash::make($data['passwordNew']);

        $user = \auth()->user();

        if (Hash::check($data['password'], $user->password)) {
            $user->update(['password' => $data['passwordNew']]);
        } else {
            return \response(['errors' => ['password' => ['Password is not correct']]], '422');
        }
    }

    public function updateAccount(UpdateAccountRequest $request)
    {
        $data = $request->validated();
        unset($data['edge_id']);

        $user = \auth()->user();

        if (Hash::check($data['password'], $user->password)) {
            unset($data['password']);
            if (isset($data['img']) && !empty($data['img'])) {
                \unlink(\public_path($user->img));
                $data['img'] = ('storage/' . Storage::disk('public')->
                    put('img/users/' . $user->email, $data['img']));
            }else{
                unset($data['img']);
            }
            $user->update($data);
        } else {
            return \response(['errors' => ['password' => ['Password is not correct']]], '422');
        }
    }
}
