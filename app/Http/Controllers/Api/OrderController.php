<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\NewOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function newOrder(NewOrderRequest $request)
    {
        $restaurant = User::where('id', $request->restaurant_id)->where('type', UserType::RESTAURANT)->first();
        if (!$restaurant || $restaurant->status == 0) {
            return resposeJison(0, 'المطعم غير متاح حالياً');
        }

        $cost = 0;
        foreach ($request->products as $p) {
            $product = Product::find($p['product_id']);
            $cost += ($product->price * $p['quantity']);
        }

        if ($cost < $restaurant->minimum_order) {
            return resposeJison(0, 'الطلب أقل من الحد الأدنى للمطعم (' . $restaurant->minimum_order . ')');
        }

        $delivery_cost = $restaurant->delivery_fees;
        $commission = settings()->commission_details * $cost;
        $total = $cost + $delivery_cost;
        $net = $total - $commission;

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

        foreach ($request->products as $p) {
            $product = Product::find($p['product_id']);
            $order->products()->attach($p['product_id'], [
                'quantity' => $p['quantity'],
                'price' => $product->price,
                'note' => $p['note'] ?? ''
            ]);
        }

        $restaurant->notifications()->create([
            'title' => 'لديك طلب جديد',
            'content' => 'لديك طلب جديد من ' . $request->user()->name,
            'order_id' => $order->id,
        ]);

        return resposeJison(1, 'تم تنفيذ الطلب بنجاح', $order->load('products'));
    }

    public function myOrders(Request $request)
    {
        $orders = $request->user()->orders()->latest()->paginate(10);
        return resposeJison(1, 'success', $orders);
    }

    public function showOrder(Request $request)
    {
        $order = Order::with('products', 'restaurant', 'client')->find($request->order_id);
        if (!$order) {
            return resposeJison(0, 'الطلب غير موجود');
        }
        return resposeJison(1, 'success', $order);
    }

    public function cancelOrder(Request $request)
    {
        $order = $request->user()->orders()->where('id', $request->order_id)->first();
        if (!$order || !in_array($order->state, ['pending', 'accepted'])) {
            return resposeJison(0, 'لا يمكن الغاء الطلب');
        }

        $order->update(['state' => 'canceled']);

        $restaurant = $order->restaurant;
        if ($restaurant) {
            $restaurant->notifications()->create([
                'title' => 'إلغاء طلب',
                'content' => 'تم إلغاء الطلب من قبل العميل: ' . $request->user()->name,
                'order_id' => $order->id,
            ]);
        }

        return resposeJison(1, 'تم إلغاء الطلب');
    }

    public function acceptOrder(Request $request)
    {
        $order = $request->user()->orders()->where('id', $request->order_id)->first();
        if (!$order || $order->state !== 'pending') {
            return resposeJison(0, 'لا يمكن قبول هذا الطلب');
        }

        $order->update(['state' => 'accepted']);

        $order->client->notifications()->create([
            'title' => 'قبول الطلب',
            'content' => 'تم قبول طلبك من قبل: ' . $request->user()->name,
            'order_id' => $order->id,
        ]);

        return resposeJison(1, 'تم قبول الطلب');
    }

    public function rejectOrder(Request $request)
    {
        $order = $request->user()->orders()->where('id', $request->order_id)->first();
        if (!$order || $order->state !== 'pending') {
            return resposeJison(0, 'لا يمكن رفض هذا الطلب');
        }

        $order->update(['state' => 'rejected']);

        $order->client->notifications()->create([
            'title' => 'رفض الطلب',
            'content' => 'تم رفض طلبك من قبل: ' . $request->user()->name,
            'order_id' => $order->id,
        ]);

        return resposeJison(1, 'تم رفض الطلب');
    }

    public function deliveryOrder(Request $request)
    {
        $order = $request->user()->orders()->where('id', $request->order_id)->first();
        if (!$order || $order->state !== 'accepted') {
            return resposeJison(0, 'لا يمكن تأكيد استلام هذا الطلب');
        }

        $order->update(['state' => 'delivered']);

        $order->client->notifications()->create([
            'title' => 'تم تسليم الطلب',
            'content' => 'تم تسليم طلبكم بنجاح',
            'order_id' => $order->id,
        ]);

        return resposeJison(1, 'تم تسليم الطلب');
    }
}
