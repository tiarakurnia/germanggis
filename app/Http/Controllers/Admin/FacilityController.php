<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Facility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacilityController extends Controller
{
    // Menampilkan daftar fasilitas
    public function index()
    {
        $facilities = Facility::with('category')->get(); // Mengambil semua fasilitas beserta kategori
        return view('admin.facilities.index', compact('facilities')); // Mengembalikan view dengan data fasilitas
    }

    // Menampilkan form untuk menambahkan fasilitas
    public function create()
    {
        $categories = Category::all(); // Mengambil semua kategori
        return view('admin.facilities.create', compact('categories')); // Mengembalikan view untuk membuat fasilitas
    }

    // Menyimpan fasilitas baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Validasi input
            'category_id' => 'required|exists:categories,id', // Validasi kategori
            'description' => 'nullable|string', // Validasi deskripsi
            'price' => 'required|numeric', // Validasi harga
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar
        ]);

        $imagePath = null;

        // Jika ada file gambar yang diupload
        if ($request->hasFile('image')) {
            // Mengambil file gambar
            $image = $request->file('image');

            // Menggunakan GD untuk memproses gambar
            $img = imagecreatefromstring(file_get_contents($image->getRealPath()));
            if ($img) {
                // Mengubah ukuran gambar
                $width = imagesx($img);
                $height = imagesy($img);
                $newWidth = 800;
                $newHeight = ($height / $width) * $newWidth;

                $resizedImg = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($resizedImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // Menyimpan gambar ke dalam string base64
                ob_start();
                imagejpeg($resizedImg, null, 75); // Mengatur kualitas JPEG
                $imageData = ob_get_contents();
                ob_end_clean();

                $imagePath = 'data:' . $image->getClientMimeType() . ';base64,' . base64_encode($imageData);

                // Menghancurkan gambar untuk membebaskan memori
                imagedestroy($img);
                imagedestroy($resizedImg);
            }
        }

        // Membuat fasilitas baru
        Facility::create(array_merge($request->all(), ['image' => $imagePath]));

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan!'); // Redirect dengan pesan sukses
    }

    // Menampilkan form untuk mengedit fasilitas
    public function edit(Facility $facility)
    {
        $categories = Category::all(); // Mengambil semua kategori
        return view('admin.facilities.edit', compact('facility', 'categories')); // Mengembalikan view untuk mengedit fasilitas
    }

    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Validasi input
            'category_id' => 'required|exists:categories,id', // Validasi kategori
            'description' => 'nullable|string', // Validasi deskripsi
            'price' => 'required|numeric', // Validasi harga
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar
        ]);

        // Mengambil path gambar yang ada
        $imagePath = $facility->image;

        // Jika ada file gambar yang diupload
        if ($request->hasFile('image')) {
            // Mengambil file gambar
            $image = $request->file('image');

            // Menggunakan GD untuk memproses gambar
            $img = imagecreatefromstring(file_get_contents($image->getRealPath()));
            if ($img) {
                // Mengubah ukuran gambar
                $width = imagesx($img );
                $height = imagesy($img);
                $newWidth = 800;
                $newHeight = ($height / $width) * $newWidth;

                $resizedImg = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($resizedImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // Menyimpan gambar ke dalam string base64
                ob_start();
                imagejpeg($resizedImg, null, 75); // Mengatur kualitas JPEG
                $imageData = ob_get_contents();
                ob_end_clean();

                $imagePath = 'data:' . $image->getClientMimeType() . ';base64,' . base64_encode($imageData);

                // Menghancurkan gambar untuk membebaskan memori
                imagedestroy($img);
                imagedestroy($resizedImg);
            }
        }

        // Memperbarui fasilitas
        $facility->update(array_merge($request->all(), ['image' => $imagePath]));

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui!'); // Redirect dengan pesan sukses
    }

    // Menghapus fasilitas
    public function destroy(Facility $facility)
    {
        $facility->delete(); // Menghapus fasilitas
        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil dihapus!'); // Redirect dengan pesan sukses
    }
}