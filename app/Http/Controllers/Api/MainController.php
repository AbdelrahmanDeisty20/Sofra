<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Street;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function cities()
    {
        $cities = City::all();
        return resposeJison(status: 1, msg: 'success', data: $cities);
    }
    public function regions(Request $request)
    {
        $region = Street::where(function ($query) use ($request) {
            if ($request->has('city_id')) {
                $query->where('city_id', $request->city_id);
            }
        })->get();
        return resposeJison(status: 1, msg: 'success', data: $region);
    }
    public function restaurants()
    {
        $restaurants = Restaurant::select('name', 'minimum_order', 'image', 'status', 'delivery_fees')->paginate(10);
        return resposeJison(status: 1, msg: 'success', data: $restaurants);
    }
    public function foods(Request $request)
    {
        $foods = Product::where('restaurant_id', $request->restaurant_id)
        ->select('name', 'price', 'image', 'details')
        ->paginate(10);
        return resposeJison(status: 1, msg: 'success', data: $foods);
    }
    public function restaurant(Request $request)
    {
        $restaurant = Restaurant::select('status','name','region_id','minimum_order','delivery_fees')->find($request->restaurant_id);
        return resposeJison(status: 1, msg: 'success', data: $restaurant);
    }
    public function comments()
    {
        $comments = Comment::paginate(20);
        return resposeJison(status: 1, msg: 'success', data: $comments);
    }
    public function offers()
    {
        $offers = Offer::select('name','image')->paginate(10);
        return resposeJison(status: 1, msg: 'success', data: $offers);
    }
    public function contacts(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'full_name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'subject'=>'required',
            'content'=>'required',
            'type'=>'required'
        ]);
        if ($validator->fails()) {
            return resposeJison(0,$validator->errors()->first(),$validator->errors());
        }
        $contact = Contact::create($request->all());
        return resposeJison(1,'success',$contact);
    }
}
