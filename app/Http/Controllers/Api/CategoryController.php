<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {

        $categories = Category::all();

        return response()->json($categories);

    }

    public function show($slug) {

        $category = Category::where('slug', $slug)->with('posts')->first();

        if ( empty($category) ) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);

    }
}
