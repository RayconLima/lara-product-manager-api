<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\NotFoundException;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Product\{StoreProductRequest, UpdateProductRequest};
use Illuminate\Support\Str;
class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Gate::authorize('list_products', Product::class);
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
        // Gate::authorize('new_product', Product::class);
        $input = $request->validated();
        // Handle image upload
        if ($request->image) {
            $image = $request->file('image');
            $originalFilename = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $filename = Str::slug($originalFilename, '-') . '-' . time() . '.' . $extension;

            $imagePath = $image->storeAs('public/products', $filename);
            $input['image'] = $imagePath;
        }

        $product = Product::create($input);
        return ProductResource::make($product);
    }

    public function show($productId)
    {
        $product = $this->product($productId);
        // Gate::authorize('show_product', $product);
        return ProductResource::make($product);
    }

    public function update($productId, UpdateProductRequest $request)
    {
        $product = $this->product($productId);
        Gate::authorize('update_product', $product);
        
        $product->update($request->validated());
        return ProductResource::make($product);
    }
    
    public function destroy($productId)
    {
        $product = $this->product($productId);
        // Gate::authorize('destroy_product', $product);

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
