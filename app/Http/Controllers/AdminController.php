<?php

namespace App\Http\Controllers;



class AdminController extends Controller
{
    // Middleware untuk memastikan hanya admin yang bisa mengakses

    public function index()
    {
        return view('admin.dashboard'); // Ganti dengan view dashboard admin
    }
}

