<?php

// app/Http/Controllers/SomeController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SomeController extends Controller
{
    public function index()
    {
        // Ambil ID user yang sedang login
        $user_id = auth()->id(); // Pastikan user sudah login

        // Ambil poin_terkumpul dari user
        $poin_terkumpul = User::find($user_id)->poin_terkumpul;

        // Kirim data ke view
        return view('your_view_name', compact('poin_terkumpul'));
    }
}
