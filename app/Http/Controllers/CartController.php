<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::find($request->id);
        $cartItem = Cart::where('product_id', $product->id)
                        ->where('user_id', auth()->id())
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            $cartItem = new Cart();
            $cartItem->product_id = $product->id;
            $cartItem->user_id = auth()->id();
            $cartItem->quantity = 1;
            $cartItem->price = $product->price;
            $cartItem->save();
        }

        return redirect()->route('cart.index');
    }

    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
        return Inertia::render('Cart/Index', [
            'cart' => $cartItems
        ]);
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cartItem = Cart::where('id', $request->id)->where('user_id', auth()->id())->first();
            if ($cartItem) {
                $cartItem->quantity = $request->quantity;
                $cartItem->save();
            }
        }
        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cartItem = Cart::where('id', $request->id)->where('user_id', auth()->id())->first();
            if ($cartItem) {
                $cartItem->delete();
            }
        }
        return redirect()->route('cart.index');
    }

    public function count()
    {
        if (Auth::check()) {
            $count = Auth::user()->carts()->count(); // Check if a user is authenticated
            return response()->json(['count' => $count]);
        } else {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }
    
    
}
