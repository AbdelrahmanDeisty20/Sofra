<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 1,
            'msg' => 'Success',
            'data' => [
                'counts' => [
                    'restaurants' => User::where('type', UserType::RESTAURANT)->count(),
                    'clients' => User::where('type', UserType::CLIENT)->count(),
                    'orders' => Order::count(),
                    'pending_orders' => Order::where('state', 'pending')->count(),
                ],
                'financials' => [
                    'total_sales' => (float) Order::where('state', 'delivered')->sum('total_price'),
                    'total_commissions' => (float) Order::where('state', 'delivered')->sum('commission'),
                    'total_payments' => (float) \App\Models\Payment::sum('amount'),
                    'remaining_commissions' => (float) (Order::where('state', 'delivered')->sum('commission') - \App\Models\Payment::sum('amount')),
                ]
            ]
        ]);
    }
}
