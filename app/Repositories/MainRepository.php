<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\Street;

class MainRepository
{
    public function getAllCities()
    {
        return City::all();
    }

    public function getRegionsByCity(int $cityId)
    {
        return Street::where('city_id', $cityId)->get();
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function getProductsByRestaurant(int $restaurantId)
    {
        return Product::where('restaurant_id', $restaurantId)
            ->select('name', 'price', 'image', 'details');
    }
}
