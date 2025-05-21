<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edukasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get educational content
        $edukasiItems = Edukasi::latest()->take(3)->get();
        
        // Get user's waste collection schedules
        $setorSampah = DB::table('setor_sampah')
            ->where('user_id', $user->id)
            ->orderBy('tanggal_setor', 'asc')
            ->orderBy('waktu_setor', 'asc')
            ->where(function($query) {
                $query->where('status', 'menunggu')
                      ->orWhere('status', 'dikonfirmasi')
                      ->orWhere('status', 'dalam_penjemputan');
            })
            ->take(5)
            ->get();
        
        return view('user.dashboard.index', compact('edukasiItems', 'setorSampah'));
    }
}