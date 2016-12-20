<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
	public function index(){

		$jml_invoice_tiket = \DB::table('invoice_tiket')->count();
		$jml_invoice_hotel = \DB::table('invoice_hotel')->count();
		$jml_invoice_lain = \DB::table('invoice_lain')->count();
		
		return view('home',[
				'jml_invoice_tiket' => $jml_invoice_tiket,
				'jml_invoice_hotel' => $jml_invoice_hotel,
				'jml_invoice_lain' => $jml_invoice_lain,
			]);
	}
}
