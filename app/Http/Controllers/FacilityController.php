<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $categories = Category::with('facilities')->get();

        $facilitiesByCategory = $categories->mapWithKeys(function ($category) {
            return [$category->name => $category->facilities];
        });

        return view('fasilitas', ['categories' => $facilitiesByCategory]);
    }


    public function show($slug)
    {
        // Find the category by the slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // You can pass the category data to the view if necessary
        return view('category', compact('category'));
    }
}
