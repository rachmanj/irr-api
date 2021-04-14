<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $date = Carbon::now();
        $periode = $date;

        $invoice = DB::table('irr5_invoice')
            ->whereYear('receive_date', $periode)
            ->whereMonth('receive_date', $periode)
            ->where('receive_place', 'BPN')
            ->where('payment_place', 'JKT')
            ->limit(10)
            ->get();
            // ->count();

        return $invoice;
    }

    public function avgDayProcessThisMonth()
    {
        $date = Carbon::now();
        // $last_month = $date->subMonths(3);

        $get_average = DB::table('irr5_invoice')
                        ->select(DB::raw("avg(datediff(mailroom_bpn_date, receive_date)) as days"))
                        ->whereYear('receive_date', $date)
                        ->whereMonth('receive_date', $date)
                        ->first();
        
        $response = [
            'message' => 'Rata-rata hari proses invoice bulan ini',
            'success' => true,
            'data' => $get_average
        ];

        return $response;
    }

    public function avgDayProcessByMonth()
    {
        $date = Carbon::now();

        $get_average = DB::table('irr5_invoice')
                        ->select(
                            DB::raw("extract(year from receive_date) as year"),
                            DB::raw("extract(month from receive_date) as month"),
                            DB::raw("avg(datediff(mailroom_bpn_date, receive_date)) as days"),
                        )
                        ->whereYear('receive_date', $date)
                        ->groupBy('year', 'month')
                        ->get();
        
        $response = [
            'message' => 'Rata-rata hari proses invoice bulanan',
            'success' => true,
            'data' => $get_average
        ];

        return $response;
    }

    public function invoiceByCreatorMonthly()
    {
        $date = Carbon::now();

        $creator = DB::table('irr5_invoice')
                        ->select(
                            DB::raw("extract(year from receive_date) as year"),
                            DB::raw("extract(month from receive_date) as month"),
                            DB::raw("creator"),
                            DB::raw("count(*) as count"),
                        )
                        ->whereYear('receive_date', $date)
                        ->groupBy('year', 'month', 'creator')
                        ->get();
        
        $response = [
            'title' => 'Jumlah Invoice Berdasarkan Creator',
            'success' => true,
            'data' => $creator
        ];

        return $response;
    }
}
