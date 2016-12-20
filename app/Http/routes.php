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

     // PROFILE
    Route::get('profile','ProfileController@index');
    Route::post('profile/update','ProfileController@update');

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
        Route::get('tiket/cetak-tiket/{invoice_id}','InvoiceTiketController@cetakInvoice');        
        Route::get('tiket/cetak-dot-matrix/{invoice_id}','InvoiceTiketController@cetakDotMatrix');        
        Route::get('tiket/cetak-kwitansi/{invoice_id}','InvoiceTiketController@cetakKwitansi');        
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
        Route::get('hotel/cetak-invoice/{invoice_id}','InvoiceHotelController@cetakInvoice');        
        Route::get('hotel/cetak-kwitansi/{invoice_id}','InvoiceHotelController@cetakKwitansi');        
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
        Route::get('invoice-lain/cetak-invoice/{invoice_id}','InvoiceLainController@cetakInvoice');        
        Route::get('invoice-lain/cetak-kwitansi/{invoice_id}','InvoiceLainController@cetakKwitansi');        
        // ------------------------------------------------

    });

     Route::group(['prefix' => 'kwitansi'], function () {
        Route::get('/','KwitansiController@index');
        Route::get('get-banyaknya-uang-string/{number}','KwitansiController@getTerbilang');
        Route::post('cetak','KwitansiController@cetak');
        Route::get('cetak-kosong','KwitansiController@cetakKosong');
    });

    Route::group(['prefix' => 'rekap'], function () {
        // REKAP TIKET
        Route::get('tiket','RekapTiketController@index');
        Route::post('tiket/default-filter','RekapTiketController@defaultFilter');
        Route::get('tiket/get-detail-invoice/{invoice_id}','RekapTiketController@getDetailInvoice');
        // Route::post('tiket/cetak-by-tanggal','RekapTiketController@cetakByTanggal');
        Route::get('tiket/cetak-by-tanggal/{tanggal_awal}/{tanggal_akhir}','RekapTiketController@cetakByTanggal');
        Route::post('tiket/cetak-with-option','RekapTiketController@cetakWithOption');

        // REKAP HOTEL
        Route::get('hotel','RekapHotelController@index');
        Route::post('hotel/default-filter','RekapHotelController@defaultFilter');
        Route::get('hotel/get-detail-invoice/{invoice_id}','RekapHotelController@getDetailInvoice');
        // Route::post('hotel/cetak-by-tanggal','RekapHotelController@cetakByTanggal');
        Route::get('hotel/cetak-by-tanggal/{tanggal_awal}/{tanggal_akhir}','RekapHotelController@cetakByTanggal');
        Route::post('hotel/cetak-with-option','RekapHotelController@cetakWithOption');

        // REKAP LAIN
        Route::get('lain','RekapLainController@index');
        Route::post('lain/default-filter','RekapLainController@defaultFilter');
        Route::get('lain/get-detail-invoice/{invoice_id}','RekapLainController@getDetailInvoice');
        Route::get('lain/cetak-by-tanggal/{tanggal_awal}/{tanggal_akhir}','RekapLainController@cetakByTanggal');
        Route::post('lain/cetak-with-option','RekapLainController@cetakWithOption');

    });

    Route::group(['prefix' => 'setting'], function () {
        // SYSTEM SETTING
        Route::get('system','SettingController@index');
        Route::post('system/update-data-perusahaan','SettingController@updateDataPerusahaan');
        Route::post('system/update-setting-invoice','SettingController@updateSettingInvoice');

        // USER SETTING
        Route::get('user','UserController@index');
        Route::get('user/edit/{id}','UserController@edit');
        Route::post('user/update','UserController@update');
        Route::get('user/create','UserController@create');
        Route::post('user/insert','UserController@insert');
        Route::post('user/delete','UserController@delete');

        

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
Route::get('api/get-auto-complete-lain','ApiController@getAutoCompleteLain');
