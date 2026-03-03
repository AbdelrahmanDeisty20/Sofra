<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Item\OfferRequest;
use App\Http\Requests\Api\Item\ProductRequest;
use App\Http\Requests\Api\Item\UpdateOfferRequest;
use App\Http\Requests\Api\Item\UpdateProductRequest;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ProductResource;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function addProduct(ProductRequest $request)
    {
        $product = $this->itemService->addProduct($request->validated());
        return jsonResponse(1, 'تم إضافة المنتج بنجاح', new ProductResource($product));
    }

    public function editProduct(UpdateProductRequest $request)
    {
        $product = $this->itemService->editProduct($request->product_id, $request->validated());
        if (!$product) {
            return jsonResponse(0, 'المنتج غير موجود');
        }
        return jsonResponse(1, 'تم تعديل المنتج بنجاح', new ProductResource($product));
    }

    public function deleteProduct(Request $request)
    {
        $deleted = $this->itemService->deleteProduct($request->product_id);
        if ($deleted) {
            return jsonResponse(1, 'تم حذف المنتج بنجاح');
        }
        return jsonResponse(0, 'المنتج غير موجود');
    }

    public function myProducts(Request $request)
    {
        $products = $this->itemService->getMyProducts();
        return jsonResponse(1, 'success', ProductResource::collection($products)->response()->getData(true));
    }

    public function addOffer(OfferRequest $request)
    {
        $offer = $this->itemService->addOffer($request->validated());
        return jsonResponse(1, 'تم إضافة العرض بنجاح', new OfferResource($offer));
    }

    public function editOffer(UpdateOfferRequest $request)
    {
        $offer = $this->itemService->editOffer($request->offer_id, $request->validated());
        if (!$offer) {
            return jsonResponse(0, 'العرض غير موجود');
        }
        return jsonResponse(1, 'تم تعديل العرض بنجاح', new OfferResource($offer));
    }

    public function deleteOffer(Request $request)
    {
        $deleted = $this->itemService->deleteOffer($request->offer_id);
        if ($deleted) {
            return jsonResponse(1, 'تم حذف العرض بنجاح');
        }
        return jsonResponse(0, 'العرض غير موجود');
    }

    public function myOffers(Request $request)
    {
        $offers = $this->itemService->getMyOffers();
        return jsonResponse(1, 'success', OfferResource::collection($offers)->response()->getData(true));
    }

    public function financialAccounts(Request $request)
    {
        $restaurant = $request->user();
        $orders = $restaurant->orders()->where('state', 'delivered');
        $totalPrice = $orders->sum('total_price');
        $totalCommission = $orders->sum('commission');
        $paymentsTotal = $restaurant->payments()->sum('pay');
        $amount = $totalCommission - $paymentsTotal;

        return jsonResponse(1, 'تم جلب البيانات المالية', [
            'total_price' => $totalPrice,
            'total_commission' => $totalCommission,
            'payments_total' => $paymentsTotal,
            'balance' => $amount,
            'orders_count' => $orders->count(),
        ]);
    }
}
