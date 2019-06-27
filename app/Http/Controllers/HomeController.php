<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();
        $inventories = Inventory::all();
        $user = User::find(Auth::user()->id);

        if( $user->roles[0]->name == 'provider'){
            return view('provider.index')->with(['user' => $user, 'products' => $products]);
        }else {
            return view('client.index')->with(['user' => $user, 'inventories' => $inventories]);
        }
    }
}
