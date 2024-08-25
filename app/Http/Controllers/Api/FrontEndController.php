<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\ContactUsRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleFrontCollection;
use App\Models\Articles;
use App\Models\Category;
use App\Models\ContactUS;
use App\Models\Visitors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class FrontEndController extends Controller
{
    //
    public function index(){

        $articles = Articles::where('visible', '=', 1)
            ->orderBy('created_at', 'desc') // Order by 'created_at' in descending order
            ->get();
        return response()->json([
                'message' => 'Articles retrieved successfully',
                'data' => new ArticleFrontCollection($articles)
            ], 201);
        }
    public function all_categories(){
        $categories = Category::all();
        return response()->json([
            'message' => 'Categories retrieved successfully',
            'data' => $categories
        ], 201);
    }


    public function new_visitor(Request $request)
    {
        Visitors::create($request->all());
        return response()->json(['status' => 'success'], 200);
    }

    public function contact_us(ContactUsRequest $request)
    {
        $validated = $request->validated();

        ContactUs::create($validated);
        return response()->json(['message'=>'submitted successfully','status' => 'success'], 200);
    }



    public function sendContactEmail(ContactRequest $request)
    {
        $data = $request->validated();
        ContactUS::create($data);
        Mail::send('mail.test-email', $data, function($message) use ($data) {
            $message->to('abdulazizdiab8@gmail.com')
                ->subject('New Contact Information');
        });

        return response()->json(['message' => 'Email sent successfully!']);
    }


}