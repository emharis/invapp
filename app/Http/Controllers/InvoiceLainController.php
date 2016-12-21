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

				$inv_prefix = \DB::table('appsetting')->whereName('inv_lain_prefix')->first()->value;
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


	// ===============================================
	// CETAK INVOICE
	// ===============================================
	public function cetakInvoice($invoice_id){
		$data_invoice = \DB::table('invoice_lain')
						->select('invoice_lain.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
						->find($invoice_id);
		$data_pemesanan = \DB::table('invoice_lain_detail')
							->where('invoice_lain_id',$invoice_id)
							->get();

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

		
		$pdfInv = new \Codedge\Fpdf\Fpdf\FPDF();
		$pdfInv->AddPage();
		$pdfInv->setMargins(0,0,0);
		$pdfInv->SetAutoPageBreak(true,0);

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
	 //    // $pdfTiket->SetXY(0,$y);
	 //    // $pdfTiket->Cell(0,10,'INVOICE     ',0,2,'R',false );
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
	    $width_keterangan = 105;//\DB::table('appsetting')->whereName('inv_width_keterangan')->first()->value;
	    $width_maskapai = \DB::table('appsetting')->whereName('inv_width_maskapai')->first()->value;
	    $width_rute = \DB::table('appsetting')->whereName('inv_width_rute')->first()->value;
	    $width_harga_satuan = 30;//\DB::table('appsetting')->whereName('inv_width_harga_satuan')->first()->value;
	    $width_jumlah = 15;//\DB::table('appsetting')->whereName('inv_width_jumlah')->first()->value;
	    $width_total = 30;//\DB::table('appsetting')->whereName('inv_width_total')->first()->value;
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
	    
	    $pdfInv->MultiAlignCell($width_keterangan, $col_height*2,'KETERANGAN',0,0,'C',true );
	    
	     // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height_other,null,0,0,'C',true );
	    $pdfInv->SetFillColor(0,0,0);
	    // --- end separator ---
	    $pdfInv->Cell($width_harga_satuan, $col_height_other,'HARGA SATUAN',0,0,'C',true );
	     // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height_other,null,0,0,'C',true );
	    $pdfInv->SetFillColor(0,0,0);
	    // --- end separator ---
	    $pdfInv->Cell($width_jumlah, $col_height_other,'JUMLAH',0,0,'C',true );
	     // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height_other,null,0,0,'C',true );
	    $pdfInv->SetFillColor(0,0,0);
	    // --- end separator ---
	    $pdfInv->Cell($width_total, $col_height_other,'TOTAL',0,0,'C',true );
	     // --- separator ---
	    $pdfInv->SetFillColor(255,255,255);
	    $pdfInv->Cell($width_separator, $col_height_other,null,0,2,'C',true );
	    $pdfInv->SetFillColor(0,0,0);
	    // --- end separator ---
	    
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
	    	$pdfInv->SetX(8);

		    $pdfInv->Cell($width_no, $table_row_height,$rownum++,0,0,'C',false );
		    $pdfInv->Cell($width_separator, $table_row_height,null,0,0,'C',false );

		    
		    $pdfInv->Cell($width_separator, $table_row_height,null,0,0,'C',false );

		    $maxlen_keterangan = \DB::table('appsetting')->whereName('inv_lain_maxlen_keterangan')->first()->value;
		    if(strlen($dps->keterangan) > $maxlen_keterangan){
			    $y = $pdfInv->GetY();
			    $x = $pdfInv->GetX();
			    $pdfInv->SetXY($x,$y + 2);
			    $pdfInv->MultiAlignCell($width_keterangan, $table_row_height/2-2,$dps->keterangan,0,0,'L',false );
			    $x = $pdfInv->GetX();
			    $y = $pdfInv->GetY();
			    $pdfInv->SetXY($x,$y - 2);
			}else{
			    $pdfInv->Cell($width_keterangan, $table_row_height,$dps->keterangan,0,0,'L',false );
			}

		    
		    $pdfInv->Cell($width_separator, $table_row_height,null,0,0,'C',false );


		    $maxlen_rute  = $maxlen_keterangan = \DB::table('appsetting')->whereName('inv_maxlen_rute')->first()->value;
		    $harga_satuan =  number_format($dps->harga_satuan,2,',','.') . '  ' ;
		
			    $pdfInv->Cell(2, $table_row_height,'Rp.',0,0,'L',false );
			    $pdfInv->Cell($width_harga_satuan-2, $table_row_height,$harga_satuan,0,0,'R',false );
		
		    
		    $pdfInv->Cell($width_separator, $table_row_height,null,0,0,'C',false );

		    $pdfInv->Cell($width_jumlah, $table_row_height,$dps->jumlah,0,0,'C',false );
		    $pdfInv->Cell($width_separator, $table_row_height,null,0,0,'C',false );

		    $pdfInv->Cell(2, $table_row_height,'Rp.',0,0,'L',false );
		    $pdfInv->Cell($width_total-2, $table_row_height,number_format($dps->total_harga ,2,',','.').'  ',0,2,'R',false );
		   
		    $full_row_width = 192;//$width_no+$width_keterangan+$width_maskapai+$width_rute+$width_harga_satuan+$width_jumlah+$width_total+$width_harga+7;

		    // line di bawah tiap row
		    $pdfInv->SetX(8);
		    $pdfInv->Cell(194, 0,null,'B',2,'C',false );
		    
	    }

	    // TOTAL
	    $pdfInv->Ln(5);
	    $pdfInv->SetX(8);
	    $total_height = 10;
	    $pdfInv->SetFont('Arial', 'B', 12);	    
	    $pdfInv->SetFillColor(4,82,127);
	    $pdfInv->SetTextColor(255,255,255);
	    $pdfInv->SetX(125);
	    $pdfInv->Cell($width_harga_satuan, $total_height,'TOTAL',0,0,'C',true );
	    $pdfInv->Cell($width_jumlah + $width_total + 2 , $total_height ,'Rp. ' . number_format($data_invoice->total,2,',','.'),0,0,'C',true );

	    // terbilang
	    $pdfInv->Ln();
	    $pdfInv->Ln(5);
	    $pdfInv->SetX(8);
	    $pdfInv->SetFont('Arial', 'B', 8);
	    $pdfInv->SetTextColor(255,255,255);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $terbilang =  strtoupper($data_invoice->terbilang . ' Rupiah');
	    $pdfInv->SetFillColor(0,0,0);
	    $pdfInv->Cell($full_row_width+2, 5,'   '.$terbilang,0,0,'L',true );


	 //    $pdfInv->Ln(10);
	 //    $y_for_decetak_oleh = $pdfInv->GetY();
	 //    $pdfInv->SetFont('Arial', null, 6);
	 //    $pdfInv->SetTextColor(0,0,0);
	 //    $pdfInv->Ln($table_row_height);
	 //    $pdfInv->Cell(10, 0,null,0,0,'C',false );
	 //    $catatan_1 = \DB::table('appsetting')->whereName('inv_catatan_1')->first()->value;
	 //    $catatan_2 = \DB::table('appsetting')->whereName('inv_catatan_2')->first()->value;
	 //    $catatan_3 = \DB::table('appsetting')->whereName('inv_catatan_3')->first()->value;
	 //    $catatan_4 = \DB::table('appsetting')->whereName('inv_catatan_4')->first()->value;
	 //    $catatan_5 = \DB::table('appsetting')->whereName('inv_catatan_5')->first()->value;
	 //    $catatan_6 = \DB::table('appsetting')->whereName('inv_catatan_6')->first()->value;
	 //    $catatan_7 = \DB::table('appsetting')->whereName('inv_catatan_7')->first()->value;

	 //    $pdfInv->SetXY(10,$y_for_decetak_oleh+5);
	 //    $pdfInv->MultiAlignCell($pdfInv->GetPageWidth()/2, $table_row_height,$catatan_1,0,0,'L',false );

	 //    // tanda tangan baris ke 1
	 //    $pdfInv->SetFont('Arial', null, 8);
	 //    $pdfInv->SetTextColor(0,0,0);
	 //    $x = $pdfInv->GetX();
	 //    // $pdfInv->SetXY($x,$y_for_decetak_oleh);

		// // $pdfInv->Cell($width_jumlah + 1, $table_row_height,null,0,0,'L',false );	    
		// $pdfInv->Cell($pdfInv->GetPageWidth()/2-17, $table_row_height,'Dicetak oleh,',0,0,'R',false );	    
		// $pdfInv->SetFont('Arial', null, 6);
	 //    $pdfInv->SetTextColor(0,0,0);


	 //    $pdfInv->SetXY(10,$y_for_decetak_oleh+5);
	 //    $pdfInv->Ln(3);
	 //    $pdfInv->Cell(10, 0,null,0,0,'C',false );
	 //    $pdfInv->MultiAlignCell($pdfInv->GetPageWidth()/2, $table_row_height,$catatan_2,0,0,'L',false );
	   
	 //    $pdfInv->Ln(3);
	 //    $pdfInv->Cell(10, 0,null,0,0,'C',false );
	 //    $pdfInv->MultiAlignCell($pdfInv->GetPageWidth()/2, $table_row_height,$catatan_3,0,0,'L',false );

	 //    $pdfInv->Ln(3);
	 //    $pdfInv->Cell(10, 0,null,0,0,'C',false );
	 //    $pdfInv->MultiAlignCell($pdfInv->GetPageWidth()/2, $table_row_height,$catatan_4,0,0,'L',false );

	 //    $pdfInv->Ln(3);
	 //    $pdfInv->Cell(10, 0,null,0,0,'C',false );
	 //    $pdfInv->MultiAlignCell($pdfInv->GetPageWidth()/2, $table_row_height,$catatan_5,0,0,'L',false );

		    

	 //    $pdfInv->Ln(3);
	 //    $pdfInv->Cell(10, 0,null,0,0,'C',false );
	 //    $pdfInv->MultiAlignCell($pdfInv->GetPageWidth()/2, $table_row_height,$catatan_6,0,0,'L',false );

		//     // tanda tangan baris ke 2
		//     $pdfInv->SetFont('Arial', 'B', 8);
		//     $pdfInv->SetTextColor(0,0,0);
		// 	// $pdfInv->Cell($width_jumlah + 1, $table_row_height,null,0,0,'L',false );	    
		// 	$pdfInv->Cell($pdfInv->GetPageWidth()/2-17, $table_row_height,\DB::table('users')->find($data_invoice->user_id)->name,0,0,'R',false );	    
		// 	$pdfInv->SetFont('Arial', null, 6);
		//     $pdfInv->SetTextColor(0,0,0);

	 //    $pdfInv->Ln(3);
	 //    $pdfInv->Cell(10, 0,null,0,0,'C',false );
	 //    $pdfInv->MultiAlignCell($pdfInv->GetPageWidth()/2, $table_row_height,$catatan_7,0,0,'L',false );

	 //    	// tanda tangan baris ke 3
		//     $pdfInv->SetFont('Arial', null, 8);
		//     $pdfInv->SetTextColor(0,0,0);
		// 	// $pdfInv->Cell($width_jumlah + 1, $table_row_height,null,0,0,'L',false );
			
		// 	$pdfInv->Cell($pdfInv->GetPageWidth()/2-17, $table_row_height,$company_name,0,0,'R',false );	    
		// 	$pdfInv->SetFont('Arial', null, 6);
		//     $pdfInv->SetTextColor(0,0,0);

	 //    $pdfInv->Ln(3);
	 //    $pdfInv->Cell(10, 0,null,0,0,'C',false );

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

	    $width_half_footer = $pdfInv->GetPageWidth()/2;

	    $pdfInv->SetXY(7,$y_for_decetak_oleh+5);
	    $pdfInv->SetFont('Arial', 'BU', 6);
	    $pdfInv->MultiAlignCell($width_half_footer, $table_row_height,$catatan_1,0,0,'L',false );

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
	    $pdfInv->MultiAlignCell($width_half_footer, $table_row_height,$catatan_2,0,0,'L',false );
	   
	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_half_footer, $table_row_height,$catatan_3,0,0,'L',false );

	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_half_footer, $table_row_height,$catatan_4,0,0,'L',false );

	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_half_footer, $table_row_height,$catatan_5,0,0,'L',false );

		    

	    $pdfInv->Ln(3);
	    $pdfInv->SetX(7);
	    // $pdfInv->Cell(10, 0,null,0,0,'C',false );
	    $pdfInv->MultiAlignCell($width_half_footer, $table_row_height,$catatan_6,0,0,'L',false );

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
	    $pdfInv->MultiAlignCell($width_half_footer, $table_row_height,$catatan_7,0,0,'L',false );

	    	// tanda tangan baris ke 3
		    $pdfInv->SetFont('Arial', null, 8);
		    $pdfInv->SetTextColor(0,0,0);
			// $pdfInv->Cell($width_nama + 1, $table_row_height,null,0,0,'L',false );
			$pdfInv->SetX($pdfInv->GetPageWidth()/2);    
			$pdfInv->Cell($pdfInv->GetPageWidth()/2-7, $table_row_height,$company_name,0,0,'R',false );
			$pdfInv->SetFont('Arial', null, 6);
		    $pdfInv->SetTextColor(0,0,0);

	    
	    // $pdfInv->Output('I',$data_invoice->inv_num .'_'.date('dmYHis') .'.pdf',false);
	    $pdfInv->Output('I',$data_invoice->inv_num  .'.pdf',false);
	    exit;
		
	}


	// ===============================================
	// CETAK KWITANSI
	// ===============================================
	public function cetakKwitansi($invoice_id){
		$data_invoice = \DB::table('invoice_lain')
						->select('invoice_lain.*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
						->find($invoice_id);
		$data_pemesanan = \DB::table('invoice_lain_detail')
							->where('invoice_lain_id',$invoice_id)
							->get();

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

		 GeneratePdfHeader($pdfKw,'kw');

	    // $y_for_line_under_header = $pdfKw->GetY() -3;

	    // // KWITANSI TITEL
	    // // KWITANSI TITEL
	    // $pdfKw->SetTextColor(4,82,127);
	    // $pdfKw->SetFont('Arial', 'B', 25);
	    // // $pdfKw->Cell(110, 15,null,0,0,'L',false );
	    // // $pdfKw->SetXY(0,$y);
	    // // $pdfKw->Cell(0,10,'KWITANSI     ',0,2,'R',false );
	    // $pdfKw->SetXY(10,$y);
	    // $pdfKw->Cell($pdfKw->GetPageWidth()-15,10,'KWITANSI',0,2,'R',false );

	    // // LINE
	    // $pdfKw->SetXY(8,$y_for_line_under_header+5);
	    // $pdfKw->SetDrawColor(82,82,86);
	    // $pdfKw->Cell(195,1,null,'B',2,'L',false);
	    // // $pdfKw->Cell(0,1,null,'B',2,'L',false);

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

		$pdfKw->Output('I',$data_invoice->inv_num  .'.pdf',false);
	    exit;

	}

}
