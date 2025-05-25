<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edukasi;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $edukasiItems = Edukasi::latest()->take(3)->get();

        return view('user.dashboard.index', compact('user', 'edukasiItems'));
    }
}