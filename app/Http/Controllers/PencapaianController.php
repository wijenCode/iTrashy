<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PencapaianController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get garbage collection data grouped by month
        $garbageData = DB::table('orders')
            ->select(
                DB::raw('DATE_FORMAT(pickup_date, "%Y-%m") as date'),
                DB::raw('SUM(total_berat_sampah) as total_weight')
            )
            ->where('user_id', $user->id)
            ->where('status', 'done')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function($item) {
                $date = Carbon::createFromFormat('Y-m', $item->date);
                return [
                    'month' => $date->format('M Y'),
                    'total_weight' => $item->total_weight
                ];
            });

        // Calculate total weight
        $totalWeight = $garbageData->sum('total_weight');

        // Get carbon reduction data
        $carbonData = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('jenis_sampah', 'order_items.waste_type', '=', 'jenis_sampah.name')
            ->select(
                DB::raw('DATE_FORMAT(orders.pickup_date, "%Y-%m") as date'),
                DB::raw('SUM(order_items.quantity * jenis_sampah.carbon_reduced) as carbon')
            )
            ->where('orders.user_id', $user->id)
            ->where('orders.status', 'done')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->map(function($item) {
                $date = Carbon::createFromFormat('Y-m', $item->date);
                return [
                    'month' => $date->format('M Y'),
                    'carbon' => round($item->carbon, 2)
                ];
            });

        // Calculate total carbon reduction
        $totalCarbonReduced = $carbonData->sum('carbon');

        // Get leaderboard data
        $leaderboard = DB::table('users')
            ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->select(
                'users.id',
                'users.username',
                'users.avatar as profile_picture',
                DB::raw('COALESCE(SUM(orders.total_berat_sampah), 0) as total_weight')
            )
            ->groupBy('users.id', 'users.username', 'users.avatar')
            ->orderByDesc('total_weight')
            ->limit(10)
            ->get();

        // Get most collected waste types
        $wasteData = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('jenis_sampah', 'order_items.waste_type', '=', 'jenis_sampah.name')
            ->select(
                'jenis_sampah.name as waste_type',
                'jenis_sampah.image',
                DB::raw('SUM(order_items.quantity) as total_quantity')
            )
            ->where('orders.user_id', $user->id)
            ->groupBy('jenis_sampah.name', 'jenis_sampah.image')
            ->orderByDesc('total_quantity')
            ->limit(3)
            ->get();

        return view('users.pencapaian.index', compact(
            'garbageData',
            'carbonData',
            'totalWeight',
            'totalCarbonReduced',
            'leaderboard',
            'wasteData'
        ));
    }
} 