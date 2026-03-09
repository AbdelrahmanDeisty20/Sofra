<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StreetResource;
use App\Models\Street;
use Illuminate\Http\Request;

class StreetController extends Controller
{
    public function index()
    {
        $streets = Street::with('city')->get();
        return StreetResource::collection($streets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);
        $street = Street::create($request->all());
        return new StreetResource($street->load('city'));
    }

    public function show($id)
    {
        $street = Street::with('city')->findOrFail($id);
        return new StreetResource($street);
    }

    public function update(Request $request, $id)
    {
        $street = Street::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
        ]);
        $street->update($request->all());
        return new StreetResource($street->load('city'));
    }

    public function destroy($id)
    {
        $street = Street::findOrFail($id);
        $street->delete();
        return response()->json(['message' => 'Street deleted successfully']);
    }
}
