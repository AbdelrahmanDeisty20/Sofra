<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::withCount('regions')->get();
        return CityResource::collection($cities);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:cities']);
        $city = City::create($request->all());
        return new CityResource($city);
    }

    public function show($id)
    {
        $city = City::with('regions')->findOrFail($id);
        return new CityResource($city);
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:cities,name,' . $id]);
        $city->update($request->all());
        return new CityResource($city);
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json(['message' => 'City deleted successfully']);
    }
}
