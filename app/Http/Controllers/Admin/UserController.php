<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return \response()->json($users);
    }

    public function block(User $user)
    {
        if($user->block){
            $user->update(['block'=>false]);
        }else{
            $user->update(['block'=>true]);
        }
    }

    public function destroy(User $user)
    {
        \unlink(\public_path($user->img));
        $user->delete();
    }


}
