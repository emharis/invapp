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
		$maxlen_kode_pemesaan = \DB::table('appsetting')->whereName('inv_maxlen_kode_pemesanan')->first()->value;
		$maxlen_maskapai = \DB::table('appsetting')->whereName('inv_maxlen_maskapai')->first()->value;
		$maxlen_rute = \DB::table('appsetting')->whereName('inv_maxlen_rute')->first()->value;
		$maxlen_nama_penumpang = \DB::table('appsetting')->whereName('inv_maxlen_penumpang')->first()->value;
		$maxlen_nomor_tiket = \DB::table('appsetting')->whereName('inv_maxlen_nomor_tiket')->first()->value;
		$maxlen_data_kustomer = \DB::table('appsetting')->whereName('inv_maxlen_data_kustomer')->first()->value;

		return view('invoice.tiket.create',[
				'maxlen_kode_pemesaan' => $maxlen_kode_pemesaan,
				'maxlen_maskapai' => $maxlen_maskapai,
				'maxlen_rute' => $maxlen_rute,
				'maxlen_nama_penumpang' => $maxlen_nama_penumpang,
				'maxlen_nomor_tiket' => $maxlen_nomor_tiket,
				'maxlen_data_kustomer' => $maxlen_data_kustomer,
			]);
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
											'pergi' => strtoupper($dt->pergi),
											'pulang' => strtoupper($dt->pulang),
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

			if($req->is_cetak){
				return $inv_id;
			}else{
				return redirect('invoice/tiket');	
			}
			
		});
	}

	// edit data tiket
	public function edit($tiket_id){
		$maxlen_kode_pemesaan = \DB::table('appsetting')->whereName('inv_maxlen_kode_pemesanan')->first()->value;
		$maxlen_maskapai = \DB::table('appsetting')->whereName('inv_maxlen_maskapai')->first()->value;
		$maxlen_rute = \DB::table('appsetting')->whereName('inv_maxlen_rute')->first()->value;
		$maxlen_nama_penumpang = \DB::table('appsetting')->whereName('inv_maxlen_penumpang')->first()->value;
		$maxlen_nomor_tiket = \DB::table('appsetting')->whereName('inv_maxlen_nomor_tiket')->first()->value;
		$maxlen_data_kustomer = \DB::table('appsetting')->whereName('inv_maxlen_data_kustomer')->first()->value;

		$inv_master = \DB::table('invoice_tiket')
						->select('invoice_tiket.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
						->find($tiket_id);
		$inv_master->data_pemesanan = \DB::table('invoice_tiket_data_pemesanan')
										->where('invoice_tiket_id',$tiket_id)
										->get();

		foreach($inv_master->data_pemesanan as $dt){
			$dt->data_penumpang = \DB::table('invoice_tiket_data_penumpang')
									->where('invoice_tiket_data_pemesanan_id',$dt->id)
									->get();
		}

		// echo var_dump($inv_master);

		return view('invoice.tiket.edit',[
				'data'=>$inv_master,
				'maxlen_kode_pemesaan' => $maxlen_kode_pemesaan,
				'maxlen_maskapai' => $maxlen_maskapai,
				'maxlen_rute' => $maxlen_rute,
				'maxlen_nama_penumpang' => $maxlen_nama_penumpang,
				'maxlen_nomor_tiket' => $maxlen_nomor_tiket,
				'maxlen_data_kustomer' => $maxlen_data_kustomer,
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
											'pergi' => strtoupper($dt->pergi),
											'pulang' => strtoupper($dt->pulang),
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


public function cetakKwitansi($invoice_id){
		$data_invoice = \DB::table('invoice_tiket')
						->select('invoice_tiket.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
						->find($invoice_id);
		$data_pemesanan = \DB::table('invoice_tiket_data_pemesanan')
							->where('invoice_tiket_id',$invoice_id)
							->get();
		foreach($data_pemesanan as $dps){
			$dps->data_penumpang = \DB::table('invoice_tiket_data_penumpang')
									->where('invoice_tiket_data_pemesanan_id',$dps->id)
									->get();
		}

		$company_name = \DB::table('appsetting')->whereName('nama_perusahaan')->first()->value;	    
		$alamat = \DB::table('appsetting')->whereName('alamat')->first()->value;	    
		$alamat_2 = \DB::table('appsetting')->whereName('alamat_2')->first()->value;	    
		$kecamatan = \DB::table('appsetting')->whereName('kecamatan')->first()->value;	    
		$kabupaten = \DB::table('appsetting')->whereName('kabupaten')->first()->value;	    
		$kodepos = \DB::table('appsetting')->whereName('kodepos')->first()->value;	    
		$telp = \DB::table('appsetting')->whereName('telp')->first()->value;	    
		$email = \DB::table('appsetting')->whereName('email')->first()->value;	    
		$fax = \DB::table('appsetting')->whereName('fax')->first()->value;	    
		$website = \DB::table('appsetting')->whereName('website')->first()->value;	    

		$pdfKw = new \Codedge\Fpdf\Fpdf\FPDF('L','mm',array(210,99));
		$pdfKw->AddPage();
		$pdfKw->SetMargins(0,0,0);
		$pdfKw->SetAutoPageBreak(true,0);

		$pdfKw->SetXY(8,8);
		// // image logo
		// $pdfKw->image('img/' . \DB::table('appsetting')->whereName('logo')->first()->value,8,9,45);	    
	 //    $pdfKw->SetX(55);
		// $pdfKw->SetFont('Arial', 'B', 8);
	 //    $pdfKw->Cell(50, 4,$company_name,0,2,'L',false );
	 //    $y = $pdfKw->GetY();
	 //    $pdfKw->SetFont('Arial', null, 8);
	 //    $pdfKw->SetTextColor(0,0,0);
	 //    $pdfKw->Cell(50, 4,$alamat,0,2,'L',false );
	 //    $x = 0;
	 //    $pdfKw->Cell(50, 4,$alamat_2 ,0,2,'L',false );
	 //    $pdfKw->Cell(50, 4,'T. ' . $telp .' | ' . 'E. ' . $email ,0,2,'L',false );


	 //    $y_for_line_under_header = $pdfKw->GetY()-3;

	 //    // KWITANSI TITEL
	 //    $pdfKw->SetTextColor(4,82,127);
	 //    $pdfKw->SetFont('Arial', 'B', 25);
	 //    $pdfKw->SetXY(10,$y);
	 //    $pdfKw->Cell($pdfKw->GetPageWidth()-15,10,'KWITANSI',0,2,'R',false );

	 //    // LINE
	 //    $pdfKw->SetXY(8,$y_for_line_under_header+5);
	 //    $pdfKw->SetDrawColor(82,82,86);
	 //    $pdfKw->Cell(195,1,null,'B',2,'L',false);
	 //    // $pdfKw->Cell(0,1,null,'B',2,'L',false);

		GeneratePdfHeader($pdfKw,'kw');

	    // CONTENT
		
		$pdfKw->Ln(3);

		$pdfKw->SetX(10);
		$pdfKw->SetFont('Courier', 'B', 10);
	    $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->Cell(50,5,'SUDAH TERIMA DARI',0,0,'L',false);
	    $pdfKw->Cell(4,5,':',0,0,'L',false);
	    $pdfKw->SetFont('Courier', null, 10);
	    $x = $pdfKw->GetX();
	    $y = $pdfKw->GetY();
	    $pdfKw->Cell(0,5,$data_invoice->nama,0,2,'L',false);
	    // titik titik
	    $pdfKw->SetXY($x,$y+1);
	    $pdfKw->Cell(0,5,'................................................................',0,2,'L',false);

	    $pdfKw->Ln(2);

	    $pdfKw->SetX(10);
		$pdfKw->SetFont('Courier', 'B', 10);
	    $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->Cell(50,5,'BANYAKNYA UANG',0,0,'L',false);
	    $pdfKw->Cell(4,5,':',0,0,'L',false);
	    $pdfKw->SetFont('Courier', null, 10);
	    $terbilang = strtoupper($data_invoice->terbilang . ' Rupiah');

	    // if(strlen($terbilang) > 65){
	    	$x = $pdfKw->GetX();
	    	$y = $pdfKw->GetY();
	    	$pdfKw->MultiAlignCell(140,5,$terbilang,0,2,'L',false);
	    	$x_ed = $pdfKw->GetX();
	    	$y_ed = $pdfKw->GetY();

	    	$pdfKw->SetXY($x,$y+1);
	    	$pdfKw->Cell(0,5,'................................................................',0,2,'L',false);
	    	$x = $pdfKw->GetX();
	    	$y = $pdfKw->GetY();
	    	$pdfKw->SetXY($x,$y);
	    	$pdfKw->Cell(0,5,'................................................................',0,2,'L',false);

	    // }else{
	    // 	$x = $pdfKw->GetX();
	    // 	$y = $pdfKw->GetY();
	    // 	$pdfKw->Cell(140,5,$terbilang,0,2,'L',false);
	    // 	$pdfKw->SetXY($x,$y+1);
	    // 	$pdfKw->Cell(0,5,'................................................................',0,2,'L',false);
	    // }

	    $pdfKw->Ln(2);

	    $pdfKw->SetX(10);
	    $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->SetFont('Courier', 'B', 10);
	    $pdfKw->Cell(50,5,'UNTUK PEMBAYARAN',0,0,'L',false);
	    $pdfKw->Cell(4,5,':',0,0,'L',false);
	    $pdfKw->SetFont('Courier', null, 10);
	    $x = $pdfKw->GetX();
	    $y = $pdfKw->GetY();
	    $pdfKw->MultiAlignCell(145,5,'INVOICE NOMOR ' . $data_invoice->inv_num,0,2,'L',false);
	    $pdfKw->SetXY($x,$y+1);
	    $pdfKw->Cell(0,5,'................................................................',0,2,'L',false);
	    $y = $pdfKw->GetY();

	    $pdfKw->Ln(2);

	    // LINE
	    $pdfKw->SetX(8);
	    $pdfKw->SetDrawColor(82,82,86);
	    $pdfKw->Cell(195,1,null,'B',2,'L',false);

	    // TOTAL
	    $pdfKw->SetTextColor(255,255,255);
	    // $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->SetFillColor(4,82,127);
	    $pdfKw->SetFont('Arial', 'B', 12);
	    $pdfKw->Ln(3);
	    $x_catatan = $pdfKw->GetX();
	    $y_catatan = $pdfKw->GetY();
	    $pdfKw->SetX(11);
	    // $pdfKw->Cell(115,8,null,0,0,'C',false);
	    $pdfKw->Cell(42,6,'Rp. ' . number_format($data_invoice->total,2,',','.'),0,0,'C',true);
	    // ----- TOTAL -----------


	    $pdfKw->Ln(10);
	    // $pdfKw->SetX(10);
	    $pdfKw->SetTextColor(0,0,0);
	    // CATATAN
		$catatan_1 = \DB::table('appsetting')->whereName('inv_catatan_1')->first()->value;
	    $catatan_2 = \DB::table('appsetting')->whereName('inv_catatan_2')->first()->value;
	    $catatan_3 = \DB::table('appsetting')->whereName('inv_catatan_3')->first()->value;
	    $catatan_4 = \DB::table('appsetting')->whereName('inv_catatan_4')->first()->value;
	    $catatan_5 = \DB::table('appsetting')->whereName('inv_catatan_5')->first()->value;
	    $catatan_6 = \DB::table('appsetting')->whereName('inv_catatan_6')->first()->value;
	    $catatan_7 = \DB::table('appsetting')->whereName('inv_catatan_7')->first()->value;

	    $col_height_catatan = 2.5;
	    $col_width = $pdfKw->GetPageWidth()/2;
	    		// $y = $pdfKw->GetY();
	    		// $pdfKw->SetX(8);
	    		// $pdfKw->SetFont('Arial', null, 8);
	    		// $pdfKw->Cell($col_width,$col_height_catatan,null,0,0,'L',false);	    		
	    		// $pdfKw->Cell(91,$col_height_catatan,\DB::table('appsetting')->whereName('kwitansi_kota')->first()->value . ', ' .$data_invoice->tgl_cetak_formatted,0,2,'R',false);
	    

	    $pdfKw->SetFont('Arial', 'BU', 6);
	    $pdfKw->SetX(8);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_1,0,2,'L',false);	    		
	    $pdfKw->SetFont('Arial', null, 6);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_2,0,2,'L',false); 
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_3,0,2,'L',false);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_4,0,2,'L',false);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_5,0,2,'L',false);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_6,0,2,'L',false);
	    		// $pdfKw->SetFont('Arial', null, 8);
	    		// $pdfKw->Cell(91,$col_height_catatan,\DB::table('users')->find($data_invoice->user_id)->name,0,2,'R',false);
	    $pdfKw->SetX(8);
	    $pdfKw->SetFont('Arial', null, 6);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_7,0,0,'L',false);
	    		// $pdfKw->SetFont('Arial', 'B', 8);
	    		// $pdfKw->Cell(91,$col_height_catatan,$company_name,0,2,'R',false);

	    $pdfKw->SetXY($col_width,$y_catatan + 2);
	    $pdfKw->SetFont('Arial', null, 8);
		// $pdfKw->Cell($col_width,$col_height_catatan,null,0,0,'L',false);	    		
		$pdfKw->Cell($col_width-6,$col_height_catatan,\DB::table('appsetting')->whereName('kwitansi_kota')->first()->value . ', ' .FormatTanggal($data_invoice->tgl_cetak_formatted),0,2,'R',false);

		$pdfKw->Ln(18);

		$pdfKw->SetX($col_width);
		$pdfKw->SetFont('Arial', 'B', 8);
		$pdfKw->Cell($col_width-6,$col_height_catatan,\DB::table('users')->find($data_invoice->user_id)->name,0,2,'R',false);
		$pdfKw->SetFont('Arial', null, 8);
		$pdfKw->Cell($col_width-6,$col_height_catatan,$company_name,0,2,'R',false);


	    
	    // $pdfKw->Output('I',$data_invoice->inv_num .'_'.date('dmYHis') .'.pdf',false);
	    $pdfKw->Output('I',$data_invoice->inv_num  .'.pdf',false);
	    exit;
	}


