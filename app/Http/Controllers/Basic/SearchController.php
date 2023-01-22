<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request){
        $data=$request->all();
        $post = Post::where('name', 'LIKE', "%{$data['text']}%")
                          ->orWhere('content', 'LIKE', "%{$data['text']}%")
                          ->paginate(5);

        return \response($post);
    }
}
