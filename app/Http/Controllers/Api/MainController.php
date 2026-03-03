<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactRequest;
use App\Http\Requests\Api\RegionRequest;
use App\Http\Requests\Api\RestaurantRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\RestaurantResource;
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
        return resposeJison(1, 'success', CityResource::collection($cities));
    }

    public function regions(RegionRequest $request)
    {
        $regions = $this->mainService->getRegions($request->city_id);
        return resposeJison(1, 'success', RegionResource::collection($regions));
    }

    public function restaurants()
    {
        $restaurants = $this->mainService->getRestaurants();
        return resposeJison(1, 'success', RestaurantResource::collection($restaurants)->response()->getData(true));
    }

    public function foods(RestaurantRequest $request)
    {
        $foods = $this->mainService->getFoods($request->restaurant_id);
        return resposeJison(1, 'success', ProductResource::collection($foods)->response()->getData(true));
    }

    public function restaurant(RestaurantRequest $request)
    {
        $restaurant = $this->mainService->getRestaurantDetails($request->restaurant_id);
        return resposeJison(1, 'success', new RestaurantResource($restaurant));
    }

    public function comments()
    {
        $comments = $this->mainService->getComments();
        return resposeJison(1, 'success', CommentResource::collection($comments)->response()->getData(true));
    }

    public function offers()
    {
        $offers = $this->mainService->getOffers();
        return resposeJison(1, 'success', OfferResource::collection($offers)->response()->getData(true));
    }

    public function categories()
    {
        $categories = $this->mainService->getCategories();
        return resposeJison(1, 'success', CategoryResource::collection($categories));
    }

    public function contacts(ContactRequest $request)
    {
        $contact = $this->mainService->createContact($request->validated());
        return resposeJison(1, 'success', new ContactResource($contact));
    }
}
