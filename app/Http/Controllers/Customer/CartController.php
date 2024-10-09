<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    //
    public function index(){
        $carts = CartItem::with('product') 
        ->where('user_id', Auth::id())
        ->get();
        return Inertia::render('Customer/Cart/Index',[
            'carts' => $carts
        ]);
    }
    public function store(Request $request, Product $product){
        $quantity = $request->post('quantity', 1);
        $user = $request->user();
        // dd($user);
        if($user){
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }
            return back()->with('success','Đã thêm vào giỏ!');
        }else{
            // dd(123);
            return back()->withErrors(['error'=>'Vui lòng đăng nhập để thêm vào giỏ.']);
        }
        // dd($request->post('quantity'));
        // dd(123);
    }

    public function update(Request $request, CartItem $cartItem){
        // dd($cartItem);
        $quantity = $request->integer('quantity');
        $cartItem->update(['quantity' => $quantity]);
        return back();
        // dd($quantity);
    }

    public function delete(CartItem $cartItem){
        $cartItem->delete();
        // dd($cartItem);
        return back()->with('success','Đã xóa.');
    }

    public function repurchase(Request $request,$orderId){
        // dd($orderId);
        $productIds = OrderItem::where('order_id',$orderId)->pluck('product_id');
        // dd($productIds);
        $user_id = Auth::id();
        foreach($productIds as $productId){
            $cartItem = CartItem::where('user_id', $user_id)
            ->where('product_id', $productId)
            ->first();
            if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
            } else {
                CartItem::create([
                                'user_id' => $user_id,
                                'product_id' => $productId,
                                'quantity' => 1,
                                ]);
                }
        }

        return to_route('cart');
    }
}
