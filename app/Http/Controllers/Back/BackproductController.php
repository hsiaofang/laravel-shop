<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

use App\Services\Admin\ProductService;

class BackproductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('admin.products.index', compact('products'));
    }

    public function createindex()
    {
        return view('admin.products.create');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer', 
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $this->productService->createProduct($validatedData);
        return redirect()->back()->with('success', '商品儲存成功');
    }

    public function edit($id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function update(Product $product)
    {
        $editedProduct = $this->productService->getEditedProduct($product);
        return response()->json($editedProduct);
    }

    public function delete($id)
    {
        $this->productService->deleteProduct($id);
        return redirect()->back()->with('success', '商品刪除成功');
    }
}
