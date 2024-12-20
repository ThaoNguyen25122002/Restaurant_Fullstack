<?php

namespace App\Http\Controllers\Customer;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Str;
class CheckoutController extends Controller
{
    public function index(){
        $carts = CartItem::with('product') 
        ->where('user_id', Auth::id())
        ->get();
        foreach($carts as $item){
            $product = Product::findOrFail($item['product_id']);
            if($product->quantity < $item['quantity']){
                return back()->withErrors($product->product_name.' số lượng chỉ còn '.$product->quantity);
            }
        }

        return Inertia::render('Customer/Checkout/Index',[
            'carts' => $carts
        ]);
    }

    public function paymentCod(Request $request){
        // dd($request->all());
        $customerId = Auth::id();
        if($request->coupon_id != null){
            // dd(123);
            UserCoupon::create([
                'user_id' => $customerId,
                'coupon_id' => $request->coupon_id,
            ]);
            $coupon = Coupon::findOrFail($request->coupon_id);
            $coupon->used_quantity +=1;
            $coupon->save();
        }
        // dd(456);
        
        $orderData = $request->all();
        $orderCode = strtoupper(Str::random(10));
        $orderData['customer_id'] = $customerId;
        $orderData['order_code'] = $orderCode;
        // dd($orderData);
        $order = Order::create($orderData);
        $carts = CartItem::where('user_id', $customerId)
        ->get();
        foreach($carts as $item){
            $product = Product::find($item['product_id']);
            $product->quantity = $product->quantity - $item['quantity'];
            $product->sold_quantity = $product->sold_quantity + $item['quantity'];
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
            $product->save();
        }
        CartItem::where('user_id', $customerId)->delete();
        event(new OrderCreated($order));
        // dd($carts);
        return to_route('home')->with('success','Đặt hàng thành công.');
    }
  
    public function payment_vnpay(Request $request)
    {
        $orderCode = strtoupper(Str::random(10));
        // dd($request->note);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');
        $vnp_TmnCode = "MAYQCXAG"; 
        $vnp_HashSecret = "6I98YERJGR1HXAOVE6W5E15ITGW9EU3Q";
        $vnp_Inv_Address = $request->input('delivery_address'); 
        // $vnp_Inv_Note = $request->input('note'); 
        // dd($vnp_DeliveryAddress);
        session([
            'delivery_address' => $request->input('delivery_address'),
            'note' => $request->input('note'),
            'original_total_amount' => $request->input('original_total_amount'),
            'coupon_id' => $request->coupon_id,
        ]);
        $vnp_TxnRef = $orderCode; 
        $vnp_OrderInfo = 'Thanh toán đơn hàng ' . $orderCode;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->total_amount * 100; 
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $request->ip();
        // dd($request->ip());
        $inputData = [

            "vnp_Inv_Address"=>$vnp_Inv_Address,
            // "vnp_Inv_Email"=>'nlcongthao@gmail.com',
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_CreateDate" => date('YmdHis'),
            // "vnp_DeliveryAddress" => $vnp_DeliveryAddress ? $vnp_DeliveryAddress : '',
            // "vnp_DeliveryAddress" => $vnp_DeliveryAddress,
            // "vnp_Note" => $vnp_Note
            
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }               
                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                return back()->with('success',$vnp_Url);
    }
   
    public function vnpayReturn(Request $request) {
        // dd($request->all());
        $vnp_Inv_Address = session('delivery_address');
        $vnp_Note = session('note');
        $vnp_Original_Amount = session('original_total_amount');
        $vnp_Coupon_Id = session('coupon_id');
        $customerId = Auth::id();
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        // dd($vnp_Inv_Address);
        $vnp_Amount = $request->input('vnp_Amount') / 100;
        if($vnp_Coupon_Id != null){
            UserCoupon::create([
                'user_id' => $customerId,
                'coupon_id' => $vnp_Coupon_Id,
            ]);
            $coupon = Coupon::findOrFail($vnp_Coupon_Id);
            $coupon->used_quantity +=1;
            $coupon->save();
        }
        // dd($vnp_Inv_Address,$vnp_Note);
        if ($vnp_ResponseCode == "00") {
            $order = Order::create([
                'customer_id' => $customerId,
                'order_code' => $vnp_TxnRef,
                'total_amount' => $vnp_Amount,
                'original_total_amount' => $vnp_Original_Amount,
                'payment_method' => 'vnpay',
                'delivery_address' => $vnp_Inv_Address,
                'note' => $vnp_Note
            ]);
            $carts = CartItem::where('user_id', $customerId)
            ->get();
            foreach($carts as $item){
                $product = Product::find($item['product_id']);
                $product->quantity = $product->quantity - $item['quantity'];
                $product->sold_quantity = $product->sold_quantity + $item['quantity'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
                $product->save();
            }
            CartItem::where('user_id', $customerId)->delete();
            $data = $request->all();
            if($vnp_Note){
                $data['note']= $vnp_Note;
            }
            event(new OrderCreated($order));
            return inertia('Customer/Checkout/PaymentReturn', [
                'vnpData' => $data
            ]); 
        } else {
            // Thanh toán thất bại
            return to_route('home')->with('error','Đặt hàng thất bại.');
        }
    }
}
