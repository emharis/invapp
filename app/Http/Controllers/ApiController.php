<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
	// public function getAutoCompleteMaskapai(Request $req){
	// 	$data = \DB::select('select id as data,nama as value from maskapai where nama like "%'.$req->get('nama').'%"');
	// 	$data_res = ['query'=>'Unit','suggestions' => $data];
	// 	return json_encode($data_res);
	// }

	public function getAutoCompleteMaskapai(Request $req){
		$data = \DB::select('select distinct(maskapai) as value, maskapai as data from invoice_tiket_data_pemesanan where maskapai like "%'.$req->get('nama').'%"');
		$data_res = ['query'=>'Unit','suggestions' => $data];
		return json_encode($data_res);	
	}

	public function getAutoCompleteNama(Request $req){
		$data = \DB::select('select nama as value, nama as data from view_nama where nama like "%'.$req->get('nama').'%"');
		$data_res = ['query'=>'Unit','suggestions' => $data];
		return json_encode($data_res);	
	}

	public function getAutoCompleteEmail(Request $req){
		// $data = \DB::select('select email as value, email as data from invoice_tiket where email like "%'.$req->get('nama').'%" and email != ""');
		$data = \DB::select('select email as value, email as data from view_email where email like "%'.$req->get('nama').'%" and email != ""');
		$data_res = ['query'=>'Unit','suggestions' => $data];
		return json_encode($data_res);	
	}

	public function getAutoCompleteKantor(Request $req){
		// $data = \DB::select('select kantor as value, kantor as data from invoice_tiket where kantor like "%'.$req->get('nama').'%" and kantor != ""');
		$data = \DB::select('select kantor as value, kantor as data from view_kantor where kantor like "%'.$req->get('nama').'%" and kantor != ""');
		$data_res = ['query'=>'Unit','suggestions' => $data];
		return json_encode($data_res);	
	}

	public function getAutoCompleteHotel(Request $req){
		$data = \DB::select('select hotel as value, hotel as data from invoice_hotel_data_pemesanan where hotel like "%'.$req->get('nama').'%"');
		$data_res = ['query'=>'Unit','suggestions' => $data];
		return json_encode($data_res);	
	}

}
