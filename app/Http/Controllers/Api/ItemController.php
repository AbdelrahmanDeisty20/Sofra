<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Item\OfferRequest;
use App\Http\Requests\Api\Item\ProductRequest;
use App\Http\Requests\Api\Item\UpdateOfferRequest;
use App\Http\Requests\Api\Item\UpdateProductRequest;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function addProduct(ProductRequest $request)
    {
        $data = $request->validated();
        $data['restaurant_id'] = $request->user()->id;
        $product = Product::create($data);

        return resposeJison(1, 'تم إضافة المنتج بنجاح', $product);
    }

    public function editProduct(UpdateProductRequest $request)
    {
        $product = $request->user()->products()->find($request->product_id);
        if (!$product) {
            return resposeJison(0, 'المنتج غير موجود');
        }

        $product->update($request->validated());
        return resposeJison(1, 'تم تعديل المنتج بنجاح', $product);
    }

    public function deleteProduct(Request $request)
    {
        $product = $request->user()->products()->find($request->product_id);
        if ($product) {
            $product->delete();
            return resposeJison(1, 'تم حذف المنتج بنجاح');
        }
        return resposeJison(0, 'المنتج غير موجود');
    }

    public function myProducts(Request $request)
    {
        $products = $request->user()->products()->latest()->paginate(20);
        return resposeJison(1, 'success', $products);
    }

    public function addOffer(OfferRequest $request)
    {
        $data = $request->validated();
        $data['restaurant_id'] = $request->user()->id;
        $offer = Offer::create($data);

        return resposeJison(1, 'تم إضافة العرض بنجاح', $offer);
    }

    public function editOffer(UpdateOfferRequest $request)
    {
        $offer = $request->user()->offers()->find($request->offer_id);
        if (!$offer) {
            return resposeJison(0, 'العرض غير موجود');
        }

        $offer->update($request->validated());
        return resposeJison(1, 'تم تعديل العرض بنجاح', $offer);
    }

    public function deleteOffer(Request $request)
    {
        $offer = $request->user()->offers()->find($request->offer_id);
        if ($offer) {
            $offer->delete();
            return resposeJison(1, 'تم حذف العرض بنجاح');
        }
        return resposeJison(0, 'العرض غير موجود');
    }

    public function myOffers(Request $request)
    {
        $offers = $request->user()->offers()->latest()->paginate(10);
        return resposeJison(1, 'success', $offers);
    }

    public function financialAccounts(Request $request)
    {
        $restaurant = $request->user();
        $orders = $restaurant->orders()->where('state', 'delivered');
        $totalPrice = $orders->sum('total_price');
        $totalCommission = $orders->sum('commission');
        $paymentsTotal = $restaurant->payments()->sum('pay');
        $amount = $totalCommission - $paymentsTotal;

        return resposeJison(1, 'تم جلب البيانات المالية', [
            'total_price' => $totalPrice,
            'total_commission' => $totalCommission,
            'payments_total' => $paymentsTotal,
            'balance' => $amount,
            'orders_count' => $orders->count(),
        ]);
    }
}
