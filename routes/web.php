<?php

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
    return view('auth.login') ;
});

Auth::routes();

//Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');

route::resource('invoices','InvoicesController');

route::resource('sections','SectionsController');

route::resource('products','ProductsController');

Route::resource('InvoiceAttachments', 'InvoicesAttachmentsController');

route::get('/section/{id}','InvoicesController@getProducts');

route::get('/InvoicesDetails/{id}','InvoicesDetailsController@edit');

Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetailsController@get_file');

Route::get('View_file/{invoice_number}/{file_name}', 'InvoicesDetailsController@open_file');

Route::post('delete_file', 'InvoicesDetailsController@destroy')->name('delete_file');

route::get('/edit_invoice/{id}','InvoicesController@edit');

Route::get('/Status_show/{id}', 'InvoicesController@show')->name('Status_show');

Route::post('/Status_Update/{id}', 'InvoicesController@Status_Update')->name('Status_Update');

Route::resource('Archive', 'InvoiceArchiveController');

Route::get('Invoice_Paid','InvoicesController@Invoice_Paid');

Route::get('Invoice_UnPaid','InvoicesController@Invoice_UnPaid');

Route::get('Invoice_Partial','InvoicesController@Invoice_Partial');

Route::get('Print_invoice/{id}','InvoicesController@Print_invoice');

Route::get('export_invoices', 'InvoicesController@export');



Route::group(['middleware' => ['auth']], function() {
Route::resource('roles','RoleController');
Route::resource('users','UserController');

});

Route::get('invoices_report', 'InvoicesReport@index');

Route::post('search_invoices', 'InvoicesReport@search_invoices');

Route::get('customer_report', 'CustomerReport@index');

Route::post('search_customer', 'CustomerReport@search_customer');


Route::get('MarkAsRead_all','InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');


Route::get('/{page}', 'AdminController@index');
