<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart');
        
        return view('client.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart');
        $product = $request->input('product');
        $id = $product['id'];
        $quantity = $request->input('quantity', 1);

        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $product['name'],
                'image' => $product['image'],
                'price' => $product['price'],
                'width' => 12,
                'height' => 12,
                'length' => 12,
                'quantity' => $quantity
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Product added to cart',
            'cart' => $cart,
        ]);
    }

    public function getCart()
    {
        if (session()->has('cart')) {
            $cart = session()->get('cart');

            return response()->json([
                'cart' => $cart,
            ]);
        }

        return response()->json();
    }

    public function updateCart(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity');

        $cart = session()->get('cart');
        $cart[$id]['quantity'] = $quantity;
        session()->put('cart', $cart);
        
        return response()->json([
            'message' => 'Update cart successfully',
            'cart' => $cart,
        ]);
    }

    public function removeCart(Request $request)
    {
        $cart = session()->get('cart');

        if(isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);

            return response()->json([
                'message' => 'Product removed from cart',
                'cart' => $cart
            ]);
        }

        return response()->json([
            'message' => 'Product not found in cart',
            'cart' => $cart
        ], 404);
    }
}
