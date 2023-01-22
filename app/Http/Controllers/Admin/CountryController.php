<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\StoreRequest;
use App\Http\Requests\Country\UpdateRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index()
    {
        $category=Country::paginate(25);

        return \response()->json($category);
    }

    public function store(StoreRequest $request)
    {
        $data=$request->validated();

        Country::firstOrCreate(['name'=>$data['name']], $data);
    }

    public function update(UpdateRequest $request, Country $country)
    {
        $data=$request->validated();

        $country->update($data);
    }


    public function destroy(Country $country)
    {
        $country->delete();
    }
}
