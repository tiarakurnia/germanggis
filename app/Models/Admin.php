<?php

// Di dalam model Admin
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    // Tabel yang digunakan, jika bukan nama default
    protected $table = 'users';
}

