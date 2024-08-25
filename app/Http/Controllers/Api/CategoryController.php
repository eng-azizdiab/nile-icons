<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Articles;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //
    public function store(StoreCategoryRequest  $request){
        $validated = $request->validated();
        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);

    }

    public function update(StoreCategoryRequest $request, $id)
    {
        $validated = $request->validated();

        $category = Category::find($id);
        if ($category){
        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category
        ], 200);
        }else{
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    public function delete($id)
    {
        // Find the category by ID
        $category = Category::find($id);
        if ($category){


        // Delete the category
        $category->delete();

        // Return a JSON response indicating success
        return response()->json([
            'message' => 'Category  deleted successfully'
        ], 200);
        }else{
            return response()->json(['message' => 'Category not found'], 404);
        }
    }

    public function category( $id)
    {
        $category = Category::find($id);
        if ($category){
            return response()->json([
                'message' => 'Category retrieved successfully',
                'data' => $category
            ], 200);
        }else{
            return response()->json(['message' => 'Category not found'], 404);
        }

    }
    public function all_categories(){
        $categories = Category::all();
        return response()->json([
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ], 201);
    }


}
