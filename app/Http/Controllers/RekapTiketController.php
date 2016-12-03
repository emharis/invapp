<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RekapTiketController extends Controller
{
	public function index(){

		$data = \DB::table('view_rekap_invoice_tiket')
					->orderBy('tgl_cetak','desc')
					->orderBy('invoice_tiket_id')
					->get();
		
		return view('rekap.tiket.index',[
				'data' => $data
			]);
	}

	public function defaultfilter(Request $req){
		// cek jenis filter
		if($req->filter_option == ""){
			// // generate tanggal_cetak
			// $tanggal_cetak_awal = $req->tanggal_cetak_awal;
	  //       $arr_tgl = explode('-',$tanggal_cetak_awal);
	  //       $tanggal_cetak_awal = new \DateTime();
	  //       $tanggal_cetak_awal->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);     
	  //       $tanggal_cetak_awal_str = $arr_tgl[2].'-'.$arr_tgl[1].'-'.$arr_tgl[0];     

			// // generate jatuh_tempo
			// $tanggal_cetak_akhir = $req->tanggal_cetak_akhir;
	  //       $arr_tgl = explode('-',$tanggal_cetak_akhir);
	  //       $tanggal_cetak_akhir = new \DateTime();
	  //       $tanggal_cetak_akhir->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]); 
	  //       $tanggal_cetak_akhir_str = $arr_tgl[2].'-'.$arr_tgl[1].'-'.$arr_tgl[0];

	  //       $data = \DB::table('view_rekap_invoice_tiket')
	  //       			->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
	  //       			->get();

	  //       return view('rekap.tiket.filter-by-tanggal',[
	  //       		'data' => $data
	  //       	]);

			return $this->filterByTanggal($req);
		}
	}

	public function filterByTanggal(Request $req){
		// generate tanggal_cetak
		$tanggal_cetak_awal = $req->tanggal_cetak_awal;
        $arr_tgl = explode('-',$tanggal_cetak_awal);
        $tanggal_cetak_awal = new \DateTime();
        $tanggal_cetak_awal->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);     
        $tanggal_cetak_awal_str = $arr_tgl[2].'-'.$arr_tgl[1].'-'.$arr_tgl[0];     

		// generate jatuh_tempo
		$tanggal_cetak_akhir = $req->tanggal_cetak_akhir;
        $arr_tgl = explode('-',$tanggal_cetak_akhir);
        $tanggal_cetak_akhir = new \DateTime();
        $tanggal_cetak_akhir->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]); 
        $tanggal_cetak_akhir_str = $arr_tgl[2].'-'.$arr_tgl[1].'-'.$arr_tgl[0];

        // $data = \DB::table('view_rekap_invoice_tiket')
        // 			->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
        // 			->get();

        $data_invoice = \DB::table('invoice_tiket')
        				->select('invoice_tiket.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        				->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
        				->get();

        // foreach($data_invoice as $dt){
        // 	$dt->
        // }

        return view('rekap.tiket.filter-by-tanggal',[
        		'data' => $data_invoice
        	]);
        
	}

	public function getDetailInvoice($invoice_id){
		$data_pemesanan = \DB::table('invoice_tiket_data_pemesanan')->where('invoice_tiket_id',$invoice_id)->get();
		foreach($data_pemesanan as $dp){
			$dp->data_penumpang = \DB::table('invoice_tiket_data_penumpang')->where('invoice_tiket_data_pemesanan_id',$dp->id)->get();
		}

		return view('rekap.tiket.detail_invoice',[
				'data_pemesanan' => $data_pemesanan
			]);
	}

}
