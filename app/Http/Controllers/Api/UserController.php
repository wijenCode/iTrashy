<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SetorSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Get user profile
     */
    public function profile()
    {
        $user = Auth::user();
        
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'no_telepon' => 'sometimes|string|max:15',
            'alamat' => 'sometimes|string',
            'kota' => 'sometimes|string|max:100',
            'kecamatan' => 'sometimes|string|max:100',
            'foto_profile' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'sometimes|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->only(['username', 'email', 'no_telepon', 'alamat', 'kota', 'kecamatan']);

        // Handle profile photo upload
        if ($request->hasFile('foto_profile')) {
            // Delete old photo if exists
            if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
                Storage::disk('public')->delete($user->foto_profile);
            }

            $image = $request->file('foto_profile');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('profile_photos', $filename, 'public');
            $data['foto_profile'] = $path;
        }

        // Handle password update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Profile berhasil diupdate',
            'data' => $user->fresh()
        ]);
    }

    /**
     * Get all users (Admin only)
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role if provided
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }

        // Search by username or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Get dashboard statistics (Admin only)
     */
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalDrivers = User::where('role', 'driver')->count();
        $totalSetorSampah = SetorSampah::count();
        
        $setorStats = [
            'menunggu' => SetorSampah::where('status', SetorSampah::STATUS_MENUNGGU)->count(),
            'diambil' => SetorSampah::where('status', SetorSampah::STATUS_DIAMBIL)->count(),
            'selesai' => SetorSampah::where('status', SetorSampah::STATUS_SELESAI)->count(),
            'ditolak' => SetorSampah::where('status', SetorSampah::STATUS_DITOLAK)->count(),
        ];

        $totalSampahTerkumpul = User::where('role', 'user')->sum('sampah_terkumpul');
        $totalPoinTerdistribusi = User::where('role', 'user')->sum('poin_terkumpul');

        // Recent setor sampah
        $recentSetorSampah = SetorSampah::with(['user', 'driver'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'total_drivers' => $totalDrivers,
                'total_setor_sampah' => $totalSetorSampah,
                'setor_stats' => $setorStats,
                'total_sampah_terkumpul' => $totalSampahTerkumpul,
                'total_poin_terdistribusi' => $totalPoinTerdistribusi,
                'recent_setor_sampah' => $recentSetorSampah
            ]
        ]);
    }
}