<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class StatsController extends Controller
{
   public function index()
{
    return response()->json([
        'total_users' => User::count(),
        'total_products' => Product::count(),
        'total_quantity' => Product::sum('quantity'),
        'total_amount_sold' => Product::sum('amount_sold'),
    ]);
}
}
