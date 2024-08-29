<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Exceptions\NotFoundException;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\{StoreCategoryRequest, UpdateCategoryRequest};

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate();
        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return CategoryResource::make($category);
    }

    public function show($categoryId)
    {
        $category = $this->category($categoryId);
        return CategoryResource::make($category);
    }

    public function update($categoryId, UpdateCategoryRequest $request)
    {
        $category = $this->category($categoryId);
        $category->update($request->validated());
        return CategoryResource::make($category);
    }

    public function destroy($categoryId)
    {
        $category = $this->category($categoryId);
        // dd($category->products);
        $category->delete();
        return response()->noContent();
    }

    private function category($categoryId)
    {
        $category = Category::with('products')->find($categoryId);
        if(!$category) {
            throw new NotFoundException('Category not found');
        }

        return $category;
    }
}
