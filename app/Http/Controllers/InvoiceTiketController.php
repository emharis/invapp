<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class InvoiceTiketController extends Controller
{
	public function index(){

		$data = \DB::table('invoice_tiket')
					->select('invoice_tiket.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
					->orderBy('tgl_cetak','desc')
					->get();
		
		return view('invoice.tiket.index',[
				'data' => $data
			]);
	}

	// create new tiket
	public function create(){
		return view('invoice.tiket.create');
	}

	public function generateInvoice(){
			// generate invoice number
			$last_bulan = \DB::table('appsetting')->whereName('bulan_terakhir')->first()->value;
			$bulan_sekarang = date('m');

			if($bulan_sekarang > $last_bulan || ($bulan_sekarang == 1 && $last_bulan == 12) || ($bulan_sekarang == 0 && $last_bulan == 11) ){
				// update counter dan update bulan sekarang
				\DB::table('appsetting')->whereName('inv_tiket_counter')->update(['value'=>1]);
				\DB::table('appsetting')->whereName('bulan_terakhir')->update(['value'=>$bulan_sekarang]);
			}

			$inv_prefix = \DB::table('appsetting')->whereName('inv_tiket_prefix')->first()->value;
			$inv_tiket_counter = \DB::table('appsetting')->whereName('inv_tiket_counter')->first()->value;
			
			$inv_postfix = "";
			// generate inv_number
			if( strlen($inv_tiket_counter) == 1){
				$inv_postfix = "000" . $inv_tiket_counter;
			}elseif( strlen($inv_tiket_counter) == 2){
					$inv_postfix = "00" . $inv_tiket_counter;
			}elseif( strlen($inv_tiket_counter) == 3){
					$inv_postfix = "0" . $inv_tiket_counter;
			}else{
					$inv_postfix =  $inv_tiket_counter;
			}

			$inv_number = $inv_prefix .'/' . date('y') .date('m').$inv_postfix;

			// update inv counter
			$inv_tiket_counter++;
			\DB::table('appsetting')->whereName('inv_tiket_counter')->update(['value'=>$inv_tiket_counter]);
						


	}

	// insert new tiket
	public function insert(Request $req){

		return \DB::transaction(function()use($req){
			$inv_master = json_decode($req->inv_master);
			$inv_tiket = json_decode($req->inv_tiket);

			// echo $req->inv_master;
			// echo '<br/>----------------------------------------<br/>';
			// echo $req->inv_tiket;


			// -----------------------------------------------
			// GENERATE INVOICE NUMBER
				// generate invoice number
				$last_bulan = \DB::table('appsetting')->whereName('bulan_terakhir')->first()->value;
				$bulan_sekarang = date('m');

				if($bulan_sekarang > $last_bulan || ($bulan_sekarang == 1 && $last_bulan == 12) || ($bulan_sekarang == 0 && $last_bulan == 11) ){
					// update counter dan update bulan sekarang
					\DB::table('appsetting')->whereName('inv_tiket_counter')->update(['value'=>1]);
					\DB::table('appsetting')->whereName('bulan_terakhir')->update(['value'=>$bulan_sekarang]);
				}

				$inv_prefix = \DB::table('appsetting')->whereName('inv_tiket_prefix')->first()->value;
				$inv_tiket_counter = \DB::table('appsetting')->whereName('inv_tiket_counter')->first()->value;
				
				$inv_postfix = "";
				// generate inv_number
				if( strlen($inv_tiket_counter) == 1){
					$inv_postfix = "000" . $inv_tiket_counter;
				}elseif( strlen($inv_tiket_counter) == 2){
						$inv_postfix = "00" . $inv_tiket_counter;
				}elseif( strlen($inv_tiket_counter) == 3){
						$inv_postfix = "0" . $inv_tiket_counter;
				}else{
						$inv_postfix =  $inv_tiket_counter;
				}

				$inv_number = $inv_prefix .'/' . date('y') .date('m').$inv_postfix;

				// update inv counter
				$inv_tiket_counter++;
				\DB::table('appsetting')->whereName('inv_tiket_counter')->update(['value'=>$inv_tiket_counter]);

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
            // echo $req->inv_tiket .'<br/>';

			$inv_id = \DB::table('invoice_tiket')->insertGetId([
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

			// input data pemesanan
			foreach($inv_tiket->tiket as $dt){
				$data_pemesanan_id = \DB::table('invoice_tiket_data_pemesanan')
									->insertGetId([
											'user_id' => \Auth::user()->id,
											'invoice_tiket_id' => $inv_id,
											'kode_pemesanan' => strtoupper($dt->kode_pemesanan),
											'harga' => $dt->harga,
											'pergi' => $dt->pergi,
											'pulang' => $dt->pulang,
											// 'maskapai_id' => $dt->maskapai_id,
											'maskapai' => strtoupper($dt->maskapai),
										]);
				// insert data penumpang
				foreach($dt->penumpang->penumpang as $pg){
					\DB::table('invoice_tiket_data_penumpang')->insert([
							'user_id' => \Auth::user()->id,
							'invoice_tiket_data_pemesanan_id' => $data_pemesanan_id,
							'titel' => $pg->titel,
							'nama' => strtoupper($pg->nama),
							'nomor_tiket' => strtoupper($pg->no_tiket),

						]);
				}
			}

			return redirect('invoice/tiket');
		});
	}

	// edit data tiket
	public function edit($tiket_id){
		// $data = \DB::table('invoice_tiket')->find($tiket_id);
		// $data_detail = \DB::table('invoice_tiket_detail')
		// 				->select('invoice_tiket_detail.*',\DB::raw('maskapai.nama as maskapai'))
		// 				->join('maskapai','invoice_tiket_detail.maskapai_id','=','maskapai.id')
		// 				->whereInvoiceTiketId($tiket_id)
		// 				->get();

		// return view('invoice.tiket.edit',[
		// 		'data'=>$data,
		// 		'data_detail'=>$data_detail,
		// 	]);

		// echo 'edit';

		$inv_master = \DB::table('invoice_tiket')
						->select('invoice_tiket.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
						->find($tiket_id);
		$inv_master->data_pemesanan = \DB::table('invoice_tiket_data_pemesanan')
										->where('invoice_tiket_id',$tiket_id)
										->get();
		// $inv_master->data_pemesanan = \DB::table('invoice_tiket_data_pemesanan')
		// 								->join('maskapai','invoice_tiket_data_pemesanan.maskapai_id','=','maskapai.id')
		// 								->select('invoice_tiket_data_pemesanan.*','maskapai.nama as nama_maskapai')
		// 								->where('invoice_tiket_id',$tiket_id)
		// 								->get();
		foreach($inv_master->data_pemesanan as $dt){
			$dt->data_penumpang = \DB::table('invoice_tiket_data_penumpang')
									->where('invoice_tiket_data_pemesanan_id',$dt->id)
									->get();
		}

		// echo var_dump($inv_master);

		return view('invoice.tiket.edit',[
				'data'=>$inv_master,
				// 'data_detail'=>$data_detail,
			]);
	}

	// simpan edit 
	public function update(Request $req){
		
		return \DB::transaction(function()use($req){
			$inv_master = json_decode($req->inv_master);
			$inv_tiket = json_decode($req->inv_tiket);

			// echo $req->inv_master;
			// echo '<br/>----------------------------------------<br/>';
			// echo $req->inv_tiket;


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
            // echo $req->inv_tiket .'<br/>';

			\DB::table('invoice_tiket')
				->where('id',$inv_master->invoice_tiket_id)
				->update([
					'tgl_cetak' => $tanggal_cetak,
					'jatuh_tempo' => $jatuh_tempo,
					'total' => $inv_master->total,
					'terbilang' => strtoupper(convertTerbilang($inv_master->total)),
					'nama' => strtoupper($inv_master->nama),
					'kantor' => strtoupper($inv_master->kantor),
					'alamat' => strtoupper($inv_master->alamat),
					'telp' => $inv_master->telp,
					'email' => strtoupper($inv_master->email)
				]);

			// delete data pemesanan yang lama
			\DB::table('invoice_tiket_data_pemesanan')->where('invoice_tiket_id',$inv_master->invoice_tiket_id)->delete();
			// input data pemesanan
			foreach($inv_tiket->tiket as $dt){
				$data_pemesanan_id = \DB::table('invoice_tiket_data_pemesanan')
									->insertGetId([
											'user_id' => \Auth::user()->id,
											'invoice_tiket_id' => $inv_master->invoice_tiket_id,
											'kode_pemesanan' => strtoupper($dt->kode_pemesanan),
											'harga' => $dt->harga,
											'pergi' => $dt->pergi,
											'pulang' => $dt->pulang,
											// 'maskapai_id' => $dt->maskapai_id,
											'maskapai' => strtoupper($dt->maskapai),
										]);
				// insert data penumpang
				foreach($dt->penumpang->penumpang as $pg){
					\DB::table('invoice_tiket_data_penumpang')->insert([
							'user_id' => \Auth::user()->id,
							'invoice_tiket_data_pemesanan_id' => $data_pemesanan_id,
							'titel' => $pg->titel,
							'nama' => strtoupper($pg->nama),
							'nomor_tiket' => strtoupper($pg->no_tiket),

						]);
				}
			}

			return redirect('invoice/tiket');
		});

		// END OF UPDATE FUNCTION
	}

	public function delete(Request $req){
		$dataid = json_decode($req->dataid);
		foreach($dataid as $dt){
			\DB::table('invoice_tiket')->delete($dt->id);
		}

		return redirect('invoice/tiket');
	}

	public function cetakTiket($invoice_id){
		$data_invoice = \DB::table('invoice_tiket')->find($invoice_id);
		$data_pemesanan = \DB::table('invoice_tiket_data_pemesanan')
							->where('invoice_tiket_id',$invoice_id)
							->get();
		// $data_penumpang = \DB::table('invoice_tiket_data_penumpang')
		// 					->where('invoic_data',$invoice_id)
		// 					->get();


		\Fpdf::AddPage();
		\Fpdf::setMargins(0,0,0);
	    
		// generate header

	    \Fpdf::SetFont('Arial', null, 10);
	    \Fpdf::Cell(50, 0,null,0,0,'L',false );
	    \Fpdf::Cell(50, 0,'Telepon',0,0,'L',false );
	    \Fpdf::Cell(50, 0,'E-Mail',0,0,'L',false );
	    \Fpdf::Cell(50, 0,'Alamat',0,0,'L',false );
	    \Fpdf::Ln();
	    \Fpdf::Ln();
	    \Fpdf::SetFont('Arial', null, 8);
	    \Fpdf::Cell(50, 0,null,0,0,'L',false );
	    \Fpdf::Cell(50, 0,'081-357-359-019',0,0,'L',false );
	    \Fpdf::Cell(50, 0,'butirpadi@outlook.com',0,0,'L',false );
	    \Fpdf::Cell(50, 0,'Ngaban RT 5 RW 2 Tanggulangin',0,0,'L',false );

	    // \Fpdf::image('img/logo-aksara.png',5,5,50);
					    

	    \Fpdf::Output('I','test.pdf',false);
	    exit;
	}

	

}
