<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Category $category)
    {
        $posts      = Post::where('category_id', $category->id)->paginate(5);

        return \response()->json($posts);
    }

    public function store(StoreRequest $request)
    {
        $data   = $request->validated();
        $images = [];

        foreach ($data['images'] as $kay => $image) {
            $images[$kay]['path'] = ('storage/' . Storage::disk('public')->
                put('img/posts/' . $data['name'], $image));

            $images[$kay]['url'] = url($images[$kay]['path']);
        }

        unset($data['images']);

        $data['user_id'] = \auth()->user()->id;

        $post = Post::create($data);

        foreach ($images as $image) {
            Image::create([
                'url'     => $image['url'],
                'path'    => $image['path'],
                'post_id' => $post->id,
            ]);
        }
    }

    public function show(Post $post)
    {
        $categories = Category::all();
        $likes=Like::where('post_id', $post->id)->get();
        $comments=Comment::where('post_id', $post->id)->paginate(10);

        return \response()->json([
            'post'       => $post,
            'categories' => $categories,
            'likes'=>$likes,
            'comments'=>$comments,
        ]);
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $data          = $request->validated();
        $data['img_d'] = \json_decode($data['img_d'], true);
        $data['img']   = \json_decode($data['img'], true);
        $images        = [];
        $flag          = true;

        if (isset($data['images']) && ! empty($data['images'])) {
            foreach ($data['images'] as $kay => $img) {
                $images[$kay]['path'] = ('storage/' . Storage::disk('public')->
                    put('/img/posts/' . $data['name'], $img));

                $images[$kay]['url'] = \url($images[$kay]['path']);
            }
        } else {
            if (isset($data['img']) && ! empty($data['img'])) {
                $flag = false;
            } else {
                return response(['err' => 'You have not selected an image!']);
            }
        }


        if(isset($data['img_d']) && !empty($data['img_d'])){
            foreach ($data['img_d'] as $img){
                Storage::disk('public')->delete($img['path']);

                $i=Image::find($img['id']);
                $i->delete();
            }
            unset($data['img_d']);
        }

        unset($data['images']);
        unset($data['img']);
        unset($data['img_d']);

        $post->update($data);

        if($flag){
            foreach ($images as $img){
                Image::create([
                    'url'=>$img['url'],
                    'path'=>$img['path'],
                    'post_id'=>$post->id,
                ]);
            }
        }
    }

    public function destroy(Post $post)
    {
        foreach ($post->images as $img) {
            \unlink(\public_path($img['path']));
        }

        $post->images()->delete();
        Comment::where('post_id', $post->id)->delete();
        Like::where('post_id', $post->id)->delete();
        $post->delete();
    }
}
