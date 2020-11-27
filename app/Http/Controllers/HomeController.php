<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;

class HomeController extends Controller
{

    public function index()
    {
        $products = Product::all();
        $users = User::all();
        return view('layouts.dashboard', compact(['products', 'users']));
    }
}
