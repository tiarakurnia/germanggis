<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id', // Ganti dengan category_id, karena kamu menyimpan ID kategori
        'description',
        'price',
        'image', // Jangan lupa tambahkan 'image' jika kamu menyimpan gambar
    ];

    // Relasi dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

