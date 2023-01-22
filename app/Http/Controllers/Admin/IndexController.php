<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $usersCount=User::all()->count();
        $categoriesCount=Category::all()->count();
        $postsCount=Post::all()->count();
        $countriesCount=Country::all()->count();


        return \response()->json([
            'usersCount'=>$usersCount,
            'categoriesCount'=>$categoriesCount,
            'postsCount'=>$postsCount,
            'countriesCount'=>$countriesCount,
        ]);
    }
}
