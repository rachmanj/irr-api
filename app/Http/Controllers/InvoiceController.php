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
        $last_month = $date->subMonth();

        $invoice = DB::table('irr5_invoice')->selectRaw('inv_no, inv_date, receive_date, receive_place, mailroom_bpn_date, spi_jkt_date, datediff(mailroom_bpn_date, receive_date) as days')
            ->whereYear('receive_date', $last_month)
            ->whereMonth('receive_date', $last_month)
            ->where('receive_place', 'BPN')
            ->where('payment_place', 'JKT')
            ->limit(50)
            ->get();

        return $invoice;
    }

    public function avg_day_process()
    {
        $date = Carbon::now();
        $last_month = $date->subMonths(3);

        $get_average = DB::table('irr5_invoice')
                        ->select(DB::raw("avg(datediff(mailroom_bpn_date, receive_date)) as days"))
                        ->whereYear('receive_date', $last_month)
                        ->whereMonth('receive_date', $last_month)
                        ->get();
        
        $response = [
            'message' => 'Rata-rata hari proses invoice',
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
}