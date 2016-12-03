<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// -----------------------------------------------------------
// LOGIN
// -----------------------------------------------------------

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('home');
    } else {
        return view('login');
    }
});
Route::get('login',function(){
	if (Auth::check()) {
        return redirect('home');
    } else {
        return view('login');
    }
});
Route::get('logout', function() {
    Auth::logout();
    return redirect('login');
});
Route::post('login',function(){
	if (Auth::attempt(['username' => Request::input('username'), 'password' => Request::input('password')])) {
            // Authentication passed...
            return redirect('home');
    }else{
    	return redirect()->back();
    }

});

// -----------------------------------------------------------
// END LOGIN
// -----------------------------------------------------------




Route::group(['middleware' => ['web','auth']], function () {
	 Route::get('home','HomeController@index');

     Route::group(['prefix' => 'master'], function () {

        // MASTER MASKAPAI
        Route::get('/','MaskapaiController@index');
        Route::get('maskapai','MaskapaiController@index');
        Route::get('maskapai/create','MaskapaiController@create');
        Route::get('maskapai/edit/{maskapai_id}','MaskapaiController@edit');
        Route::post('maskapai/insert','MaskapaiController@insert');
        Route::post('maskapai/update','MaskapaiController@update');
        Route::post('maskapai/delete','MaskapaiController@delete');
        // ------------------------------------------------

        // MASTER HOTEL
        Route::get('hotel','HotelController@index');
        Route::get('hotel/create','HotelController@create');
        Route::get('hotel/edit/{hotel_id}','HotelController@edit');
        Route::post('hotel/insert','HotelController@insert');
        Route::post('hotel/update','HotelController@update');
        Route::post('hotel/delete','HotelController@delete');

        // ------------------------------------------------

    });

     Route::group(['prefix' => 'invoice'], function () {

        // INVOICE TIKET PESAWAT
        Route::get('/','InvoiceTiketController@index');
        Route::get('tiket/generate-invoice','InvoiceTiketController@generateInvoice');
        Route::get('tiket','InvoiceTiketController@index');
        Route::get('tiket/create','InvoiceTiketController@create');
        Route::get('tiket/edit/{maskapai_id}','InvoiceTiketController@edit');
        Route::post('tiket/insert','InvoiceTiketController@insert');
        Route::post('tiket/update','InvoiceTiketController@update');
        Route::post('tiket/delete','InvoiceTiketController@delete');        
        Route::get('tiket/terbilang/{val}','InvoiceTiketController@terbilangs');        
        Route::get('tiket/cetak-tiket/{invoice_id}','InvoiceTiketController@cetakTiket');        
        // ------------------------------------------------

        // INVOICE HOTEL
        Route::get('/','InvoiceHotelController@index');
        Route::get('hotel/generate-invoice','InvoiceHotelController@generateInvoice');
        Route::get('hotel','InvoiceHotelController@index');
        Route::get('hotel/create','InvoiceHotelController@create');
        Route::get('hotel/edit/{maskapai_id}','InvoiceHotelController@edit');
        Route::post('hotel/insert','InvoiceHotelController@insert');
        Route::post('hotel/update','InvoiceHotelController@update');
        Route::post('hotel/delete','InvoiceHotelController@delete');        
        Route::get('hotel/terbilang/{val}','InvoiceHotelController@terbilangs');        
        // ------------------------------------------------

        // INVOICE LAIN
        Route::get('/','InvoiceLainController@index');
        Route::get('invoice-lain/generate-invoice','InvoiceLainController@generateInvoice');
        Route::get('invoice-lain','InvoiceLainController@index');
        Route::get('invoice-lain/create','InvoiceLainController@create');
        Route::get('invoice-lain/edit/{maskapai_id}','InvoiceLainController@edit');
        Route::post('invoice-lain/insert','InvoiceLainController@insert');
        Route::post('invoice-lain/update','InvoiceLainController@update');
        Route::post('invoice-lain/delete','InvoiceLainController@delete');        
        Route::get('invoice-lain/terbilang/{val}','InvoiceLainController@terbilangs');        
        // ------------------------------------------------

        // MASTER HOTEL
        // Route::get('hotel','HotelController@index');
        // Route::get('hotel/create','HotelController@create');
        // Route::get('hotel/edit/{hotel_id}','HotelController@edit');
        // Route::post('hotel/insert','HotelController@insert');
        // Route::post('hotel/update','HotelController@update');
        // ------------------------------------------------

    });

     Route::group(['prefix' => 'rekap'], function () {
        // REKAP TIKET
        Route::get('tiket','RekapTiketController@index');
        Route::post('tiket/default-filter','RekapTiketController@defaultFilter');
        Route::get('tiket/get-detail-invoice/{invoice_id}','RekapTiketController@getDetailInvoice');

    });

});

// sidebar setting
Route::get('sidebar-update', function() {
    $value = \DB::table('appsetting')->whereName('sidebar_collapse')->first()->value;
    \DB::table('appsetting')->whereName('sidebar_collapse')->update(['value' => $value == 1 ? '0' : '1']);
});

Route::get('api/get-auto-complete-maskapai','ApiController@getAutoCompleteMaskapai');
Route::get('api/get-auto-complete-maskapai-from-invoice','ApiController@getAutoCompleteMaskapaiFromInvoice');
Route::get('api/get-auto-complete-nama','ApiController@getAutoCompleteNama');
Route::get('api/get-auto-complete-email','ApiController@getAutoCompleteEmail');
Route::get('api/get-auto-complete-kantor','ApiController@getAutoCompleteKantor');

Route::get('api/get-auto-complete-hotel','ApiController@getAutoCompleteHotel');
