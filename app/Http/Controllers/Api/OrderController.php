<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\NewOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function newOrder(NewOrderRequest $request)
    {
        $result = $this->orderService->createOrder($request->user(), $request->validated());
        if ($result['status'] == 0) {
            return resposeJison(0, $result['msg']);
        }
        return resposeJison(1, $result['msg'], new OrderResource($result['order']));
    }

    public function myOrders(Request $request)
    {
        $orders = $this->orderService->getMyOrders($request->user());
        return resposeJison(1, 'success', OrderResource::collection($orders)->response()->getData(true));
    }

    public function showOrder(Request $request)
    {
        $order = $this->orderService->getOrderDetails($request->order_id);
        if (!$order) {
            return resposeJison(0, 'الطلب غير موجود');
        }
        return resposeJison(1, 'success', new OrderResource($order));
    }

    public function cancelOrder(Request $request)
    {
        $result = $this->orderService->cancelOrder($request->user(), $request->order_id);
        return resposeJison($result['status'], $result['msg']);
    }

    public function acceptOrder(Request $request)
    {
        $result = $this->orderService->updateOrderState($request->user(), $request->order_id, 'accepted', ['pending'], 'تم قبول الطلب');
        return resposeJison($result['status'], $result['msg']);
    }

    public function rejectOrder(Request $request)
    {
        $result = $this->orderService->updateOrderState($request->user(), $request->order_id, 'rejected', ['pending'], 'تم رفض الطلب');
        return resposeJison($result['status'], $result['msg']);
    }

    public function deliveryOrder(Request $request)
    {
        $result = $this->orderService->updateOrderState($request->user(), $request->order_id, 'delivered', ['accepted'], 'تم تسليم الطلب');
        return resposeJison($result['status'], $result['msg']);
    }
}