public function cetakInvoice($invoice_id){
		$data_invoice = \DB::table('invoice_tiket')
						->select('invoice_tiket.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
						->find($invoice_id);
		$data_pemesanan = \DB::table('invoice_tiket_data_pemesanan')
							->where('invoice_tiket_id',$invoice_id)
							->get();
		foreach($data_pemesanan as $dps){
			$dps->data_penumpang = \DB::table('invoice_tiket_data_penumpang')
									->where('invoice_tiket_data_pemesanan_id',$dps->id)
									->get();
		}

		$company_name = \DB::table('appsetting')->whereName('nama_perusahaan')->first()->value;	    
		$alamat = \DB::table('appsetting')->whereName('alamat')->first()->value;	    
		$alamat_2 = \DB::table('appsetting')->whereName('alamat_2')->first()->value;	    
		$kecamatan = \DB::table('appsetting')->whereName('kecamatan')->first()->value;	    
		$kabupaten = \DB::table('appsetting')->whereName('kabupaten')->first()->value;	    
		$kodepos = \DB::table('appsetting')->whereName('kodepos')->first()->value;	    
		$telp = \DB::table('appsetting')->whereName('telp')->first()->value;	    
		$email = \DB::table('appsetting')->whereName('email')->first()->value;	    
		$fax = \DB::table('appsetting')->whereName('fax')->first()->value;	    
		$website = \DB::table('appsetting')->whereName('website')->first()->value;	    

		// $pdfInv = new \Codedge\Fpdf\Fpdf\FPDF('L','mm',array(210,99));
		$pdfInv = new \Codedge\Fpdf\Fpdf\FPDF();
		$pdfInv->AddPage();
		$pdfInv->setMargins(0,0,0);
		$pdfInv->SetAutoPageBreak(true,0);

		// // image logo
		// $pdfInv->image('img/' . \DB::table('appsetting')->whereName('logo')->first()->value,10,10,50);
	    
		// // ------- header invoice -----------
	 //    $pdfInv->SetFont('Arial', 'B', 8);
	 //    $pdfInv->Cell(60, 4,null,0,0,'L',false );
	 //    $pdfInv->Cell(50, 4,$company_name,0,2,'L',false );
	 //    $pdfInv->SetFont('Arial', null, 8);
	 //    $pdfInv->SetTextColor(0,0,0);
	 //    $y = $pdfInv->GetY();
	 //    $pdfInv->Cell(50, 4,$alamat,0,2,'L',false );
	 //    $x = 0;
	 //    $pdfInv->Cell(50, 4,$alamat_2 ,0,2,'L',false );
	 //    $pdfInv->Cell(50, 4,'T. ' . $telp .' | ' . 'E. ' . $email ,0,2,'L',false );


	 //    // INVOICE TITEL
	 //    $pdfInv->SetXY(165,$y);
	 //    $pdfInv->SetTextColor(4,82,127);
	 //    $pdfInv->SetFont('Arial', 'B', 25);
	 //    // $pdfInv->Cell(110, 15,null,0,0,'L',false );
	 //    $pdfInv->Cell(130,8,'INVOICE',0,0,'L',false );
	    
	 //    // ------ end header invoice ------------


		// ------- HEADER INVOICE ----------------
	    $pdfInv->SetXY(8,8);
		
		// // image logo
		// $pdfInv->image('img/' . \DB::table('appsetting')->whereName('logo')->first()->value,8,9,45);    
	 //    $pdfInv->SetX(55);
		// $pdfInv->SetFont('Arial', 'B', 8);
	 //    $pdfInv->Cell(50, 4,$company_name,0,2,'L',false );
	 //    $y = $pdfInv->GetY();
	 //    $pdfInv->SetFont('Arial', null, 8);
	 //    $pdfInv->SetTextColor(0,0,0);
	 //    $pdfInv->Cell(50, 4,$alamat,0,2,'L',false );
	 //    $x = 0;
	 //    $pdfInv->Cell(50, 4,$alamat_2 ,0,2,'L',false );
	 //    $pdfInv->Cell(50, 4,'T. ' . $telp .' | ' . 'E. ' . $email ,0,2,'L',false );
	 //    $y_for_line_under_header = $pdfInv->GetY();
	    
	 //    // INVOICE TITEL
	 //    $pdfInv->SetTextColor(4,82,127);
	 //    $pdfInv->SetFont('Arial', 'B', 25);
	 //    // $pdfInv->SetXY(0,$y);
	 //    // $pdfInv->Cell(0,10,'INVOICE     ',0,2,'R',false );
	 //    $pdfInv->SetXY(7,$y);
	 //    $pdfInv->Cell($pdfInv->GetPageWidth()-14,10,'INVOICE',0,2,'R',false );
	    GeneratePdfHeader($pdfInv,'inv');
	    // ---------- END HEADER INVOICE ---------------


	    // -------- DICETAK OLEH DAN UNTUK ---------------

	    $pdfInv->Ln(10);
	    $pdfInv->SetX(7);
	    // INVOICE DI BUAT OLEH
	    $pdfInv->SetTextColor(0,0,0);
	    $pdfInv->SetFont('Arial', 'B', 8);
	    // $pdfInv->Cell(10, 4,null,0,0,'L',false );
	    
    	$y = $pdfInv->GetY();
    	$pdfInv->SetTextColor(4,82,127);
    	$pdfInv->SetFont('Arial', 'B', 22);
	    $pdfInv->Cell(25, 8,$data_invoice->inv_num,0,2,'L',false );

	    $pdfInv->SetX(7);
	    $pdfInv->SetFont('Arial', 'B', 8);
	    $pdfInv->SetTextColor(0,0,0);
	    $pdfInv->Cell(30, 4,'Dicetak oleh',0,0,'L',false );
	    $pdfInv->Cell(2, 4,':',0,2,'L',false );
	    // $pdfInv->Ln();

	    $pdfInv->SetX(7);
	    $pdfInv->Cell(30, 4,'Tanggal Cetak',0,0,'L',false );
	    $pdfInv->Cell(2, 4,':',0,2,'L',false );
	    // $pdfInv->Ln();

	    $pdfInv->SetX(7);
	    $pdfInv->Cell(30, 4,'Tanggal Jatuh Tempo',0,0,'L',false );
	    $pdfInv->Cell(2, 4,':',0,0,'L',false );
	    $x = $pdfInv->GetX();

	    $pdfInv->SetXY($x,$y);
	    $pdfInv->SetTextColor(4,82,127);
	    $pdfInv->Cell(60, 4,'',0,2,'L',false );
	    $pdfInv->Ln();
	    $pdfInv->SetX($x);
	    $pdfInv->SetFont('Arial', null, 8);
	    $pdfInv->SetTextColor(0,0,0);
	    $pdfInv->Cell(60, 4,\DB::table('users')->find($data_invoice->user_id)->name,0,2,'L',false );
	    $pdfInv->Cell(60, 4,FormatTanggal($data_invoice->tgl_cetak_formatted),0,2,'L',false );
	    $pdfInv->Cell(60, 4,FormatTanggal($data_invoice->jatuh_tempo_formatted),0,2,'L',false );
	    $x = $pdfInv->GetX();

	    // invoice untuk
	    $pdfInv->SetXY($x+45,$y);
	    $pdfInv->SetFont('Arial', 'B', 8);
	    $pdfInv->Cell(30, 4,'Nama',0,0,'L',false );
	    $pdfInv->Cell(2, 4,':',0,2,'L',false );
	    $pdfInv->SetX($x+45);
	    $pdfInv->Cell(30, 4,'Kantor/Perusahaan',0,0,'L',false );
	    $pdfInv->Cell(2, 4,':',0,2,'L',false );
	    $pdfInv->SetX($x+45);
	    $pdfInv->Cell(30, 4,'Alamat',0,0,'L',false );
	    $pdfInv->Cell(2, 4,':',0,2,'L',false );
	    $pdfInv->SetX($x+45);
	    $pdfInv->Cell(30, 4,'Telepon',0,0,'L',false );
	    $pdfInv->Cell(2, 4,':',0,2,'L',false );
	    $pdfInv->SetX($x+45);
	    $pdfInv->Cell(30, 4,'E-Mail',0,0,'L',false );
	    $pdfInv->Cell(2, 4,':',0,2,'L',false );
	    $x = $pdfInv->GetX();

	    $pdfInv->SetXY($x+2,$y);
	    $pdfInv->SetFont('Arial', null, 8);
	    $pdfInv->Cell(30, 4,$data_invoice->nama,0,2,'L',false );
	    $pdfInv->Cell(30, 4,$data_invoice->kantor,0,2,'L',false );
	    $pdfInv->Cell(30, 4,$data_invoice->alamat,0,2,'L',false );
	    $pdfInv->Cell(30, 4,$data_invoice->telp,0,2,'L',false );
	    $pdfInv->Cell(30, 4,$data_invoice->email,0,2,'L',false );
	    $x = $pdfInv->GetX();

	    // ---------- END DICETAK OLEH DAN UNTUK ----------------


	    // TABLE HEADER
	    $width_no = \DB::table('appsetting')->whereName('inv_width_no')->first()->value;
	    $width_separator = \DB::table('appsetting')->whereName('inv_widht_header_separator')->first()->value;
	    $width_kode_pemesanan = \DB::table('appsetting')->whereName('inv_width_kode_pemesanan')->first()->value;
	    $width_maskapai = \DB::table('appsetting')->whereName('inv_width_maskapai')->first()->value;
	    $width_rute = \DB::table('appsetting')->whereName('inv_width_rute')->first()->value;
	    $width_titel = \DB::table('appsetting')->whereName('inv_width_titel')->first()->value;
	    $width_nama = \DB::table('appsetting')->whereName('inv_width_nama')->first()->value;
	    $width_nomor_tiket = \DB::table('appsetting')->whereName('inv_width_nomor_tiket')->first()->value;
	    $width_harga = \DB::table('appsetting')->whereName('inv_width_harga')->first()->value;
	    $col_height = \DB::table('appsetting')->whereName('inv_height_of_row')->first()->value;
	    $col_height_other = 9;
	    

	    $pdfInv->Ln(5);
	    $pdfInv->SetX(8);
	    $pdfInv->SetFont('Arial', 'B', 7);
	    // $pdfInv->Cell(10, 12,null,0,0,'L',false );
		$pdfInv->SetFillColor(0,0,0);
		$pdfInv->SetTextColor(255,255,255);
	    $pdfInv->Cell($width_no, $col_height_other,'NO',0,0,'C',true );
	    // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height*2,null,0,0,'C',true );
	    $pdfInv->SetFillColor(4,82,127);
	    // --- end separator ---
	    
	    $y = $pdfInv->GetY();
	    $x = $pdfInv->GetX();
	    $pdfInv->MultiAlignCell($width_kode_pemesanan, $col_height*2,null,0,0,'C',true );
	    $pdfInv->SetXY($x,$y+2);
	    $pdfInv->MultiAlignCell($width_kode_pemesanan, $col_height-2,'KODE PEMESANAN',0,0,'C',true );
	    $pdfInv->SetXY($pdfInv->GetX(),$y);

	    // $pdfInv->MultiAlignCell($width_kode_pemesanan, $col_height,'KODE PEMESANAN',0,0,'C',true );
	     // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height*2,null,0,0,'C',true );
	    $pdfInv->SetFillColor(4,82,127);
	    // --- end separator ---
	    $pdfInv->Cell($width_maskapai, $col_height*2,'MASKAPAI',0,0,'C',true );
	     // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height*2,null,0,0,'C',true );
	    $pdfInv->SetFillColor(4,82,127);
	    // --- end separator ---
	    $pdfInv->Cell($width_rute, $col_height*2,'RUTE',0,0,'C',true );
	     // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height_other,null,0,0,'C',true );
	    $pdfInv->SetFillColor(0,0,0);
	    // --- end separator ---
	    // $pdfInv->Cell($width_titel, $col_height_other,'TITEL',0,0,'C',true );
	     // --- separator ---
	    // $pdfInv->SetFillColor(255,255,255);
	    // $pdfInv->Cell($width_separator, $col_height_other,null,0,0,'C',true );
	    // $pdfInv->SetFillColor(0,0,0);
	    // --- end separator ---
	    $pdfInv->Cell($width_nama + $width_titel + 1, $col_height_other,'NAMA PENUMPANG',0,0,'C',true );
	     // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height_other,null,0,0,'C',true );
	    $pdfInv->SetFillColor(0,0,0);
	    // --- end separator ---
	    $pdfInv->Cell($width_nomor_tiket, $col_height_other,'NOMOR TIKET',0,0,'C',true );
	     // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height_other,null,0,0,'C',true );
	    $pdfInv->SetFillColor(0,0,0);
	    // --- end separator ---
	    $pdfInv->Cell($width_harga, $col_height_other,'HARGA',0,2,'C',true );
	    // separator warna putih di bawah kolom terakhir
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell(0, 1,null,0,0,'C',true );
	    
	    // LINE DI BAWAH TABLE HEADER
	    $pdfInv->Ln();
	    $pdfInv->SetX(8);
	    $pdfInv->SetFillColor(4,82,127);
	    $pdfInv->Cell(194, 1,null,0,0,'C',true );

	    // TABLE CONTENT
	    $pdfInv->SetFont('Arial', null, 7);
	    $table_row_height = 10;
	    $rownum=1;
	    $pdfInv->Ln();
	    $pdfInv->SetTextColor(0,0,0);

	    foreach($data_pemesanan as $dps){
	    	$new_table_row_height = $table_row_height * count($dps->data_penumpang);
	    	if($rownum== 1){
	    		$pdfInv->Cell(10, 12,null,0,0,'L',false );
	    	}

	    	$pdfInv->SetX(8);
		    $pdfInv->Cell($width_no, $new_table_row_height,$rownum++,0,0,'C',false );
		    $pdfInv->Cell($width_separator, $new_table_row_height,null,0,0,'C',false );

		    if(strlen($dps->kode_pemesanan) > 16){
			    $y = $pdfInv->GetY();
			    $x = $pdfInv->GetX();
			    $pdfInv->SetXY($x,$y + 2);
			    $pdfInv->MultiAlignCell($width_kode_pemesanan,$new_table_row_height/2-2,$dps->kode_pemesanan,0,0,'C',false );
			    $x = $pdfInv->GetX();
			    $y = $pdfInv->GetY();
			    $pdfInv->SetXY($x,$y - 2);
			}else{
			    $pdfInv->Cell($width_kode_pemesanan,$new_table_row_height,$dps->kode_pemesanan,0,0,'C',false );
			}

		    
		    $pdfInv->Cell($width_separator, $new_table_row_height,null,0,0,'C',false );

		    $maxlen_maskapai = \DB::table('appsetting')->whereName('inv_maxlen_maskapai')->first()->value;
		    if(strlen($dps->maskapai) > $maxlen_maskapai){
			    $y = $pdfInv->GetY();
			    $x = $pdfInv->GetX();
			    $pdfInv->SetXY($x,$y + 2);
			    $pdfInv->MultiAlignCell($width_maskapai, $new_table_row_height/2-2,$dps->maskapai,0,0,'C',false );
			    $x = $pdfInv->GetX();
			    $y = $pdfInv->GetY();
			    $pdfInv->SetXY($x,$y - 2);
			}else{
			    $pdfInv->Cell($width_maskapai, $new_table_row_height,$dps->maskapai,0,0,'C',false );
			}

		    
		    $pdfInv->Cell($width_separator, $new_table_row_height,null,0,0,'C',false );


		    $maxlen_rute  = $maxlen_maskapai = \DB::table('appsetting')->whereName('inv_maxlen_rute')->first()->value;
		    $rute = $dps->pergi . ($dps->pulang != "" ? ' - ' . $dps->pulang : '');
		    if(strlen($rute) > $maxlen_rute){
			    $y = $pdfInv->GetY();
			    $x = $pdfInv->GetX();
			    $pdfInv->SetXY($x,$y + 2);
			    $pdfInv->MultiAlignCell($width_rute, $new_table_row_height/2-2,$rute,0,0,'C',false );
			    $x = $pdfInv->GetX();
			    $y = $pdfInv->GetY();
			    $pdfInv->SetXY($x,$y - 2);
			}else{
			    $pdfInv->Cell($width_rute, $new_table_row_height,$rute,0,0,'C',false );
			}
		    
		    $pdfInv->Cell($width_separator, $new_table_row_height,null,0,0,'C',false );
		    // data penumpan
		    $dpg_idx =1;
		    foreach($dps->data_penumpang as $dpg){
		    	// titel

		    	if($dpg_idx > 1){
		    		$pdfInv->Ln($table_row_height);
		    		// wrapper
		    		$pdfInv->Cell(10, $table_row_height,null,0,0,'L',false );
			    	$pdfInv->Cell($width_no, $table_row_height,null,0,0,'C',false );
			    	$pdfInv->Cell($width_kode_pemesanan, $table_row_height,null,0,0,'C',false );
			    	$pdfInv->Cell($width_maskapai, $table_row_height,null,0,0,'C',false );
			    	$pdfInv->Cell($width_rute, $table_row_height,null,0,0,'C',false );
			    	$pdfInv->Cell(4, $table_row_height,null,0,0,'C',false );
		    	}

		    	// $pdfInv->Cell($width_titel, $table_row_height,strtoupper($dpg->titel),0,0,'C',false );
		    	// $pdfInv->Cell($width_separator, $table_row_height,null,0,0,'C',false );
		    	// nama penumpang
		    	$maxlen_nama_penumpang = \DB::table('appsetting')->whereName('inv_maxlen_penumpang')->first()->value;
		    	$nama = strtoupper($dpg->titel) . ' ' . $dpg->nama;
		    	if(strlen($dpg->nama) > $maxlen_nama_penumpang){
		    		$y = $pdfInv->GetY();
				    $x = $pdfInv->GetX();
				    $pdfInv->SetXY($x,$y + 2);
				    $pdfInv->MultiAlignCell($width_nama+$width_titel + 1, $table_row_height/2-2,nama,0,0,'L',false );
			    	$x = $pdfInv->GetX();
				    $y = $pdfInv->GetY();
				    $pdfInv->SetXY($x,$y - 2);
		    	}else{
		    		$pdfInv->Cell($width_nama+$width_titel + 1, $table_row_height,$nama,0,0,'L',false );
		    	}


		    	$pdfInv->Cell($width_separator, $table_row_height,null,0,0,'C',false );
		    	// nomor tiket
		    	$maxlen_nomor_tiket = \DB::table('appsetting')->whereName('inv_maxlen_nomor_tiket')->first()->value;
		    	 if(strlen($dpg->nomor_tiket) > $maxlen_nomor_tiket){
				    $y = $pdfInv->GetY();
				    $x = $pdfInv->GetX();
				    $pdfInv->SetXY($x,$y + 2);
				    $pdfInv->MultiAlignCell($width_nomor_tiket, $table_row_height/2-2,$dpg->nomor_tiket,0,0,'C',false );
				    $x = $pdfInv->GetX();
				    $y = $pdfInv->GetY();
				    $pdfInv->SetXY($x,$y - 2);
				}else{
				    $pdfInv->Cell($width_nomor_tiket, $table_row_height,$dpg->nomor_tiket,0,0,'C',false );
				}

		    	
		    	$pdfInv->Cell($width_separator, $table_row_height,null,0,0,'C',false );
		    	
		    	if($dpg_idx == 1){
		    		// cetak kolom harga
		    		$pdfInv->Cell(2, $new_table_row_height,'Rp.',0,0,'L',false );
		    		$pdfInv->Cell($width_harga-2, $new_table_row_height,number_format($dps->harga,2,',','.'),0,0,'R',false );
		    	}
		    	
		    	$dpg_idx++;
		    			    	
		    }

		    // line dibawah setiap row
		    $pdfInv->Ln();
		    $pdfInv->SetX(8);
		    $full_row_width = $width_no+$width_kode_pemesanan+$width_maskapai+$width_rute+$width_titel+$width_nama+$width_nomor_tiket+$width_harga+7;
		    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
		    $pdfInv->Cell($full_row_width, 0,null,'B',2,'C',false );
		    
	    }

	    // TOTAL
	    $total_height = 10;
	    // $pdfInv->Cell($width_separator, $total_height,null,0,2,'C',false );
	    // $pdfInv->Cell($width_separator, $table_row_height,null,0,2,'C',false );
	    $pdfInv->Ln(5);
	    $pdfInv->SetX(8);
	    // $pdfInv->Cell($width_separator, $total_height,null,0,0,'C',false );
	    $pdfInv->Cell($width_no + $width_kode_pemesanan + $width_maskapai + $width_rute + ($width_separator*4), $total_height,null,0,0,'C',false );
	    $pdfInv->SetFont('Arial', 'B', 12);	    
	    $pdfInv->SetFillColor(4,82,127);
	    $pdfInv->SetTextColor(255,255,255);
	    $pdfInv->Cell($width_nama + $width_titel +1 , $total_height,'TOTAL',0,0,'C',true );
	    $pdfInv->Cell($width_nomor_tiket + $width_harga +2, $total_height ,'Rp. ' . number_format($data_invoice->total,2,',','.'),0,0,'C',true );

	    // terbilang
	    $pdfInv->Ln();
	    $pdfInv->Ln(5);
	    $pdfInv->SetX(8);
	    $pdfInv->SetFont('Arial', 'B', 8);
	    $pdfInv->SetTextColor(255,255,255);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $terbilang =  strtoupper($data_invoice->terbilang . ' Rupiah');
	    $pdfInv->SetFillColor(0,0,0);
	    $pdfInv->Cell($full_row_width, 5,'   '.$terbilang,0,0,'L',true );


	    $pdfInv->Ln(8);
	    $y_for_decetak_oleh = $pdfInv->GetY();
	    $pdfInv->SetFont('Arial', null, 6);
	    $pdfInv->SetTextColor(0,0,0);
	    $pdfInv->Ln($table_row_height);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $catatan_1 = \DB::table('appsetting')->whereName('inv_catatan_1')->first()->value;
	    $catatan_2 = \DB::table('appsetting')->whereName('inv_catatan_2')->first()->value;
	    $catatan_3 = \DB::table('appsetting')->whereName('inv_catatan_3')->first()->value;
	    $catatan_4 = \DB::table('appsetting')->whereName('inv_catatan_4')->first()->value;
	    $catatan_5 = \DB::table('appsetting')->whereName('inv_catatan_5')->first()->value;
	    $catatan_6 = \DB::table('appsetting')->whereName('inv_catatan_6')->first()->value;
	    $catatan_7 = \DB::table('appsetting')->whereName('inv_catatan_7')->first()->value;

	    $pdfInv->SetXY(7,$y_for_decetak_oleh+5);
	    $pdfInv->SetFont('Arial', 'BU', 6);
	    $pdfInv->MultiAlignCell($width_no + $width_kode_pemesanan + $width_maskapai + $width_rute + $width_titel + $width_nama + 5, $table_row_height,$catatan_1,0,0,'L',false );

		    // tanda tangan baris ke 1
		    $pdfInv->SetFont('Arial', null, 8);
		    $pdfInv->SetTextColor(0,0,0);
		    $x = $pdfInv->GetX();
		    $pdfInv->SetXY($x,$y_for_decetak_oleh);
			// $pdfInv->Cell($width_nama + 1, $table_row_height,null,0,0,'L',false );	  
			$pdfInv->SetX($pdfInv->GetPageWidth()/2);    
			$pdfInv->Cell($pdfInv->GetPageWidth()/2-7, $table_row_height,'Dicetak oleh,',0,0,'R',false );		    
			$pdfInv->SetFont('Arial', null, 6);
		    $pdfInv->SetTextColor(0,0,0);
	    	$pdfInv->SetXY(7,$y_for_decetak_oleh+5);


	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_no + $width_kode_pemesanan + $width_maskapai + $width_rute + $width_titel + $width_nama + 5, $table_row_height,$catatan_2,0,0,'L',false );
	   
	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_no + $width_kode_pemesanan + $width_maskapai + $width_rute + $width_titel + $width_nama + 5, $table_row_height,$catatan_3,0,0,'L',false );

	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_no + $width_kode_pemesanan + $width_maskapai + $width_rute + $width_titel + $width_nama + 5, $table_row_height,$catatan_4,0,0,'L',false );

	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_no + $width_kode_pemesanan + $width_maskapai + $width_rute + $width_titel + $width_nama + 5, $table_row_height,$catatan_5,0,0,'L',false );

		    

	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_no + $width_kode_pemesanan + $width_maskapai + $width_rute + $width_titel + $width_nama + 5, $table_row_height,$catatan_6,0,0,'L',false );

		    // tanda tangan baris ke 2
		    $pdfInv->SetFont('Arial', 'B', 8);
		    $pdfInv->SetTextColor(0,0,0);
			// $pdfInv->Cell($width_nama + 1, $table_row_height,null,0,0,'L',false );
			$pdfInv->SetX($pdfInv->GetPageWidth()/2);    
			$pdfInv->Cell($pdfInv->GetPageWidth()/2-7, $table_row_height,\DB::table('users')->find($data_invoice->user_id)->name,0,0,'R',false );
			$pdfInv->SetFont('Arial', null, 6);
		    $pdfInv->SetTextColor(0,0,0);

	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_no + $width_kode_pemesanan + $width_maskapai + $width_rute + $width_titel + $width_nama + 5, $table_row_height,$catatan_7,0,0,'L',false );

	    	// tanda tangan baris ke 3
		    $pdfInv->SetFont('Arial', null, 8);
		    $pdfInv->SetTextColor(0,0,0);
			// $pdfInv->Cell($width_nama + 1, $table_row_height,null,0,0,'L',false );
			$pdfInv->SetX($pdfInv->GetPageWidth()/2);    
			$pdfInv->Cell($pdfInv->GetPageWidth()/2-7, $table_row_height,$company_name,0,0,'R',false );
			$pdfInv->SetFont('Arial', null, 6);
		    $pdfInv->SetTextColor(0,0,0);

	    // $pdfInv->Ln(3);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );

	    
	    // $pdfInv->Output('I',$data_invoice->inv_num .'_'.date('dmYHis') .'.pdf',false);
	    $pdfInv->Output('I',$data_invoice->inv_num  .'.pdf',false);
	    exit;
	}





	

}
