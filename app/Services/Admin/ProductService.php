<?php
namespace App\Services\Admin;

use App\Models\Product;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Storage;

class ProductService
{

    public function getAllProducts()
    {
        return Product::all();
    }

    public function editProduct(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
    }

    public function createProduct(array $data)
    {
        $image = array_key_exists('image', $data) ? $data['image'] : null;

        if ($image) {
            $imageName = $image->getClientOriginalName();
            $s3Path = '.image/' . $imageName;

            Storage::disk('s3')->put($s3Path, file_get_contents($image));

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
        } else {
            $objectUrl = 'images/預設.png';
        }

        $productData = [
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $objectUrl,
        ];

        $product = Product::create($productData);

        return $product;
    }



}
