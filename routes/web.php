<?php

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/invoice/{id}', function ($id) {
   // print pdf invoice
    $invoice = Invoice::where('user_id', auth()->id())->find($id);
    $pdf = Pdf::loadView('filament.invoice', compact('id'))->setOptions(['defaultFont' => 'sans-serif']);
    return $pdf->stream();
})->name('invoice.pdf');

