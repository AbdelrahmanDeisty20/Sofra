<?php

namespace App\Services;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ItemService
{
    public function addProduct(array $data)
    {
        $data['restaurant_id'] = Auth::guard('api_resturant')->user()->id;
        return Product::create($data);
    }

    public function editProduct(int $id, array $data)
    {
        $product = Product::where('id', $id)
            ->where('restaurant_id', Auth::guard('api_resturant')->user()->id)
            ->first();

        if ($product) {
            $product->update($data);
        }
        return $product;
    }

    public function deleteProduct(int $id)
    {
        return Product::where('id', $id)
            ->where('restaurant_id', Auth::guard('api_resturant')->user()->id)
            ->delete();
    }

    public function getMyProducts()
    {
        return Product::where('restaurant_id', Auth::guard('api_resturant')->user()->id)->paginate(10);
    }

    public function addOffer(array $data)
    {
        $data['restaurant_id'] = Auth::guard('api_resturant')->user()->id;
        return Offer::create($data);
    }

    public function editOffer(int $id, array $data)
    {
        $offer = Offer::where('id', $id)
            ->where('restaurant_id', Auth::guard('api_resturant')->user()->id)
            ->first();

        if ($offer) {
            $offer->update($data);
        }
        return $offer;
    }

    public function deleteOffer(int $id)
    {
        return Offer::where('id', $id)
            ->where('restaurant_id', Auth::guard('api_resturant')->user()->id)
            ->delete();
    }

    public function getMyOffers()
    {
        return Offer::where('restaurant_id', Auth::guard('api_resturant')->user()->id)->paginate(10);
    }
}
