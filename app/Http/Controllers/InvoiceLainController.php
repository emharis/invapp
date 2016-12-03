<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoiceLainController extends Controller
{
	public function index(){

		$data = \DB::table('invoice_lain')
					->select('invoice_lain.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
					->orderBy('tgl_cetak','desc')
					->get();
		
		return view('invoice.lain.index',[
				'data' => $data
			]);
	}

	// create new hotel
	public function create(){
		return view('invoice.lain.create');
	}

	// insert new hotel
	public function insert(Request $req){

		return \DB::transaction(function()use($req){
			$inv_master = json_decode($req->inv_master);
			$inv_data_pemesanan = json_decode($req->inv_data_pemesanan);

			// echo $req->inv_master;
			// echo '<br/>-------------------------------<br/>';
			// echo $req->inv_data_pemesanan;

			// // echo $req->inv_master;
			// // echo '<br/>----------------------------------------<br/>';
			// // echo $req->inv_hotel;


			// -----------------------------------------------
			// GENERATE INVOICE NUMBER
				// generate invoice number
				$last_bulan = \DB::table('appsetting')->whereName('bulan_terakhir')->first()->value;
				$bulan_sekarang = date('m');

				if($bulan_sekarang > $last_bulan || ($bulan_sekarang == 1 && $last_bulan == 12) || ($bulan_sekarang == 0 && $last_bulan == 11) ){
					// update counter dan update bulan sekarang
					\DB::table('appsetting')->whereName('inv_lain_counter')->update(['value'=>1]);
					\DB::table('appsetting')->whereName('bulan_terakhir')->update(['value'=>$bulan_sekarang]);
				}

				$inv_prefix = \DB::table('appsetting')->whereName('inv_hotel_prefix')->first()->value;
				$inv_lain_counter = \DB::table('appsetting')->whereName('inv_lain_counter')->first()->value;
				
				$inv_postfix = "";
				// generate inv_number
				if( strlen($inv_lain_counter) == 1){
					$inv_postfix = "000" . $inv_lain_counter;
				}elseif( strlen($inv_lain_counter) == 2){
						$inv_postfix = "00" . $inv_lain_counter;
				}elseif( strlen($inv_lain_counter) == 3){
						$inv_postfix = "0" . $inv_lain_counter;
				}else{
						$inv_postfix =  $inv_lain_counter;
				}

				$inv_number = $inv_prefix .'/' . date('y') .date('m').$inv_postfix;

				// update inv counter
				$inv_lain_counter++;
				\DB::table('appsetting')->whereName('inv_lain_counter')->update(['value'=>$inv_lain_counter]);

			// ------------------------------------------------

			// generate tanggal_cetak
			$tanggal_cetak = $inv_master->tanggal_cetak;
            $arr_tgl = explode('-',$tanggal_cetak);
            $tanggal_cetak = new \DateTime();
            $tanggal_cetak->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);     

			// generate jatuh_tempo
			$jatuh_tempo = $inv_master->jatuh_tempo;
            $arr_tgl = explode('-',$jatuh_tempo);
            $jatuh_tempo = new \DateTime();
            $jatuh_tempo->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]); 

   //          // echo $req->inv_master .'<br/>';
   //          // echo $req->inv_hotel .'<br/>';

			$inv_id = \DB::table('invoice_lain')->insertGetId([
					'inv_num' => $inv_number,
					'tgl_cetak' => $tanggal_cetak,
					'jatuh_tempo' => $jatuh_tempo,
					'total' => $inv_master->total,
					'terbilang' => strtoupper(convertTerbilang($inv_master->total)),
					'nama' => strtoupper($inv_master->nama),
					'kantor' => strtoupper($inv_master->kantor),
					'alamat' => strtoupper($inv_master->alamat),
					'telp' => $inv_master->telp,
					'email' => strtoupper($inv_master->email),
					'user_id' => \Auth::user()->id
				]);

			// // input data Pemesanan
			foreach($inv_data_pemesanan->data as $dt){
				\DB::table('invoice_lain_detail')
					->insert([
							// 'user_id' => \Auth::user()->id,
							'invoice_lain_id' => $inv_id,
							'keterangan' => strtoupper($dt->keterangan),
							'harga_satuan' => $dt->harga_satuan,
							'jumlah' => $dt->jumlah,
							'total_harga' => $dt->total_harga,
							// 'hotel_id' => $dt->hotel_id,
							// 'hotel' => $dt->hotel,
						]);
				
			}

			return redirect('invoice/invoice-lain');

		});
	}

	// edit data hotel
	public function edit($invoice_id){

		$inv_master = \DB::table('invoice_lain')
						->select('invoice_lain.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
						->find($invoice_id);
		$inv_master->data_pemesanan = \DB::table('invoice_lain_detail')
										->where('invoice_lain_id',$invoice_id)
										->get();
		
		return view('invoice.lain.edit',[
				'data'=>$inv_master,
			]);
	}

	// simpan edit 
	public function update(Request $req){
		
		return \DB::transaction(function()use($req){
			$inv_master = json_decode($req->inv_master);
			$inv_data_pemesanan = json_decode($req->inv_data_pemesanan);

			// generate tanggal_cetak
			$tanggal_cetak = $inv_master->tanggal_cetak;
            $arr_tgl = explode('-',$tanggal_cetak);
            $tanggal_cetak = new \DateTime();
            $tanggal_cetak->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);     

			// generate jatuh_tempo
			$jatuh_tempo = $inv_master->jatuh_tempo;
            $arr_tgl = explode('-',$jatuh_tempo);
            $jatuh_tempo = new \DateTime();
            $jatuh_tempo->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]); 

            // echo $req->inv_master .'<br/>';
            // echo $req->inv_hotel .'<br/>';
            $inv_id = $inv_master->invoice_lain_id;

			\DB::table('invoice_lain')
				->where('id',$inv_id)
				->update([
					'tgl_cetak' => $tanggal_cetak,
					'jatuh_tempo' => $jatuh_tempo,
					'total' => $inv_master->total,
					'terbilang' => strtoupper(convertTerbilang($inv_master->total)),
					'nama' => strtoupper($inv_master->nama),
					'kantor' => strtoupper($inv_master->kantor),
					'alamat' => strtoupper($inv_master->alamat),
					'telp' => $inv_master->telp,
					'email' => strtoupper($inv_master->email),
				]);

			// delete data lama
			\DB::table('invoice_lain_detail')
						->where('invoice_lain_id',$inv_id)
						->delete();
						
			// input data TAMU
			// // input data Pemesanan
			foreach($inv_data_pemesanan->data as $dt){
				\DB::table('invoice_lain_detail')
					->insert([
							'invoice_lain_id' => $inv_id,
							'keterangan' => strtoupper($dt->keterangan),
							'harga_satuan' => $dt->harga_satuan,
							'jumlah' => $dt->jumlah,
							'total_harga' => $dt->total_harga,
						]);
				
			}

			return redirect('invoice/invoice-lain');
		});

		// END OF UPDATE FUNCTION
	}

	public function delete(Request $req){
		$dataid = json_decode($req->dataid);
		foreach($dataid as $dt){
			\DB::table('invoice_lain')->delete($dt->id);
		}

		return redirect('invoice/invoice-lain');
	} 

}
