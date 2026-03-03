<?php

namespace App\Services;

use App\Enums\UserType;
use App\Repositories\MainRepository;
use App\Repositories\UserRepository;

class MainService
{
    protected $mainRepo;
    protected $userRepo;

    public function __construct(MainRepository $mainRepo, UserRepository $userRepo)
    {
        $this->mainRepo = $mainRepo;
        $this->userRepo = $userRepo;
    }

    public function getCities()
    {
        return $this->mainRepo->getAllCities();
    }

    public function getRegions(int $cityId)
    {
        return $this->mainRepo->getRegionsByCity($cityId);
    }

    public function getCategories()
    {
        return $this->mainRepo->getAllCategories();
    }

    public function getRestaurants()
    {
        // Using models directly for simplicity if repo is limited, or expanding repo
        return \App\Models\Restaurant::with('region', 'category')->paginate(10);
    }

    public function getRestaurantDetails(int $id)
    {
        return \App\Models\Restaurant::with('region', 'category')->find($id);
    }

    public function getFoods(int $restaurantId)
    {
        return \App\Models\Product::where('restaurant_id', $restaurantId)->paginate(10);
    }

    public function getComments()
    {
        return \App\Models\Comment::paginate(20);
    }

    public function getOffers()
    {
        return \App\Models\Offer::select('id', 'name', 'image', 'details', 'start_time', 'end_time', 'restaurant_id')->paginate(10);
    }

    public function createContact(array $data)
    {
        return \App\Models\Contact::create($data);
    }
}
