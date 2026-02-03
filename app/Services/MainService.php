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
        return $this->userRepo->getByType(UserType::RESTAURANT, ['name', 'minimum_order', 'image', 'status', 'delivery_fees'])->paginate(10);
    }

    public function getRestaurantDetails(int $id)
    {
        return $this->userRepo->findById($id);
    }

    public function getFoods(int $restaurantId)
    {
        return $this->mainRepo->getProductsByRestaurant($restaurantId)->paginate(10);
    }
}
