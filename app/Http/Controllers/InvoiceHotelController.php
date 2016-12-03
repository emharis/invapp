<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoiceHotelController extends Controller
{
	public function index(){

		$data = \DB::table('invoice_hotel')
					->select('invoice_hotel.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
					->orderBy('tgl_cetak','desc')
					->get();
		
		return view('invoice.hotel.index',[
				'data' => $data
			]);
	}

	// create new hotel
	public function create(){
		return view('invoice.hotel.create');
	}

	public function generateInvoice(){
			// generate invoice number
			$last_bulan = \DB::table('appsetting')->whereName('bulan_terakhir')->first()->value;
			$bulan_sekarang = date('m');

			if($bulan_sekarang > $last_bulan || ($bulan_sekarang == 1 && $last_bulan == 12) || ($bulan_sekarang == 0 && $last_bulan == 11) ){
				// update counter dan update bulan sekarang
				\DB::table('appsetting')->whereName('inv_hotel_counter')->update(['value'=>1]);
				\DB::table('appsetting')->whereName('bulan_terakhir')->update(['value'=>$bulan_sekarang]);
			}

			$inv_prefix = \DB::table('appsetting')->whereName('inv_hotel_prefix')->first()->value;
			$inv_hotel_counter = \DB::table('appsetting')->whereName('inv_hotel_counter')->first()->value;
			
			$inv_postfix = "";
			// generate inv_number
			if( strlen($inv_hotel_counter) == 1){
				$inv_postfix = "000" . $inv_hotel_counter;
			}elseif( strlen($inv_hotel_counter) == 2){
					$inv_postfix = "00" . $inv_hotel_counter;
			}elseif( strlen($inv_hotel_counter) == 3){
					$inv_postfix = "0" . $inv_hotel_counter;
			}else{
					$inv_postfix =  $inv_hotel_counter;
			}

			$inv_number = $inv_prefix .'/' . date('y') .date('m').$inv_postfix;

			// update inv counter
			$inv_hotel_counter++;
			\DB::table('appsetting')->whereName('inv_hotel_counter')->update(['value'=>$inv_hotel_counter]);
						


	}

	// insert new hotel
	public function insert(Request $req){

		return \DB::transaction(function()use($req){
			$inv_master = json_decode($req->inv_master);
			$inv_hotel = json_decode($req->inv_hotel);

			// echo $req->inv_master;
			// echo '<br/>----------------------------------------<br/>';
			// echo $req->inv_hotel;


			// -----------------------------------------------
			// GENERATE INVOICE NUMBER
				// generate invoice number
				$last_bulan = \DB::table('appsetting')->whereName('bulan_terakhir')->first()->value;
				$bulan_sekarang = date('m');

				if($bulan_sekarang > $last_bulan || ($bulan_sekarang == 1 && $last_bulan == 12) || ($bulan_sekarang == 0 && $last_bulan == 11) ){
					// update counter dan update bulan sekarang
					\DB::table('appsetting')->whereName('inv_hotel_counter')->update(['value'=>1]);
					\DB::table('appsetting')->whereName('bulan_terakhir')->update(['value'=>$bulan_sekarang]);
				}

				$inv_prefix = \DB::table('appsetting')->whereName('inv_hotel_prefix')->first()->value;
				$inv_hotel_counter = \DB::table('appsetting')->whereName('inv_hotel_counter')->first()->value;
				
				$inv_postfix = "";
				// generate inv_number
				if( strlen($inv_hotel_counter) == 1){
					$inv_postfix = "000" . $inv_hotel_counter;
				}elseif( strlen($inv_hotel_counter) == 2){
						$inv_postfix = "00" . $inv_hotel_counter;
				}elseif( strlen($inv_hotel_counter) == 3){
						$inv_postfix = "0" . $inv_hotel_counter;
				}else{
						$inv_postfix =  $inv_hotel_counter;
				}

				$inv_number = $inv_prefix .'/' . date('y') .date('m').$inv_postfix;

				// update inv counter
				$inv_hotel_counter++;
				\DB::table('appsetting')->whereName('inv_hotel_counter')->update(['value'=>$inv_hotel_counter]);

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

            // echo $req->inv_master .'<br/>';
            // echo $req->inv_hotel .'<br/>';

			$inv_id = \DB::table('invoice_hotel')->insertGetId([
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

			// input data TAMU
			foreach($inv_hotel->hotel as $dt){
				// set check in check out
				$check_in = $dt->check_in;
	            $arr_tgl = explode('-',$check_in);
	            $check_in = new \DateTime();
	            $check_in->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]); 

				$check_out= $dt->check_out;
	            $arr_tgl = explode('-',$check_out);
	            $check_out = new \DateTime();
	            $check_out->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]); 

				$data_pemesanan_id = \DB::table('invoice_hotel_data_pemesanan')
									->insertGetId([
											'user_id' => \Auth::user()->id,
											'invoice_hotel_id' => $inv_id,
											'kode_pemesanan' => strtoupper($dt->kode_pemesanan),
											'harga' => $dt->harga,
											'check_in' => $check_in,
											'check_out' => $check_out,
											// 'hotel_id' => $dt->hotel_id,
											'hotel' => strtoupper($dt->hotel),
										]);
				// insert data tamu
				foreach($dt->tamu->tamu as $pg){
					\DB::table('invoice_hotel_data_tamu')->insert([
							'user_id' => \Auth::user()->id,
							'invoice_hotel_data_pemesanan_id' => $data_pemesanan_id,
							'titel' => $pg->titel,
							'nama' => strtoupper($pg->nama),
							'nomor_voucher' => strtoupper($pg->nomor_voucher),

						]);
				}
			}

			return redirect('invoice/hotel');

		});
	}

	// edit data hotel
	public function edit($hotel_id){

		$inv_master = \DB::table('invoice_hotel')
						->select('invoice_hotel.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
						->find($hotel_id);
		$inv_master->data_pemesanan = \DB::table('invoice_hotel_data_pemesanan')
										->select('invoice_hotel_data_pemesanan.*',\DB::raw('date_format(check_in,"%d-%m-%Y") as check_in_formatted'),\DB::raw('date_format(check_out,"%d-%m-%Y") as check_out_formatted'))
										->where('invoice_hotel_id',$hotel_id)
										->get();
		// $inv_master->data_pemesanan = \DB::table('invoice_hotel_data_pemesanan')
		// 								->join('hotel','invoice_hotel_data_pemesanan.hotel_id','=','hotel.id')
		// 								->select('invoice_hotel_data_pemesanan.*','hotel.nama as nama_hotel')
		// 								->where('invoice_hotel_id',$hotel_id)
		// 								->get();
		foreach($inv_master->data_pemesanan as $dt){
			$dt->data_tamu = \DB::table('invoice_hotel_data_tamu')
									->where('invoice_hotel_data_pemesanan_id',$dt->id)
									->get();
		}

		// echo var_dump($inv_master);

		return view('invoice.hotel.edit',[
				'data'=>$inv_master,
				// 'data_detail'=>$data_detail,
			]);
	}

	// simpan edit 
	public function update(Request $req){
		
		return \DB::transaction(function()use($req){
			$inv_master = json_decode($req->inv_master);
			$inv_hotel = json_decode($req->inv_hotel);

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
            $inv_id = $inv_master->invoice_hotel_id;
			\DB::table('invoice_hotel')
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
				\DB::table('invoice_hotel_data_pemesanan')
						->where('invoice_hotel_id',$inv_id)
						->delete();
						
			// input data TAMU
			foreach($inv_hotel->hotel as $dt){
				// set check in check out
				$check_in = $dt->check_in;
	            $arr_tgl = explode('-',$check_in);
	            $check_in = new \DateTime();
	            $check_in->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]); 

				$check_out= $dt->check_out;
	            $arr_tgl = explode('-',$check_out);
	            $check_out = new \DateTime();
	            $check_out->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]); 

				$data_pemesanan_id = \DB::table('invoice_hotel_data_pemesanan')
									->insertGetId([
											'user_id' => \Auth::user()->id,
											'invoice_hotel_id' => $inv_id,
											'kode_pemesanan' => strtoupper($dt->kode_pemesanan),
											'harga' => $dt->harga,
											'check_in' => $check_in,
											'check_out' => $check_out,
											// 'hotel_id' => $dt->hotel_id,
											'hotel' => strtoupper($dt->hotel),
										]);
				// insert data tamu
				foreach($dt->tamu->tamu as $pg){
					\DB::table('invoice_hotel_data_tamu')->insert([
							'user_id' => \Auth::user()->id,
							'invoice_hotel_data_pemesanan_id' => $data_pemesanan_id,
							'titel' => $pg->titel,
							'nama' => strtoupper($pg->nama),
							'nomor_voucher' => strtoupper($pg->nomor_voucher),

						]);
				}
			}

			return redirect('invoice/hotel');
		});

		// END OF UPDATE FUNCTION
	}

	public function delete(Request $req){
		$dataid = json_decode($req->dataid);
		foreach($dataid as $dt){
			\DB::table('invoice_hotel')->delete($dt->id);
		}

		return redirect('invoice/hotel');
	} 

}
