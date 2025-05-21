<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Sembako;

class TukarPoinController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // Fetch the total points of the user
        $poin_terkumpul = $user->poin_terkumpul ?? 0;

        // Fetch available vouchers and sembakos
        $vouchers = Voucher::where('status', 'tersedia')->get();
        $sembakos = Sembako::where('status', 'tersedia')->get();

        // Return the view with the fetched data
        return view('user.tukar_poin.index', compact('poin_terkumpul', 'vouchers', 'sembakos'));
    }
}