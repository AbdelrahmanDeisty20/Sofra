<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $query = Offer::with('restaurant');

        if ($request->has('restaurant_id')) {
            $query->where('restaurant_id', $request->restaurant_id);
        }

        $offers = $query->paginate(15);
        return OfferResource::collection($offers);
    }

    public function show($id)
    {
        $offer = Offer::with('restaurant')->findOrFail($id);
        return new OfferResource($offer);
    }

    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();
        return response()->json(['message' => 'Offer deleted successfully']);
    }
}
