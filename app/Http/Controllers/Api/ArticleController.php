<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Articles;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    //
    public function store(StoreArticleRequest  $request){
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $validated['image_path'] = $imagePath;

        }
        $validated['user_id'] = auth()->user()->id;

        $article = Articles::create($validated);

        return response()->json([
            'message' => 'Article created successfully',
            'data' =>  new ArticleResource($article)
        ], 201);

    }

    public function update(StoreArticleRequest $request, $id)
    {
        $validated = $request->validated();

        $article = Articles::find($id);
        if ($article){
            // Delete old image if necessary
            if ($article->image_path) {
                Storage::disk('public')->delete($article->image_path);
            }
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('articles', 'public');
            $validated['image_path'] = $imagePath;
        }else{
            $validated['image_path'] = null;
        }
        $validated['user_id'] = auth()->user()->id;

        $article->update($validated);

        return response()->json([
            'message' => 'Article updated successfully',
            'data' =>  new ArticleResource($article)
        ], 200);
        }else{
            return response()->json(['message' => 'Article not found'], 404);
        }
    }

    public function delete($id)
    {
        // Find the article by ID
        $article = Articles::find($id);
        if ($article){
        // Check if there is an image and delete it
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }

        // Delete the article
        $article->delete();

        // Return a JSON response indicating success
        return response()->json([
            'message' => 'Article and associated file deleted successfully'
        ], 200);
        }else{
            return response()->json(['message' => 'Article not found'], 404);
        }
    }

    public function article( $id)
    {
        $article = Articles::find($id);
        if ($article){
            return response()->json([
                'message' => 'Article retrieved successfully',
                'data' => new ArticleResource($article)
            ], 200);
        }else{
            return response()->json(['message' => 'Article not found'], 404);
        }

    }
    public function all_articles(){
        $articles = Articles::all();
        return response()->json([
            'message' => 'Articles retrieved successfully',
            'data' => new ArticleCollection($articles)
        ], 201);
    }


}
