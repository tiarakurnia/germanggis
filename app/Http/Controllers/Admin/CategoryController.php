<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $categories = Category::all(); // Mengambil semua kategori
        return view('admin.categories.index', compact('categories')); // Mengembalikan view dengan data kategori
    }

    // Menampilkan form untuk menambahkan kategori
    public function create()
    {
        return view('admin.categories.create'); // Mengembalikan view untuk membuat kategori
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Validasi input
        ]);

        // Membuat kategori baru
        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!'); // Redirect dengan pesan sukses
    }

    // Menampilkan form untuk mengedit kategori
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category')); // Mengembalikan view untuk mengedit kategori
    }

    // Memperbarui kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Validasi input
        ]);

        // Memperbarui kategori dengan nama baru
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!'); // Redirect dengan pesan sukses
    }

    // Menghapus kategori
    public function destroy(Category $category)
    {
        $category->delete(); // Menghapus kategori
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!'); // Redirect dengan pesan sukses
    }
}