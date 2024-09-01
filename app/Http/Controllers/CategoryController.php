<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\NotFoundException;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\{StoreCategoryRequest, UpdateCategoryRequest};

class CategoryController extends Controller
{
    public function index()
    {
        // Gate::authorize('list_categories', Category::class);
        $categories = Category::paginate();
        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        // Gate::authorize('new_category', Category::class);
        $category = Category::create($request->validated());
        return CategoryResource::make($category);
    }

    public function show($categoryId)
    {
        $category = $this->category($categoryId);
        // Gate::authorize('show_category', $category);
        return CategoryResource::make($category);
    }

    public function update($categoryId, UpdateCategoryRequest $request)
    {
        $category = $this->category($categoryId);
        // Gate::authorize('update_category', $category);
        $category->update($request->validated());
        return CategoryResource::make($category);
    }

    public function destroy($categoryId)
    {
        $category = $this->category($categoryId);
        // Gate::authorize('destroy_category', $category);
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
