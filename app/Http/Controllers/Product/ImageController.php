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
    public function index()
    {
        $images = Image::paginate();
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
            // $imagePath          = $image->store('products', 'public');
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
            Storage::disk('local')->delete($image->path);
        }

        $image->delete();

        return response()->json(['message' => 'Image deleted successfully'], 200);
    }
}
