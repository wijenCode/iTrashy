<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SetorSampah;
use App\Models\SetorItem;
use App\Models\User;

class PencapaianController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get total weight from setor_item
        $totalWeight = SetorItem::whereHas('setorSampah', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('status', 'selesai');
        })->sum('berat') ?? 0;

        // Calculate carbon reduced (assuming 1kg waste = 0.5kg CO2)
        $totalCarbonReduced = $totalWeight * 0.5;

        // Get monthly garbage data
        $garbageData = DB::table('setor_item')
            ->join('setor_sampah', 'setor_item.setor_sampah_id', '=', 'setor_sampah.id')
            ->where('setor_sampah.user_id', $user->id)
            ->where('setor_sampah.status', 'selesai')
            ->select(
                DB::raw('DATE_FORMAT(setor_sampah.tanggal_setor, "%Y-%m") as month'),
                DB::raw('COALESCE(SUM(setor_item.berat), 0) as total_weight')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // If no data, create empty data for last 6 months
        if ($garbageData->isEmpty()) {
            $garbageData = collect();
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $garbageData->push((object)[
                    'month' => $date->format('Y-m'),
                    'total_weight' => 0
                ]);
            }
        }

        $garbageData = $garbageData->map(function ($item) {
            return [
                'month' => Carbon::createFromFormat('Y-m', $item->month)->format('M'),
                'total_weight' => (float) $item->total_weight
            ];
        });

        // Get monthly carbon data
        $carbonData = $garbageData->map(function ($item) {
            return [
                'month' => $item['month'],
                'carbon' => $item['total_weight'] * 0.5
            ];
        });

        // Get leaderboard data
        $leaderboard = DB::table('users')
            ->leftJoin('setor_sampah', 'users.id', '=', 'setor_sampah.user_id')
            ->leftJoin('setor_item', 'setor_sampah.id', '=', 'setor_item.setor_sampah_id')
            ->where('users.role', 'user')
            ->where(function($query) {
                $query->where('setor_sampah.status', 'selesai')
                      ->orWhereNull('setor_sampah.status');
            })
            ->select(
                'users.id',
                'users.username',
                'users.email',
                'users.foto_profile',
                'users.poin_terkumpul',
                'users.sampah_terkumpul',
                DB::raw('COALESCE(SUM(setor_item.berat), 0) as total_weight')
            )
            ->groupBy(
                'users.id',
                'users.username',
                'users.email',
                'users.foto_profile',
                'users.poin_terkumpul',
                'users.sampah_terkumpul'
            )
            ->orderByDesc('users.sampah_terkumpul')
            ->limit(10)
            ->get();

        // Get most collected waste types
        $wasteData = DB::table('setor_item')
            ->join('setor_sampah', 'setor_item.setor_sampah_id', '=', 'setor_sampah.id')
            ->join('jenis_sampah', 'setor_item.jenis_sampah_id', '=', 'jenis_sampah.id')
            ->where('setor_sampah.user_id', $user->id)
            ->where('setor_sampah.status', 'selesai')
            ->select(
                'jenis_sampah.id as jenis_sampah_id',
                'jenis_sampah.nama_sampah as jenis_sampah_nama',
                DB::raw('COALESCE(SUM(setor_item.berat), 0) as total_quantity')
            )
            ->groupBy('jenis_sampah.id', 'jenis_sampah.nama_sampah')
            ->orderByDesc('total_quantity')
            ->limit(3)
            ->get();

        // If no waste data, create empty data
        if ($wasteData->isEmpty()) {
            $wasteData = collect([
                (object)[
                    'jenis_sampah_id' => null,
                    'jenis_sampah_nama' => 'Belum ada data',
                    'total_quantity' => 0
                ]
            ]);
        }

        $wasteData = $wasteData->map(function ($item) {
            return [
                'waste_type' => $item->jenis_sampah_nama,
                'total_quantity' => (float) $item->total_quantity,
                'image' => $item->jenis_sampah_id ? strtolower(str_replace(' ', '_', $item->jenis_sampah_nama)) . '.png' : 'default.png'
            ];
        });

        return view('user.pencapaian.index', compact(
            'totalWeight',
            'totalCarbonReduced',
            'garbageData',
            'carbonData',
            'leaderboard',
            'wasteData'
        ));
    }
} 