<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::with('category')->get();
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.facilities.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('image') ? $request->file('image')->store('facilities', 'public') : null;

        Facility::create(array_merge($request->all(), ['image' => $path]));

        return redirect()->route('admin.facilities.index')->with('success', 'Facility created successfully.');
    }

    public function edit(Facility $facility)
    {
        $categories = Category::all();
        return view('admin.facilities.edit', compact('facility', 'categories'));
    }

    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $facility->image;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('facilities', 'public');
        }

        $facility->update(array_merge($request->all(), ['image' => $path]));

        return redirect()->route('admin.facilities.index')->with('success', 'Facility updated successfully.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return redirect()->route('admin.facilities.index')->with('success', 'Facility deleted successfully.');
    }
}
