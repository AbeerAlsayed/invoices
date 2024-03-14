<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InoviceAttachmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicesDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();
Route::resource('invoices',InvoiceController::class);
Route::resource('sections',SectionController::class);
Route::resource('products',ProductController::class);
Route::resource('InvoiceAttachments', InoviceAttachmentController::class);

Route::get('section/{id}',[InvoiceController::class,'get_product']);

Route::get('InvoicesDetails/{id}',[InvoicesDetailController::class,'edit']);
Route::get('View_file/{invoice_number}/{file_name}',[InvoicesDetailController::class,'open_file']);
Route::get('download/{invoice_number}/{file_name}',[InvoicesDetailController::class,'get_file']);
Route::get('/edit_invoice/{id}', [InvoiceController::class,'edit']);
Route::post('invoices/update', [InvoiceController::class,'update']);

Route::post('/delete_file',[InvoicesDetailController::class,'destroy'])->name('delete_file');


Route::get('/{page}',[AdminController::class,'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
