<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WahanaController extends Controller
{
    public function index()
    {
        // Data untuk fasilitas kolam renang
        $fasilitas = [
            [
                'icon' => '/images/papan pelampung.jpg',
                'title' => 'Papan Pelampung',
                'description' => 'Pelampung tersedia untuk memastikan keselamatan pengunjung, terutama untuk anak-anak.',
            ],
            [
                'icon' => '/images/pelampung ban.jpg',
                'title' => 'Ban Pelampung',
                'description' => 'Pelampung tersedia untuk memastikan keselamatan pengunjung, terutama untuk anak-anak.',
            ],
            [
                'icon' => '/images/kolam 2.jpeg',
                'title' => 'Tempat Tunggu dan Kamar Mandi',
                'description' => 'Tempat tunggu yang nyaman dan kamar mandi yang bersih',
            ],
        ];


        // Mengirimkan data ke view
        return view('wahana', compact('fasilitas'));
    }
}
