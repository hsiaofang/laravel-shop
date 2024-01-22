<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3V3\AwsS3V3VisibilityConverter;
use Illuminate\Support\Facades\Redis;


class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'admin']);
    // }

    // public function dashboard()
    // {
    //     return view('admin.dashboard');
    // }

    public function index()
    {
        $totalSales = 50000;
        // $totalVisits = 100000; 
        $totalVisits = Redis::get('site_total_visits') ?? 0;

        $totalFavorites = 1500; 
        $todayOrders = 20;  
        $monthlyOrders = 500;  
        $data = compact('totalSales', 'totalVisits', 'totalFavorites', 'todayOrders', 'monthlyOrders');
    
        return view('admin.index', $data);
    }
    
    public function product()
    {
        $products = Product::all();

        return view('admin.products.index', compact('products'));
    }

    public function orders()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            $cartData = json_decode($order->cart);

            if ($cartData && isset($cartData->items)) {
                $order->parsedCart = $cartData->items;
            }
        }

        return view('admin.orders.index', ['orders' => $orders, 'cartData' => $cartData]);
    }

    public function users()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $image = $request->file('image');
        if ($image) {
            $imageName = $image->getClientOriginalName();
            $s3Path = '.image/' . $imageName;
            Storage::disk('s3')->put($s3Path, file_get_contents($image));
        } else {
            $s3Path = 'images/預設.png';
        }

        $s3Client = new S3Client([
            'region' => 'ap-southeast-2',
            'version' => 'latest',
            'credentials' => [
                'key' => 'AKIA5K7KJRFCXBXYYG46',
                'secret' => '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',
            ],
        ]);
        $bucket = 'pieceofcases';
        $objectUrl = $s3Client->getObjectUrl($bucket, $s3Path);
    
        $product = new Product([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'image' => $objectUrl,
        ]);
        $product->save();

        return redirect()->back()->with('success', '商品儲存成功');
    }
    

    
    public function editProduct(Product $product)
    {
        $editedProduct = [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
        ];

        return response()->json($editedProduct);
    }

    public function edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            // 如果找不到商品，返回一些錯誤數據或者空數據
            return response()->json(['error' => 'Product not found'], 404);
        }

        // 返回商品數據
        return response()->json($product);
    }
}
