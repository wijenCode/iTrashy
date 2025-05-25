<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SetorSampah;
use App\Models\SetorItem;
use App\Models\User;
use App\Models\JenisSampah;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PencapaianController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get total weight and points from setor_item
        $totalWeight = SetorItem::whereHas('setorSampah', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('status', 'selesai');
        })->sum('berat') ?? 0;

        $totalPoints = SetorItem::whereHas('setorSampah', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('status', 'selesai');
        })->sum('poin') ?? 0;

        // Calculate carbon reduced (assuming 1kg waste = 0.5kg CO2)
        $totalCarbonReduced = $totalWeight * 0.5;

        // Get monthly garbage data with points
        $garbageData = DB::table('setor_item')
            ->join('setor_sampah', 'setor_item.setor_sampah_id', '=', 'setor_sampah.id')
            ->where('setor_sampah.user_id', $user->id)
            ->where('setor_sampah.status', 'selesai')
            ->select(
                DB::raw('DATE_FORMAT(setor_sampah.tanggal_setor, "%Y-%m") as month'),
                DB::raw('COALESCE(SUM(setor_item.berat), 0) as total_weight'),
                DB::raw('COALESCE(SUM(setor_item.poin), 0) as total_points')
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
                    'total_weight' => 0,
                    'total_points' => 0
                ]);
            }
        }

        $garbageData = $garbageData->map(function ($item) {
            return [
                'month' => Carbon::createFromFormat('Y-m', $item->month)->format('M'),
                'total_weight' => (float) $item->total_weight,
                'total_points' => (int) $item->total_points
            ];
        });

        // Get monthly carbon data
        $carbonData = $garbageData->map(function ($item) {
            return [
                'month' => $item['month'],
                'carbon' => $item['total_weight'] * 0.5
            ];
        });

        // Get leaderboard data with points
        $leaderboard = DB::table('users')
            ->leftJoin('setor_sampah', 'users.id', '=', 'setor_sampah.user_id')
            ->leftJoin('setor_item', 'setor_sampah.id', '=', 'setor_item.setor_sampah_id')
            ->where(function($query) {
                $query->where('setor_sampah.status', 'selesai')
                      ->orWhereNull('setor_sampah.status');
            })
            ->select(
                'users.*',
                DB::raw('COALESCE(SUM(setor_item.berat), 0) as total_weight'),
                DB::raw('COALESCE(SUM(setor_item.poin), 0) as total_points')
            )
            ->groupBy('users.id')
            ->orderByDesc('total_points')
            ->limit(10)
            ->get();

        // Get most collected waste types with points
        $wasteData = DB::table('setor_item')
            ->join('setor_sampah', 'setor_item.setor_sampah_id', '=', 'setor_sampah.id')
            ->join('jenis_sampah', 'setor_item.jenis_sampah_id', '=', 'jenis_sampah.id')
            ->where('setor_sampah.user_id', $user->id)
            ->where('setor_sampah.status', 'selesai')
            ->select(
                'jenis_sampah.id as jenis_sampah_id',
                'jenis_sampah.nama as jenis_sampah_nama',
                DB::raw('COALESCE(SUM(setor_item.berat), 0) as total_quantity'),
                DB::raw('COALESCE(SUM(setor_item.poin), 0) as total_points')
            )
            ->groupBy('jenis_sampah.id', 'jenis_sampah.nama')
            ->orderByDesc('total_quantity')
            ->limit(3)
            ->get();

        // If no waste data, create empty data
        if ($wasteData->isEmpty()) {
            $wasteData = collect([
                (object)[
                    'jenis_sampah_id' => null,
                    'jenis_sampah_nama' => 'Belum ada data',
                    'total_quantity' => 0,
                    'total_points' => 0
                ]
            ]);
        }

        $wasteData = $wasteData->map(function ($item) {
            return [
                'waste_type' => $item->jenis_sampah_nama,
                'total_quantity' => (float) $item->total_quantity,
                'total_points' => (int) $item->total_points,
                'image' => $item->jenis_sampah_id ? strtolower(str_replace(' ', '_', $item->jenis_sampah_nama)) . '.png' : 'default.png'
            ];
        });

        return view('user.pencapaian.index', compact(
            'totalWeight',
            'totalPoints',
            'totalCarbonReduced',
            'garbageData',
            'carbonData',
            'leaderboard',
            'wasteData'
        ));
    }
} 