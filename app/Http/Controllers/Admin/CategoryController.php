<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories=Category::all();

        return \response()->json($categories);
    }

    public function show()
    {
        $category=Category::paginate(15);

        return \response()->json($category);
    }

    public function store(StoreRequest $request)
    {
        $data=$request->validated();

        Category::firstOrCreate(['title'=>$data['title']], $data);
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $data=$request->validated();

        $category->update($data);
    }


    public function destroy(Category $category)
    {
        $category->delete();
    }
}
