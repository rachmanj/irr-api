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

    public function avgDayProcessThisYear()
    {
        $date = Carbon::now();

        $get_average = DB::table('irr5_invoice')
                        ->select(DB::raw("avg(datediff(mailroom_bpn_date, receive_date)) as days"))
                        ->whereYear('receive_date', $date)
                        ->first();
        
        $response = [
            'message' => 'Average Days Invoices Process This Year',
            'success' => true,
            'data' => $get_average
        ];

        return $response;
    }

    public function receiveThisMonthCount()
    {
        $date = Carbon::now();

        $get_count = DB::table('irr5_invoice')
            ->whereYear('receive_date', $date->year)
            ->whereMonth('receive_date', $date->month)
            ->where('receive_place', 'BPN')
            ->count();
        
        $response = [
            'message' => 'Count Invoices Receive BPN This Month',
            'success' => true,
            'data' => $get_count
        ];

        return $response;

    }

    public function invoiceByCreatorMonthly()
    {
        $date = Carbon::now();

        $creator = DB::table('irr5_invoice')
                        ->select(
                            // DB::raw("extract(year from receive_date) as year"),
                            DB::raw("extract(month from receive_date) as month"),
                            DB::raw("creator"),
                            DB::raw("count(*) as count"),
                        )
                        ->whereYear('receive_date', $date)
                        ->groupBy('month', 'creator')
                        ->get();
        
        $response = [
            'title' => 'Invoice Count By Creator This Year',
            'success' => true,
            'data' => $creator
        ];

        return $response;
    }

    public function thisYearMonths()
    {
        $date = Carbon::now();

        $month = DB::table('irr5_invoice')
            // ->select(
            //     DB::raw("extract(month from receive_date) as month"),
            // )
            ->selectRaw("MONTH(receive_date) as month")
            ->whereYear('receive_date', $date)
            ->groupBy('month')
            ->get();

        $response = [
            'title' => 'Invoice Count By Creator This Year',
            'success' => true,
            'data' => $month
        ];

        return $response;
    }

    public function thisMonthProcesed()
    {
        $date = Carbon::now();

        $count = DB::table('irr5_invoice')
                ->where('receive_place', 'BPN')
                ->whereYear('receive_date', $date)
                ->whereMonth('receive_date', $date)
                ->whereYear('mailroom_bpn_date', $date)
                ->whereMonth('mailroom_bpn_date', $date)
                ->count();

        $response = [
            'title' => 'Invoices Processed This Month',
            'success' => true,
            'data' => $count
        ];
            
        return $response;


        
    }
}
