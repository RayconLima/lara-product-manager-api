<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\Product\{StoreProductRequest, UpdateProductRequest};
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->name, function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->name}%");
            })
            ->when($request->description, function ($query) use ($request) {
                $query->where('description', 'LIKE', "%{$request->description}%");
            })
            ->paginate();
        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return ProductResource::make($product);
    }

    public function show($productId)
    {
        $product = $this->product($productId);
        return ProductResource::make($product);
    }

    public function update($productId, UpdateProductRequest $request)
    {
        $product = $this->product($productId);
        $product->update($request->validated());
        return ProductResource::make($product);
    }

    public function destroy($productId)
    {
        $product = $this->product($productId);

        $product->delete();
        return response()->noContent();
    }

    private function product($productId)
    {
        $product = Product::find($productId);
        if(!$product) {
            throw new NotFoundException('Product not found');
        }

        return $product;
    }
}
