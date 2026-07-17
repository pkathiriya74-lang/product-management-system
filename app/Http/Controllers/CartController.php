<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product', 'user')
            ->where('user_id', auth()->user()->id)
            ->get();
        return view('carts.index', compact('carts'));
    }
    public function addToCart($id)
    {
        try {
            $cart = Cart::where('user_id', auth()->user()->id)
                ->where('product_id', $id)->get();

            if ($cart->count() != 0) {
                return redirect('/product')->with('error', 'Product Alredy exixts in Cart');
            }
            $product = Product::with('category', 'productImages')
                ->where('id', $id)
                ->firstOrFail();
                   
            Cart::create([
                'user_id' => Auth::user()->id,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
            return redirect('/product')->with('success', 'Product added to cart.');
        } catch (\Exception $e) {
            return redirect('/product')->with('error', 'Unable to add product in cart.');
        }
    }

    public function cartUpdate($id, $action)
    {
        try {
            $cart = Cart::findOrFail($id);

            if ($action == 'inc') {
                $cart->update([
                    'quantity' => $cart->quantity + 1
                ]);
            } else {
                $cart->update([
                    'quantity' => $cart->quantity - 1
                ]);
            }

            return redirect('/cart');
        } catch (\Exception $e) {
            return redirect('/cart')->with('error', 'Unable to increase product Quantity.');
        }
    }

    public function remove($id)
    {
        try {
            $cart = Cart::findOrFail($id);
            $cart->delete();
            return redirect('/cart')->with('success', 'Product remove from cart.');
        } catch (\Exception $e) {
            return redirect('/cart')->with('error', 'Unable to remove product from cart.');
        }
    }
}
