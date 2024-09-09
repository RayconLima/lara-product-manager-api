<?php

namespace App\Http\Controllers\Product;

use Storage;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductImageResource;
use App\Http\Requests\Product\StoreUpdateImageRequest;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $images = Image::query()->when($request->product_id, function ($query) use ($request) {
            $query->where('product_id', 'LIKE', "%{$request->product_id}%");
        })
        ->paginate();
        return ProductImageResource::collection($images);
    }

    public function store(StoreUpdateImageRequest $request)
    {
        $input = $request->validated();
        if ($request->path) {
            $image              = $input['path'];
            $originalFilename   = $image->getClientOriginalName();
            $extension          = $image->getClientOriginalExtension();
            $filename           = Str::slug($originalFilename, '-') . '-' . time() . '.' . $extension;
            $imagePath          = $image->storeAs('products', $filename);
            $input['path']      = $imagePath;
        }
        $image = Image::query()->create([
            'product_id'    =>  $input['product_id'],
            'name'          =>  $filename,
            'path'          =>  $input['path']
        ]);
        return response()->json(ProductImageResource::make($image), 200);
    }

    public function destroy(Image $image)
    {
        if (Storage::url($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();
        return response()->noContent();
    }
}
