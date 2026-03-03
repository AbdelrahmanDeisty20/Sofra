<?php

namespace App\Services;

use App\Enums\UserType;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;
use App\Notifications\NewOrderAdminNotification;
use App\Notifications\NewOrderRestaurantNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class OrderService
{
    public function createOrder($user, array $data)
    {
        return \DB::transaction(function () use ($user, $data) {
            $restaurant = User::where('id', $data['restaurant_id'])->where('type', UserType::RESTAURANT)->first();
            if (!$restaurant || $restaurant->status == 0) {
                return ['status' => 0, 'msg' => 'المطعم غير متاح حالياً'];
            }

            $cost = 0;
            foreach ($data['products'] as $p) {
                $product = Product::find($p['product_id']);
                $cost += ($product->price * $p['quantity']);
            }

            if ($cost < $restaurant->minimum_order) {
                return ['status' => 0, 'msg' => 'الطلب أقل من الحد الأدنى للمطعم (' . $restaurant->minimum_order . ')'];
            }

            $delivery_cost = $restaurant->delivery_fees;
            $commission = settings()->commission_details * $cost;
            $total = $cost + $delivery_cost;
            $net = $total - $commission;

            $order = $user->orders()->create([
                'restaurant_id' => $data['restaurant_id'],
                'address' => $data['address'],
                'payment_method' => $data['payment_method'],
                'state' => 'pending',
                'note' => $data['note'] ?? '',
                'delivery_charge' => $delivery_cost,
                'commission' => $commission,
                'net' => $net,
                'total_price' => $cost
            ]);

            foreach ($data['products'] as $p) {
                $product = Product::find($p['product_id']);
                $order->products()->attach($p['product_id'], [
                    'quantity' => $p['quantity'],
                    'price' => $product->price,
                    'note' => $p['note'] ?? ''
                ]);

                // Deduct stock and check low stock
                $product->decrement('stock', $p['quantity']);
                if ($product->stock < 5) {
                    $adminUsers = User::where('type', UserType::ADMIN)->get();
                    $restaurantUser = $product->restaurant;

                    Notification::send($adminUsers, new LowStockNotification($product));
                    $restaurantUser->notify(new LowStockNotification($product));
                }
            }

            // Send notifications for new order
            $restaurant->notify(new NewOrderRestaurantNotification($order));

            $admins = User::where('type', UserType::ADMIN)->get();
            Notification::send($admins, new NewOrderAdminNotification($order));

            return ['status' => 1, 'msg' => 'تم تنفيذ الطلب بنجاح', 'order' => $order->load('products')];
        });
    }

    public function getMyOrders($user)
    {
        return $user->orders()->latest()->paginate(10);
    }

    public function getOrderDetails($orderId)
    {
        return Order::with('products', 'restaurant', 'client')->find($orderId);
    }

    public function cancelOrder($user, $orderId)
    {
        $order = $user->orders()->where('id', $orderId)->first();
        if (!$order || !in_array($order->state, ['pending', 'accepted'])) {
            return ['status' => 0, 'msg' => 'لا يمكن الغاء الطلب'];
        }

        $order->update(['state' => 'canceled']);

        $restaurant = $order->restaurant;
        if ($restaurant) {
            $restaurant->notifications()->create([
                'title' => 'إلغاء طلب',
                'content' => 'تم إلغاء الطلب من قبل العميل: ' . $user->name,
                'order_id' => $order->id,
            ]);
        }

        return ['status' => 1, 'msg' => 'تم إلغاء الطلب'];
    }

    public function updateOrderState($user, $orderId, $newState, $allowedCurrentStates, $successMsg)
    {
        $order = $user->orders()->where('id', $orderId)->first();
        if (!$order || !in_array($order->state, $allowedCurrentStates)) {
            return ['status' => 0, 'msg' => 'لا يمكن تغيير حالة هذا الطلب'];
        }

        $order->update(['state' => $newState]);

        $notificationTitle = '';
        $notificationBody = '';

        if ($newState == 'accepted') {
            $notificationTitle = 'قبول الطلب';
            $notificationBody = 'تم قبول طلبك من قبل: ' . $user->name;
        } elseif ($newState == 'rejected') {
            $notificationTitle = 'رفض الطلب';
            $notificationBody = 'تم رفض طلبك من قبل: ' . $user->name;
        } elseif ($newState == 'delivered') {
            $notificationTitle = 'تم تسليم الطلب';
            $notificationBody = 'تم تسليم طلبكم بنجاح';
        }

        $order->client->notifications()->create([
            'title' => $notificationTitle,
            'content' => $notificationBody,
            'order_id' => $order->id,
        ]);

        return ['status' => 1, 'msg' => $successMsg];
    }
}
