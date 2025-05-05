<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // Menggunakan middleware 'is_admin' untuk memastikan hanya admin yang dapat mengakses
        $this->middleware('is_admin');
    }

    public function index()
    {
        return view('admin.dashboard.index');  // Menampilkan view yang disimpan di resources/views/admin/dashboard/index.blade.php
}
}