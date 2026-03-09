<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Client;
use App\Models\Comment;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Street;
use App\Models\Setting;
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
    public function comment_create(Request $request)
    {
        $validtor = validator()->make($request->all(), [
            'rate' => 'required',
            'comment' => 'required',
        ]);

        if ($validtor->fails()) {
            return resposeJison(status: 0, msg: $validtor->errors()->first(), data: $validtor->errors());
        }
        $comment = Comment::create($request->all());
        $clients = Client::find($request->client_id);
        $clients->notifications()->create([
            'title' => 'لديك تقييم جديد',
            'title_en' => 'you have a new review',
            'content' => 'لديك تقييم جديد من ' . $request->user()->name,
            'content_en' => 'you have a new review from ' . $request->user()->name,
            'comment_id' => $comment->id,
        ]);
        $tokens = $clients->tokens()->where('token', '=!', '')->pluck('token')->toArray();
        $audience = ['inclide_players_ids', $tokens];
        $contents = [
            'en' => 'you have a new review by client: ' . $request->user()->name,
            'ar' => 'لديك تقييم جديد من العميل: ' . $request->user()->name,
        ];
        $send = notifyByFirebase($audience, $contents, [
            'user_type' => 'client',
            'action' => 'comment_create',
            'comment_id' => $comment->id,
        ]);
        $send = json_decode($send);
        // $data=[
        //     'comment'=>$comment->fresh()->load('comments')
        // ];
        return resposeJison(status: 1, msg: 'success', data: $comment);
    }
    public function newOrder(Request $request)
    {
        $validatior = validator()->make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required',
            'address' => 'required',
            'payment_method' => 'required'
        ]);
        if ($validatior->fails()) {
            return resposeJison(status: 0, msg: $validatior->errors()->first(), data: $validatior->errors());
        }
        $cost = 0;
        $restaurants = Restaurant::find($request->restaurant_id);
        $delivery_cost = $restaurants->delivery_fees;
        $commission = settings()->commission_details * $cost;
        $total = $cost + $delivery_cost;
        $net = $total - settings()->commission_details;
        if ($restaurants->status == 0) {
            return resposeJison(status: 1, msg: 'عذرا المطعم غير متاح ف الوقت الحالي',);
        }
        $order = $request->user()->orders()->create([
            'restaurant_id' => $request->restaurant_id,
            'address' => $request->address,
            'payment_method' => $request->payment_method,
            'state' => 'pending',
            'note' => $request->note,
            'delivery_charge' => $delivery_cost,
            'commission' => $commission,
            'net' => $net,
            'total_price' => $cost
        ]);
        $cost = 0;
        foreach ($request->products as $i) {
            $product = Product::find($i['product_id']);
            $readyProduct = [
                $i['product_id'] => [
                    'quantity' => $i['quantity'],
                    'price' => $product->price,
                    'note' => (isset($i['note'])) ? $i['note'] : ''
                ]
            ];
            $order->products()->attach($readyProduct);
            $cost += $product->price * $i['quantity'];
        }
        if ($cost >= $restaurants->minimum_order) {
            $total = $cost + $delivery_cost;
            $commission = settings()->commission_details * $cost;
            $net = $total - settings()->commission_details;
            $order->update([
                'total' => $total,
                'net' => $net,
                'commission' => $commission,
                'delivery_charge' => $delivery_cost,
                'total_price' => $cost
            ]);
            // $request->user()->cart()->detach();
            $restaurants->notifications()->create([
                'title' => 'لديك طلب جديد',
                'title_en' => 'you have a new order',
                'content' => 'لديك طلب جديد من ' . $request->user()->name,
                'content_en' => 'you have a new order from ' . $request->user()->name,
                'order_id' => $order->id,
            ]);
            $tokens = $restaurants->tokens()->where('token', '=!', '')->pluck('token')->toArray();
            $audience = ['inclide_players_ids', $tokens];
            $contents = [
                'en' => 'you have a new order by client: ' . $request->user()->name,
                'ar' => 'لديك طلب جديد من العميل: ' . $request->user()->name,
            ];
            $send = notifyByFirebase($audience, $contents, [
                'user_type' => 'restaurant',
                'action' => 'new-order',
                'order_id' => $order->id,
            ]);
            $send = json_decode($send);
            $data = [
                'order' => $order->fresh()->load('products')
            ];
            return resposeJison(1, 'تم الطلب بنجاح', $data);
        } else {
            $order->products()->delete();
            $order->delete();
            return resposeJison(0, 'الطلب لابد ان لايكون اقل من ' . $restaurants->minimum_order);
        }
    }
    public function notifications(Request $request)
    {
        $items = $request->user()->notifications()->latest()->paginate(10);
        return resposeJison(status: 1, msg: 'loaded...', data: $items);
    }
    public function myOrders(Request $request)
    {
        $orders = $request->user()->orders()->latest()->paginate(10);

        return resposeJison(status: 1, msg: 'success', data: $orders);
    }
    public function showOrder(Request $request)
    {
        $order = Order::where('id', $request->order_id);
        if (!$order->exists()) {
            return resposeJison(status: 0, msg: 'Order not found');
        }
        $order = $order->first();
        $order->load('products');
        return resposeJison(status: 1, msg: 'success', data: $order);
    }
    public function cancleOrder(Request $request)
    {
        $order = $request->user()->orders()->where('id', $request->order_id)->first();
        if (!$order) {
            return resposeJison(0, 'لايوجد طلبات');
        }
        if (in_array($order->state, ['accepted', 'pending'])) {
            $order->update([
                'state' => 'canceled',
            ]);
        } else {
            return resposeJison(0, 'لايمكن الغاء الطلب');
        }
        // $restaurants = $request->user()->restaurants()->first();
        $order->client->notifications()->create([
            'title' => 'رفض الطلب',
            'title_en' => 'refuse order',
            'content' => 'لقد تم رفض الطلب',
            'content_en' => 'you have refused the order',
            'order_id' => $order->id,
        ]);
        $tokens = $order->client->tokens()->where('token', '=!', '')->pluck('token')->toArray();
        $audience = ['inclide_players_ids', $tokens];
        $contents = [
            'en' => 'you have refused the order',
            'ar' => 'لقد تم رفض الطلب',
        ];
        $send = notifyByFirebase($audience, $contents, [
            'user_type' => 'restaurant',
            'action' => 'refuse-order',
            'order_id' => $order->id,
            'restaurant_id' => $order->restaurant_id,
        ]);
        return resposeJison(1, 'تم رفض الطلب بنجاح');
    }
    public function activeOffer()
    {
        $offers = Offer::where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->paginate(10);
        return resposeJison(status: 1, msg: 'success', data: $offers);
    }
}
