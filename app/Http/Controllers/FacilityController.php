<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Facility; // Pastikan untuk mengimpor model Facility
use App\Models\Cart; // Pastikan untuk mengimpor model Cart
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori beserta fasilitas yang terkait
        $categories = Category::with('facilities')->get();

        // Mengelompokkan fasilitas berdasarkan kategori
        $facilitiesByCategory = $categories->mapWithKeys(function ($category) {
            return [$category->name => $category->facilities];
        });

        // Mengembalikan view dengan data fasilitas yang dikelompokkan
        return view('fasilitas', ['categories' => $facilitiesByCategory]);
    }

    public function show($id)
    {
        // Mencari fasilitas berdasarkan ID
        $facility = Facility::findOrFail($id);

        // Mengembalikan view dengan data fasilitas
        return view('facility.show', compact('facility'));
    }

}