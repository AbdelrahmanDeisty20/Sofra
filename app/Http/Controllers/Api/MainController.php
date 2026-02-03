<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactRequest;
use App\Http\Requests\Api\RegionRequest;
use App\Http\Requests\Api\RestaurantRequest;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Offer;
use App\Services\MainService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $mainService;

    public function __construct(MainService $mainService)
    {
        $this->mainService = $mainService;
    }

    public function cities()
    {
        $cities = $this->mainService->getCities();
        return resposeJison(status: 1, msg: 'success', data: $cities);
    }

    public function regions(RegionRequest $request)
    {
        $region = $this->mainService->getRegions($request->city_id);
        return resposeJison(status: 1, msg: 'success', data: $region);
    }

    public function restaurants()
    {
        $restaurants = $this->mainService->getRestaurants();
        return resposeJison(status: 1, msg: 'success', data: $restaurants);
    }

    public function foods(RestaurantRequest $request)
    {
        $foods = $this->mainService->getFoods($request->restaurant_id);
        return resposeJison(status: 1, msg: 'success', data: $foods);
    }

    public function restaurant(RestaurantRequest $request)
    {
        $restaurant = $this->mainService->getRestaurantDetails($request->restaurant_id);
        return resposeJison(status: 1, msg: 'success', data: $restaurant);
    }

    public function comments()
    {
        $comments = Comment::paginate(20);
        return resposeJison(status: 1, msg: 'success', data: $comments);
    }

    public function offers()
    {
        $offers = Offer::select('name', 'image')->paginate(10);
        return resposeJison(status: 1, msg: 'success', data: $offers);
    }

    public function categories()
    {
        $categories = \App\Models\Category::all();
        return resposeJison(1, 'success', $categories);
    }

    public function contacts(ContactRequest $request)
    {
        $contact = Contact::create($request->validated());
        return resposeJison(1, 'success', $contact);
    }
}
