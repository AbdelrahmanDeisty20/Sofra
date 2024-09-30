<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Street;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MainController extends Controller
{
    public function add_product(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'details' => 'required',
            // 'image'=>'required',
            'offer_price',
            'ready' => 'required',
        ]);
        if ($validator->fails()) {
            return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
        }
        $products = Product::create($request->all());
        return resposeJison(status: 1, msg: 'success', data: $products);
    }
    public function add_offer(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'details' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'image=>required'
        ]);
        if ($validator->fails()) {
            return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
        }
        $offers = Offer::create($request->all());
        return resposeJison(status: 1, msg: 'success', data: $offers);
    }
    public function acceptOrder(Request $request)
    {
        $order = $request->user()->orders()->where('id', $request->order_id)->first();
        if (!$order) {
            return resposeJison(0, 'no orders');
        }
        $clients = Client::find($request->client_id);
        if ($order->state == 'pending') {
            $order->update([
                'state' => 'accepted',
            ]);
        }
        // $order->products()->update([
        //     'status' => 1,
        // ]);
        // $restaurants = $request->user()->orders()->restaurants()->first();
        $order->client->notifications()->create([
            'title' => 'قبول الطلب',
            'title_en' => 'accept order',
            'content' => 'لقد تم قبول الطلب',
            'content_en' => 'the order is accepted',
            'order_id' => $order->id,
            // ''=> '',
        ]);
        $tokens = $order->client->tokens()->where('token', '=!', '')->pluck('token')->toArray();
        $audience = ['inclide_players_ids', $tokens];
        $contents = [
            'en' => 'the order is accepted',
            'ar' => 'لقد تم قبول الطلب',
        ];
        $send = notifyByFirebase($audience, $contents, [
            'user_type' => 'client',
            'action' => 'accept-order',
            'order_id' => $order->id,
            'client_id' => $order->client_id,
        ]);
        return resposeJison(1, 'تم قبول الطلب بنجاح');
    }
    public function rejectOrder(Request $request)
    {
        $order = $request->user()->orders()->where('id', $request->order_id)->first();
        $clients = Client::find($request->client_id);
        if (!$order) {
            return resposeJison(0, 'no orders');
        }
        if ($order->state == 'canceled') {
            $order->update([
                'state' => 'rejected',
            ]);
        }
        // $restaurants = $request->user()->restaurants()->first();
        $order->client->notifications()->create([
            'title' => 'الغاء الطلب',
            'title_en' => 'refuse order',
            'content' => 'لقد تم الغاء الطلب',
            'content_en' => 'you have refused the order',
            'order_id' => $order->id,
        ]);
        $tokens = $order->client->tokens()->where('token', '=!', '')->pluck('token')->toArray();
        $audience = ['inclide_players_ids', $tokens];
        $contents = [
            'en' => 'you have refused the order',
            'ar' => 'لقد تم الغاء الطلب',
        ];
        $send = notifyByFirebase($audience, $contents, [
            'user_type' => 'client',
            'action' => 'refuse-order',
            'order_id' => $order->id,
            'client_id' => $order->client_id,
        ]);
        return resposeJison(1, 'تم الغاء الطلب بنجاح');
    }
    public function deliveyOrder(Request $request)
    {
        $orders = $request->user()->orders()->where('id', $request->order_id)->first();
        if (!$orders) {
            resposeJison(0, 'لايوجد طلبات');
        }
        if ($orders->state == 'accepted') {
            $orders->update([
                'state' => 'delivered',
            ]);
            $orders->client->notifications()->create([
                'title' => 'تم تسليم الطلب',
                'title_en' => 'order delivered',
                'content' => 'لقد تم تسليم الطلب',
                'content_en' => 'your order has been delivered',
                'order_id' => $orders->id,
            ]);
            $tokens = $orders->client->tokens()->where('token', '=!', '')->pluck('token')->toArray();
            $audience = ['inclide_players_ids', $tokens];
            $contents = [
                'en' => 'your order has been delivered',
                'ar' => 'لقد تم تسليم الطلب',
            ];
            $send = notifyByFirebase($audience, $contents, [
                'user_type' => 'client',
                'action' => 'delivered-order',
                'order_id' => $orders->id,
                'clien_id' => $orders->client_id
            ]);
            return resposeJison(1, 'تم تسليم الطلب بنجاح');
        }
    }
    public function myOffers(Request $request)
    {
        $offers = Offer::where('id', $request->restaurant_id)
            ->paginate(10);
        return resposeJison(1, 'success', $offers);
    }
    public function editOffer(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => Rule::unique('offers')->ignore($request->id),
            'details' => Rule::unique('offers')->ignore($request->id),
            'start_time' => Rule::unique('offers')->ignore($request->id),
            'end_time' => Rule::unique('offers')->ignore($request->id),
        ]);
        if ($validator->fails()) {
            return resposeJison(0, $validator->errors()->first(), $validator->errors());
        }
        $offers = Offer::find($request->offer_id);
        $offers->update($request->all());
        return resposeJison(1, 'تم تعديل العرض بنجاح', $offers);
    }
    public function deleteOffer(Request $request)
    {
        $offers = Offer::find($request->offer_id);
        if ($offers) {
            $offers->delete();
            return resposeJison(1, 'تم حذف العرض بنجاح');
        } else {
            return resposeJison(0, 'لا يوجد عروض');
        }
    }
    public function editProduct(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => Rule::unique('products')->ignore($request->id),
            'price' => Rule::unique('products')->ignore($request->id),
            'details' => Rule::unique('products')->ignore($request->id),
        ]);
        if ($validator->fails()) {
            return resposeJison(0, $validator->errors()->first(), $validator->errors());
        }
        $product = Product::find($request->product_id);
        $product->update($request->all());
        return resposeJison(1, 'تم تعديل المنتج بنجاح', $product);
    }
    public function deleteProduct(Request $request)
    {
        $product = Product::whereDoesntHave('order')->find($request->product_id);
        if ($product) {
            $product->delete();
            return resposeJison(1, 'تم حذف المنتج بنجاح');
        } else {
            return resposeJison(0, 'لا يمكن حذف المنتج لأن لديه طلبات مرتبطة');
        }
    }
    public function financialAccounts(Request $request)
    {
        $restaurant = Restaurant::find($request->restaurant_id);
        $orders = $restaurant->orders()->where('state', 'delivered');
        $totalPrice = $orders->sum('total_price');
        $totalCommission = $orders->sum('commission');
        $paymentsTotal = $restaurant->payments()->sum('pay');
        $amount = $totalCommission - $paymentsTotal;
        $totalCount = $orders->count();
        // return financialaccounts($totalPrice,$totalCommission,$paymentsTotal,$amount);
        return resposeJison(1, 'تم الحصول على البيانات المالية', [
            'total_price' => $totalPrice,
            'total_commission' => $totalCommission,
            'payments_total' => $paymentsTotal,
            'amount' => $amount,
            'count' => $totalCount,
            ]);
    }
    public function paid(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'pay' => 'required',
            'details' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            return resposeJison(0, $validator->errors()->first(), $validator->errors());
        }
        // $resstaurants= Restaurant::find($request->restaurant_id);
        // $resstaurants->payments()->create($request->all());
        $payments = Payment::create($request->all());
        return resposeJison(1, 'تم إضافة الدفع بنجاح', $payments);
    }
    public function myProducts(Request $request)
    {
        $products= Product::where('restaurant_id',$request->restaurant_id)->paginate(20);
        return resposeJison(1,'success',$products);
    }
}
