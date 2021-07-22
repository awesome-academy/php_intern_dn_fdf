<?php

namespace App\Repositories\ProductImage;

use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;

class ProductImageRepository extends BaseRepository implements IProductImageRepository
{
    public function getModel()
    {
        return ProductImage::class;
    }

    public function storeImageOfProduct($data, $id)
    {
        $product = Product::findOrFail($id);

        $image = $data['image'];

        $image_path = 'image_product/' . time() . '.' . $image->getClientOriginalExtension();
        $path = public_path('/storage/image_product');
        $image->move($path, $image_path);

        $product->images()->create([
            'image_path' => $image_path,
        ]);
    }

    public function delete($id)
    {
        $productImage = $this->findOrFail($id);

        if (File::exists(public_path('storage/' . $productImage->image_path))) {
            File::delete(public_path('storage/' . $productImage->image_path));
        }

        $productImage->delete();
    }
}
