<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
    
        $date = Carbon::now();

        $list = DB::table('irr5_invoice')
                        ->select(
                            DB::raw("extract(year from receive_date) as year"),
                            DB::raw("extract(month from receive_date) as month"),
                            DB::raw("creator"),
                            DB::raw("count(*) as count"),
                        )
                        ->whereYear('receive_date', $date)
                        ->groupBy('year', 'month', 'creator')
                        ->get();   

        // return $list;
        return view('dashboard.index', compact('list'));
    }
}
