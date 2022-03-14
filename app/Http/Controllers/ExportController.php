<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Importer;
use App\Models\Order;

class ExportController extends Controller
{
    // constructor
    public function __construct()
    {

    }

    public function exportCsv(Request $request)
    {
        $filename = 'orders.csv';

        // load the files and parse into consistent object
        $importer = new Importer();
        $orders = $importer->importAll();

        foreach($orders as $line){
            $line->order_date = date('d/m/Y', $line->order_ts);
        }

        if(!empty($request->input('daterange'))){
            $dateRange = $request->input('daterange');
            $dateBits = explode(' - ', $dateRange);

            $order = new Order();
            $startTs = $order->convertOrderDate($dateBits[0]);
            $endTs = $order->convertOrderDate($dateBits[1]);

            $orders = $orders->whereBetween('order_ts', [$startTs, $endTs]);
        }

        if(!empty($request->input('sort_by'))){
            $orders = $orders->sortBy($request->input('sort_by'));
        }


        // foreach($orders as $line){
        //     dump($line);
        // }
        // dd($orders);

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['Product Name', 'Order Date', 'Subtotal', 'Vat Rate', 'Vat Paid', 'Total'];

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // dump($orders);
            foreach($orders as $order){
                $row['Product Name'] = $order->product_name;
                $row['Order Date'] = date('j-n-Y',$order->order_ts);
                $row['Subtotal'] = $order->subtotal;
                $row['Vat Rate'] = $order->vat_percentage;
                $row['Vat Paid'] = $order->vat_paid;
                $row['Total'] = $order->order_total;

                fputcsv($file, $row);       
            }


            fclose($file);
        };

        return response()->stream($callback, 200, $headers);

    }
}
