<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Models\Order;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use \ECPay_PaymentMethod as ECPayMethod;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('order', compact('orders'));
    }
    // public function new()
    // {
    //     $oldCart = session()->has('cart') ? session()->get('cart') : null;
    //     $cart = new Cart($oldCart);
    //     return view('order',[
    //         'products'=> $oldCart->items,
    //         'totalPrice'=> $oldCart->totalPrice,
    //         'totalQty'=>$oldCart->totalQty]);
    // }
    public function new()
    {
        $oldCart = session()->has('cart') ? session()->get('cart') : null;
        $cart = new Cart($oldCart);
        // dd($cart);
        return view('order', [
            'products' => $cart->items,
            'totalPrice' => $cart->totalPrice,
            'totalQty' => $cart->totalQty,
            'order' => null, // 將 $order 變數添加到視圖中，這樣它就不會是未定義的了

        ]);

        // return view('cart', [
        //     'cart' => $oldCart ?? null,
        //     'totalPrice' => optional($oldCart)->totalPrice ?? 0,
        //     'totalQty' => session('cartQuantity') ?? optional($oldCart)->totalQty ?? 0,
        // ]);
    }


    public function store()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        $cart = session()->get('cart');
        // dd($cart);
        $uuid_temp = str_replace("-", "", substr(Str::uuid()->toString(), 0, 18));
        // $order = Order::create([
        //     'name' => request('name'),
        //     'email' => request('email'),
        //     'cart' => json_encode($cart),
        //     'uuid' => $uuid_temp
        //     ]);
        $orderItems = [];

        // 根據商品名稱查詢相關資訊
        foreach ($cart->items as $productId => $item) {
            $product = Product::find($productId);

            if ($product) {
                // 將商品資訊添加到訂單項目中
                $orderItems[] = [
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    // 其他可能需要的商品資訊
                ];
            }
        }

        // 建立訂單，將訂單項目轉為 JSON 字串
        $order = Order::create([
            'name' => request('name'),
            'email' => request('email'),
            'cart' => json_encode($orderItems),
            'uuid' => $uuid_temp,
        ]);

        session()->flash('success', 'Order success!');

        try {
            $obj = new \ECPay_AllInOne();

            //服務參數
            $obj->ServiceURL = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";   //服務位置
            $obj->HashKey = '5294y06JbISpM5x9';                                           //測試用Hashkey，請自行帶入ECPay提供的HashKey
            $obj->HashIV = 'v77hoKGq4kWxNNIS';                                           //測試用HashIV，請自行帶入ECPay提供的HashIV
            $obj->MerchantID = '2000132';                                                     //測試用MerchantID，請自行帶入ECPay提供的MerchantID
            $obj->EncryptType = '1';                                                           //CheckMacValue加密類型，請固定填入1，使用SHA256加密
            //基本參數(請依系統規劃自行調整)
            $MerchantTradeNo = $uuid_temp;
            $obj->Send['ReturnURL'] = "https://05e0-114-38-9-29.ngrok-free.app/callback"; // 付款完成通知回傳的網址
            $obj->Send['PeriodReturnURL'] = "https://05e0-114-38-9-29.ngrok-free.app/callback"; // 付款完成通知回傳的網址
            $obj->Send['ClientBackURL'] = "https://05e0-114-38-9-29.ngrok-free.app/success"; // 付款完成通知回傳的網址            
            $obj->Send['MerchantTradeNo'] = $MerchantTradeNo;                          //訂單編號
            $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                       //交易時間
            $obj->Send['TotalAmount'] = $cart->totalPrice;                                      //交易金額
            $obj->Send['TradeDesc'] = "good to drink";                          //交易描述
            $obj->Send['ChoosePayment'] = ECPayMethod::Credit;              //付款方式:Credit
            $obj->Send['IgnorePayment'] = ECPayMethod::GooglePay;           //不使用付款方式:GooglePay
            //訂單的商品資料
            array_push(
                $obj->Send['Items'],
                array(
                    'Name' => request('name'),
                    'Price' => $cart->totalPrice,
                    'Currency' => "元",
                    'Quantity' => (int) "1",
                    'URL' => "dedwed"
                )
            );
            session()->forget('cart');
            $obj->CheckOut();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback()
    {
        // dd(request());
        $order = Order::where('uuid', '=', request('MerchantTradeNo'))->firstOrFail();
        $order->paid = !$order->paid;
        $order->save();
    }

    public function redirectFromECpay()
    {
        session()->flash('success', 'Order success!');
        return redirect('/products');
    }
}

// {
//     "CustomField1":null,
//     "CustomField2":null,
//     "CustomField3":null,
//     "CustomField4":null,
//     "MerchantID":"2000132",
//     "MerchantTradeNo":"Test1576073816",
//     "PaymentDate":"2019\/12\/11 22:17:57",
//     "PaymentType":"Credit_CreditCard",
//     "PaymentTypeChargeFee":"1",
//     "RtnCode":"1",
//     "RtnMsg":"\u4ea4\u6613\u6210\u529f",
//     "SimulatePaid":"0",
//     "StoreID":null,
//     "TradeAmt":"50",
//     "TradeDate":"2019\/12\/11 22:16:56",
//     "TradeNo":"1912112216567583",
//     "CheckMacValue":"6F42BE6F208E15FD08C189345D0973D0787983E3753CE670E105173A994F9AE2"
//  }