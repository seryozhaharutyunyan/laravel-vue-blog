<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Category $category){
        $posts=Post::where('category_id', $category->id)->paginate(10);


        return \response()->json($posts);
    }

    public function show(Post $post){
        $likes=Like::where('post_id', $post->id)->get();
        $comments=Comment::where('post_id', $post->id)
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);


        return \response()->json([
            'post'=>$post,
            'comments'=>$comments,
            'likes'=>$likes,
        ]);
    }

    public function updateReviewsCount(Post $post){
        $count=$post->reviews_count+1;

        $post->update([
            'reviews_count'=>$count,
        ]);
    }
}
