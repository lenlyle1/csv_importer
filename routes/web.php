<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Importer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    // import the data for creating the date picker
    $importer = new Importer();
    $dataCollection = $importer->importAll();

    $dataCollection = $dataCollection->sortBy('order_ts');

    foreach($dataCollection as $line){
        $line->order_date = date('d/m/Y', $line->order_ts);
    }

    $lowdate = $dataCollection->first();
    $highdate = $dataCollection->last();

    return view('challenge', ['low' => $lowdate, 'high' => $highdate]);
});


Route::get('/export', [ExportController::class, 'exportCsv']);