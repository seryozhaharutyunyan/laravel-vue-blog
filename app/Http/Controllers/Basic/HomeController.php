<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $posts=Post::orderBy('reviews_count', 'desc')->limit(5)->paginate(10);

        return \response()->json($posts);
    }

}
