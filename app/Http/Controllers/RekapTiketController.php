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

	public function defaultFilter(Request $req){
		// if($req->filter_option == ""){
		// 	return $this->filterByTanggal($req);
		// }else{
			return $this->filterWithOption($req);
		// }
	}

	public function filterWithOption(Request $req){
		$where_pemesanan = "";
		$where_penumpang = "";

		if(isset($req->filter_option)){

			$idx=1;
			foreach($req->filter_option as $ft){
				if($ft == 'kustomer'){
					$where_pemesanan = $where_pemesanan . " nama like '%" . $req->kustomer . "%'";
				}else if($ft == 'kantor'){
					if(count($req->filter_option) > 1){
						$where_pemesanan =  $where_pemesanan . ' and ' . " kantor like '%" . $req->kantor . "%'";

					}else{
						$where_pemesanan = $where_pemesanan . " kantor like '%" . $req->kantor . "%'";

					}
				}else if($ft == 'maskapai'){
					if(count($req->filter_option) > 1){
						$where_pemesanan =  $where_pemesanan . ' and ' . " maskapai like '%" . $req->maskapai . "%'";

					}else{
						$where_pemesanan = $where_pemesanan . " maskapai like '%" . $req->maskapai . "%'";

					}
				}else if($ft == 'penumpang'){
					$where_penumpang =  " nama like '%" . $req->penumpang . "%'";
				}
				$idx++;

			}
		}
				

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

        if($where_pemesanan != ""){
        	$data = \DB::table('view_data_pemesanan_tiket')
        					->select('*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        					->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
        					->whereRaw($where_pemesanan)
	        				->get();
        	
        }else{
        	$data = \DB::table('view_data_pemesanan_tiket')
        					->select('*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        					->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
	        				->get();
        }


        if($where_penumpang != ""){
        	foreach($data as $dt){
		    	$dt->data_penumpang = \DB::table('invoice_tiket_data_penumpang')
											->where('invoice_tiket_data_pemesanan_id',$dt->pemesanan_id)
											->whereRaw($where_penumpang)
											->get();
		    }
        }else{
		    foreach($data as $dt){
		    	$dt->data_penumpang = \DB::table('invoice_tiket_data_penumpang')
											->where('invoice_tiket_data_pemesanan_id',$dt->pemesanan_id)
											->get();
		    }
        	
        }

        return view('rekap.tiket.filter-with-option',[
        		'data' => $data
        	])->with($req->input());
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

        $data = \DB::table('invoice_tiket')
        					->select('*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        					->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
	        				->get();

	    foreach($data as $dt){
	    	$dt->data_pemesanan = \DB::table('invoice_tiket_data_pemesanan')->where('invoice_tiket_id',$dt->id)->get();

	    	foreach($dt->data_pemesanan as $dps){
				$dps->data_penumpang = \DB::table('invoice_tiket_data_penumpang')
										->where('invoice_tiket_data_pemesanan_id',$dps->id)
										->get();

				$dt->jumlah_data_penumpang = (isset($dt->jumlah_data_penumpang)  ? $dt->jumlah_data_penumpang:0) + count($dps->data_penumpang);
			}
	    }

        return view('rekap.tiket.filter-by-tanggal',[
        		'data' => $data
        	])->with($req->input());
	}

	

	public function cetakWithOption(Request $req){
		$where_pemesanan = "id is not null";
		$where_penumpang = "";
			// $idx=1;
			// foreach($req->filter_option as $ft){
				if($req->kustomer != ''){
					$where_pemesanan = $where_pemesanan . " and nama like '%" . $req->kustomer . "%'";
				}

				if($req->kantor != ""){
					$where_pemesanan =  $where_pemesanan . " and  kantor like '%" . $req->kantor . "%'";
				}

				if($req->maskapai != ""){
					$where_pemesanan =  $where_pemesanan . " and  maskapai like '%" . $req->maskapai . "%'";
					
				}

				if($req->penumpang != ""){
					$where_penumpang =  "nama like '%" . $req->penumpang . "%'";
				}
				// $idx++;

			// }
				

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

        if($where_pemesanan != ""){
        	$data = \DB::table('view_data_pemesanan_tiket')
        					->select('*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        					->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
        					->whereRaw($where_pemesanan)
	        				->get();
        	
        }else{
        	$data = \DB::table('view_data_pemesanan_tiket')
        					->select('*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        					->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
	        				->get();
        }


        if($where_penumpang != ""){
        	foreach($data as $dt){
		    	$dt->data_penumpang = \DB::table('invoice_tiket_data_penumpang')
											->where('invoice_tiket_data_pemesanan_id',$dt->pemesanan_id)
											->whereRaw($where_penumpang)
											->get();
		    }
        }else{
		    foreach($data as $dt){
		    	$dt->data_penumpang = \DB::table('invoice_tiket_data_penumpang')
											->where('invoice_tiket_data_pemesanan_id',$dt->pemesanan_id)
											->get();
		    }
        	
        }

        // CETAK PDF

	    // -------- HEADER ----------------
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

		$pdfOpt = new \Codedge\Fpdf\Fpdf\FPDF($req->orientasi,'mm','A4');
		$pdfOpt->AddPage();
		$pdfOpt->setMargins(10,10,10);
		$pdfOpt->SetAutoPageBreak(false,10);
	    $pdfOpt->SetXY(8,8);

		// image logo
		// $pdfOpt->image('img/' . \DB::table('appsetting')->whereName('logo')->first()->value,8,8,55);
		// $pdfOpt->SetX(65);
		// $pdfOpt->SetFont('Arial', 'B', 8);
	 //    $pdfOpt->Cell(50, 4,$company_name,0,2,'L',false );
	 //    $y = $pdfOpt->GetY();
	 //    $pdfOpt->SetFont('Arial', null, 8);
	 //    $pdfOpt->SetTextColor(0,0,0);
	 //    $pdfOpt->Cell(50, 3,$alamat,0,2,'L',false );
	 //    $x = 0;
	 //    $pdfOpt->Cell(50, 3,$alamat_2 ,0,2,'L',false );
	 //    $pdfOpt->Cell(50, 3,'Telp. ' . $telp .' | ' . 'Fax. ' . $fax ,0,2,'L',false );
	 //    $pdfOpt->Cell(50, 3,'E-Mail. ' . $email ,0,2,'L',false );
	 //    $pdfOpt->Cell(50, 3,'Website. ' . $website ,0,2,'L',false );

	 //    $y_for_line_under_header = $pdfOpt->GetY();
	    


	 //    // INVOICE TITEL
	 //    $pdfOpt->SetXY(8,$y);
	 //    $pdfOpt->SetTextColor(4,82,127);
	 //    $pdfOpt->SetFont('Arial', 'B', 25);
	 //    $pdfOpt->Cell($pdfOpt->GetPageWidth()-14,10,'REKAPITULASI',0,2,'R',false );
	    
	 //    // $pdfOpt->SetX(8);
	 //    $pdfOpt->SetXY(8,$y_for_line_under_header+2);
	 //    $pdfOpt->Cell($pdfOpt->GetPageWidth()-16,2,null,0,2,false);

	    GeneratePdfHeader($pdfOpt,'rek');

	    // -------- END OF HEADER ----------------

	    $idx_header = 1;
	    $option_sampek_tiga_baris = false;

	    // --------- SUB HEADER ------------------
	    $pdfOpt->Ln(10);
	    $pdfOpt->SetX(8);
	    $pdfOpt->SetTextColor(0,0,0);
	    $pdfOpt->SetFont('Arial', 'B', 8);
	    $pdfOpt->Cell(30,5,'KETERANGAN',0,0,'L',false);
	    $pdfOpt->Cell(2,5,':',0,0,'L',false);
	    $pdfOpt->SetFont('Arial', null, 8);
	    $pdfOpt->Cell($pdfOpt->GetPageWidth()/2-8-32,5, 'REKAPITULASI DATA PEMESANAN TIKET',0,0,'L',false);

	    // $pdfOpt->SetX(8);
	    $pdfOpt->SetFont('Arial', 'B', 8);
	    $pdfOpt->Cell(30,5,'TANGGAL CETAK',0,0,'L',false);
	    $pdfOpt->Cell(2,5,':',0,0,'L',false);
	    $pdfOpt->SetFont('Arial', null, 8);
	    $pdfOpt->Cell($pdfOpt->GetPageWidth()/2-8-32,5, str_replace('-','/',$req->tanggal_cetak_awal) .' - ' . str_replace('-','/',$req->tanggal_cetak_akhir),0,2,'L',false);

	    if($req->kustomer != ""){
	    	if($idx_header == 1 || $idx_header == 3) $pdfOpt->SetX(8);

		    $pdfOpt->SetFont('Arial', 'B', 8);
		    $pdfOpt->Cell(30,5,'NAMA KUSTOMER',0,0,'L',false);
		    $pdfOpt->Cell(2,5,':',0,0,'L',false);
		    $pdfOpt->SetFont('Arial', null, 8);
		    $pdfOpt->Cell($pdfOpt->GetPageWidth()/2-8-32,5, $req->kustomer != "" ? $req->kustomer : '-',0,0,'L',false);
		    if($idx_header == 2 ){
		    	$pdfOpt->Ln(5);
		    }
		    $idx_header++;
	    }

	    // if($req->)
	    if($req->kantor != ""){
	    	if($idx_header == 1 || $idx_header == 3) $pdfOpt->SetX(8);

		    $pdfOpt->SetFont('Arial', 'B', 8);
		    $pdfOpt->Cell(30,5,'KANTOR',0,0,'L',false);
		    $pdfOpt->Cell(2,5,':',0,0,'L',false);
		    $pdfOpt->SetFont('Arial', null, 8);
		    $pdfOpt->Cell($pdfOpt->GetPageWidth()/2-8-32,5, $req->kantor != "" ? $req->kantor : '-',0,0,'L',false);
		    
		    if($idx_header == 2 ){
		    	$pdfOpt->Ln(5);
		    }
		    $idx_header++;
	    }

	    if($req->maskapai != ""){
	    	if($idx_header == 1 || $idx_header == 3) $pdfOpt->SetX(8);
		    
		    $pdfOpt->SetFont('Arial', 'B', 8);
		    $pdfOpt->Cell(30,5,'MASKAPAI',0,0,'L',false);
		    $pdfOpt->Cell(2,5,':',0,0,'L',false);
		    $pdfOpt->SetFont('Arial', null, 8);
		    $pdfOpt->Cell($pdfOpt->GetPageWidth()/2-8-32,5, $req->maskapai != "" ? $req->maskapai : '-',0,0,'L',false);


		    if($idx_header == 2 ){
		    	$pdfOpt->Ln(5);
		    }
		    $idx_header++;
		    $option_sampek_tiga_baris = true;
	    }

	    if($req->penumpang != ""){
	    	if($idx_header == 1 || $idx_header == 3) $pdfOpt->SetX(8);
		    
		    $pdfOpt->SetFont('Arial', 'B', 8);
		    $pdfOpt->Cell(30,5,'NAMA PENUMPANG',0,0,'L',false);
		    $pdfOpt->Cell(2,5,':',0,0,'L',false);
		    $pdfOpt->SetFont('Arial', null, 8);
		    $pdfOpt->Cell($pdfOpt->GetPageWidth()/2-8-32,5,$req->penumpang != "" ? $req->penumpang : '-',0,0,'L',false);
		    
		    if($idx_header == 2 ){
		    	$pdfOpt->Ln(5);
		    }
		    $idx_header++;
	    }

	    

	    // $pdfOpt->SetX(8);
	    // --------- END OF SUB HEADER ------------------
	    if($option_sampek_tiga_baris){
	    	$pdfOpt->Ln(5);
	    }

	    $content_width = $pdfOpt->GetPageWidth()-16 ;
	    // $content_width_header = $content_width - 7;
		$width_separator = 1;
		$width_no = 5/100 * $content_width -1;
		$width_nomor_invoice = 13/100 * $content_width -1;
		$width_kode_pemesanan = 16/100 * $content_width -1;
		$width_tanggal_cetak = 9/100 * $content_width -1;
		$width_nama_penumpang = 18/100 * $content_width -1;
		$width_nomor_tiket = 12/100 * $content_width -1;
		$width_maskapai = 15/100 * $content_width -1;
		$width_harga = 12/100 * $content_width;
		
		$col_heider_height  = 10;
		// $col_height  = 8;
		$col_height = \DB::table('appsetting')->whereName('inv_height_of_row')->first()->value * 2;

		$pdfOpt->Ln(5);
	    $pdfOpt->SetX(8);
	    $pdfOpt->SetTextColor(255,255,255);
	    $pdfOpt->SetFont('Arial', 'B', 7);

	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($width_no,$col_heider_height,'NO',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(4,82,127);	    
	    $pdfOpt->Cell($width_nomor_invoice,$col_heider_height,'NOMOR INVOICE',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(4,82,127);
	    $x_kode_pemesanan = $pdfOpt->GetX();
	    $y_kode_pemesanan = $pdfOpt->GetY();
	    if($pdfOpt->GetStringWidth('KODE PEMESANAN') > $width_kode_pemesanan){
		    $pdfOpt->Cell($width_kode_pemesanan,$col_heider_height,null,0,0,'C',true);
		    $pdfOpt->SetXY($x_kode_pemesanan,$y_kode_pemesanan+2);
		    $pdfOpt->MultiAlignCell($width_kode_pemesanan,$col_heider_height/2-2,'KODE PEMESANAN',0,0,'C',true);
		    $pdfOpt->SetXY($pdfOpt->GetX(),$y_kode_pemesanan);
	    	
	    }else{
	    	$pdfOpt->Cell($width_kode_pemesanan,$col_heider_height,'KODE PEMESANAN',0,0,'C',true);
	    }
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(4,82,127);
	    $x_tanggal_cetak = $pdfOpt->GetX();
	    $y_tanggal_cetak = $pdfOpt->GetY();
	    if($pdfOpt->GetStringWidth('TANGGAL CETAK') > $width_tanggal_cetak){
		    $pdfOpt->Cell($width_tanggal_cetak,$col_heider_height,null,0,0,'C',true);
		    $pdfOpt->SetXY($x_tanggal_cetak,$y_tanggal_cetak+2);
		    $pdfOpt->MultiAlignCell($width_tanggal_cetak,$col_heider_height/2-2,'TANGGAL CETAK',0,0,'C',true);
		    $pdfOpt->SetXY($pdfOpt->GetX(),$y_tanggal_cetak);
	    	
	    }else{
	    	$pdfOpt->Cell($width_tanggal_cetak,$col_heider_height,'TANGGAL CETAK',0,0,'C',true);
	    }
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($width_nama_penumpang,$col_heider_height,'NAMA PENUMPANG',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->MultiAlignCell($width_nomor_tiket,$col_heider_height,'NOMOR TIKET',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($width_maskapai,$col_heider_height,'MASKAPAI',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($width_harga,$col_heider_height,'HARGA',0,2,'C',true);

	       // LINE PUTIH
	    $pdfOpt->SetX(8);
	    $y = $pdfOpt->GetY();
	    $pdfOpt->SetFillColor(4,82,127);
	    // $pdfOpt->Cell($content_width,1,null,0,2,'C',false);
	    // $pdfOpt->SetY($y);
	    $pdfOpt->SetX(8 + $width_no + 1);
	    $pdfOpt->Cell($width_nomor_invoice,1,null,0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,1,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(4,82,127);
	    $pdfOpt->Cell($width_kode_pemesanan,1,null,0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,1,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(4,82,127);
	    $pdfOpt->Cell($width_tanggal_cetak,1,null,0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,1,null,0,2,'C',true);

	    $pdfOpt->SetX(8 );
	    $pdfOpt->SetFillColor(4,82,127);
	    $pdfOpt->Cell($content_width,1,null,0,2,'C',true);

	    // -------------------------------------------------------



	    // TABLE CONTENT
	    $pdfOpt->SetX(8);
	    $pdfOpt->SetTextColor(0,0,0);
	    $pdfOpt->SetFont('Arial', null, 7);
	    	$total_harga=0;
	    	$rownum=1;
            $rowdt = 1; 
            foreach($data as $dt){
                 $oddeven = $rowdt & 1 ? 'row-odd' : 'row-even'; 
                 $rowpg=1; 
                
                $y_per_row_penumpang = $pdfOpt->GetY();
                foreach($dt->data_penumpang as $dpg){

                	// cek new page
                	if($pdfOpt->GetY()+(count($dt->data_penumpang)*$col_height) >= ($pdfOpt->GetPageHeight()-10) ){
                		$pdfOpt->AddPage();
                		$pdfOpt->SetXY(8,10);
                		$y_per_row_penumpang = 10;
                		// $pdfOpt->Cell($pdfOpt->GetPageWidth() - 16,0,null,'B',2,'L',false);
                	}

                	$pdfOpt->SetX(8 );
                	$min_tanggal_cetak = str_replace('-','/',$dt->tgl_cetak_formatted);

                			$page_y_height = $pdfOpt->GetY() . '  -  ' . $pdfOpt->GetPageHeight();
                        
                            if(count($dt->data_penumpang) > 1){
                                if($rowpg == 1){
                                	$pdfOpt->Cell($width_no,$col_height *count($dt->data_penumpang),$rownum++ ,0,0,'C',false);
                					$pdfOpt->Cell($width_separator,$col_height*count($dt->data_penumpang),null,0,0,'C',false);

                                    $pdfOpt->Cell($width_nomor_invoice,$col_height*count($dt->data_penumpang),$dt->inv_num,0,0,'C',false);
                                    $pdfOpt->Cell($width_separator,$col_height*count($dt->data_penumpang),null,0,0,'C',false);

                                    if($pdfOpt->GetStringWidth($dt->kode_pemesanan) > $width_kode_pemesanan){
                                    	// cetak dua baris
                                    	$pdfOpt->MultiAlignCell($width_kode_pemesanan,$col_height/2*count($dt->data_penumpang),$dt->kode_pemesanan,0,0,'C',false);
                                    	$pdfOpt->Cell($width_separator,$col_height*count($dt->data_penumpang),null,0,0,'C',false);
                                    }else{
                                    	$pdfOpt->Cell($width_kode_pemesanan,$col_height*count($dt->data_penumpang),$dt->kode_pemesanan,0,0,'C',false);
                                    	$pdfOpt->Cell($width_separator,$col_height*count($dt->data_penumpang),null,0,0,'C',false);
                                    }

                                    
                                    $pdfOpt->Cell($width_tanggal_cetak,$col_height*count($dt->data_penumpang),$min_tanggal_cetak,0,0,'C',false);
                                    $pdfOpt->Cell($width_separator,$col_height*count($dt->data_penumpang),null,0,0,'C',false);
                                    
                                }
                            }else{
                            	$pdfOpt->Cell($width_no,$col_height,$rownum++ ,0,0,'C',false);
                				$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);

                                $pdfOpt->Cell($width_nomor_invoice,$col_height,$dt->inv_num,0,0,'C',false);
                                $pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);

                                if($pdfOpt->GetStringWidth($dt->kode_pemesanan) > $width_kode_pemesanan){
                                	// cetak dua baris
                                	$pdfOpt->MultiAlignCell($width_kode_pemesanan,$col_height/2,$dt->kode_pemesanan,0,0,'C',false);
                                	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                                }else{
                                	$pdfOpt->Cell($width_kode_pemesanan,$col_height,$dt->kode_pemesanan,0,0,'C',false);
                                	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                                }

                                
                                $pdfOpt->Cell($width_tanggal_cetak,$col_height,$min_tanggal_cetak,0,0,'C',false);
                                $pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                            }
                            
                            $pdfOpt->SetXY(8+$width_no+$width_nomor_invoice+$width_kode_pemesanan+$width_tanggal_cetak+4,$y_per_row_penumpang);
                            // $pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);

                            $nama_penumpang = strtoupper($dpg->titel) . ' ' . $dpg->nama;
                            // $pdfOpt->wordwrap($nama_penumpang,$width_nama_penumpang);
                            $jml_line = $pdfOpt->GetMultiCellHeight($width_nama_penumpang,$col_height,$nama_penumpang);

                            while($jml_line > ($col_height*2) ) {
								// $pdf->SetFontSize($font_size -= $decrement_step);
								 $nama_penumpang =substr_replace($nama_penumpang, '', -1);
								 $jml_line = $pdfOpt->GetMultiCellHeight($width_nama_penumpang,$col_height,$nama_penumpang);
							}
							

                            if($pdfOpt->GetStringWidth($nama_penumpang) > $width_nama_penumpang){
                            	// cetak dua baris
                            	$pdfOpt->MultiAlignCell($width_nama_penumpang,$col_height/2,$nama_penumpang  ,0,0,'L',false);
                            	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                            }else{
                            	$pdfOpt->Cell($width_nama_penumpang,$col_height,$nama_penumpang,0,0,'L',false);
                            	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                            	
                            }

                            
                            if($pdfOpt->GetStringWidth($dpg->nomor_tiket) > $width_nomor_tiket){
                            	// cetak dua baris
                            	$pdfOpt->MultiAlignCell($width_nomor_tiket,$col_height/2,$dpg->nomor_tiket,0,0,'C',false);
                            	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                            }else{
                            	$pdfOpt->Cell($width_nomor_tiket,$col_height,$dpg->nomor_tiket,0,0,'C',false);
                            	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                            	
                            }

                            if(count($dt->data_penumpang) > 1){
                                if($rowpg == 1){
                                    // $pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);

                                    if($pdfOpt->GetStringWidth($dt->maskapai) > $width_maskapai){
                                		// cetak dua baris 
                                		$pdfOpt->MultiAlignCell($width_maskapai,$col_height/2 * count($dt->data_penumpang),$dt->maskapai,0,0,'C',false);
                                		$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                                	}else{
                                		$pdfOpt->Cell($width_maskapai,$col_height * count($dt->data_penumpang),$dt->maskapai,0,0,'C',false);
                                		$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                                	}

                                    // $pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);

                                    $pdfOpt->Cell(3,$col_height*count($dt->data_penumpang),'Rp.',0,0,'L',false);
                                    $pdfOpt->Cell($width_harga-3,$col_height*count($dt->data_penumpang),number_format($dt->harga,2,',','.'),0,0,'R',false);
                                    $total_harga += $dt->harga;
                                }
                            }else{

                                if($pdfOpt->GetStringWidth($dt->maskapai) > $width_maskapai){
                                		// cetak dua baris 
                            		$pdfOpt->MultiAlignCell($width_maskapai,$col_height/2 ,$dt->maskapai,0,0,'C',false);
                            		$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                            	}else{
                            		$pdfOpt->Cell($width_maskapai,$col_height ,$dt->maskapai,0,0,'C',false);
                            		$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                            	}

                                $pdfOpt->Cell(3,$col_height,'Rp.',0,0,'L',false);
                                $pdfOpt->Cell($width_harga-3,$col_height,number_format($dt->harga,2,',','.'),0,0,'R',false);
                                $total_harga += $dt->harga;
                            }
                            

                            $pdfOpt->Ln($col_height);
                            $y_per_row_penumpang = $y_per_row_penumpang+$col_height;

                            if(count($dt->data_penumpang) > 1){
                                if($rowpg == 1){
                                     $rowdt++;
                                }
                            }else{
                                 $rowdt++;
                            }

                             $rowpg++;                             

                    }
                    // line per row
                     $pdfOpt->SetX(8);
                     $pdfOpt->Cell($pdfOpt->GetPageWidth() - 16,0,null,'B',2,'L',false);
            }
	    // END OF TABLE CONTENT

        // TOTAL
	    $total_height = 10;
	    $pdfOpt->SetFont('Arial', 'B', 12);
	    $pdfOpt->Ln(5);	    
	   
	    $pdfOpt->SetX(0);
	    $pdfOpt->SetX( 8 + $width_no + $width_separator + $width_nomor_invoice + $width_separator + $width_kode_pemesanan + $width_separator + $width_tanggal_cetak + $width_separator + $width_nama_penumpang + $width_separator );
	    $pdfOpt->SetFillColor(4,82,127);
	    $pdfOpt->SetTextColor(255,255,255);
	    $pdfOpt->Cell($width_nomor_tiket, $total_height,'TOTAL',0,0,'C',true );
	    $pdfOpt->Cell($width_maskapai + $width_harga + 2, $total_height ,'Rp. ' . number_format($total_harga,2,',','.'),0,2,'C',true );
        // END OF TOTAL

        // TERBILANG
	    $pdfOpt->Ln(5);
	    $pdfOpt->SetX(8);
	    $pdfOpt->SetFont('Arial', 'B', 8);
	    $pdfOpt->SetTextColor(255,255,255);
	    $terbilang =  strtoupper(convertTerbilang($total_harga) . ' Rupiah');
	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($pdfOpt->GetPageWidth()-16, 5,'   '.$terbilang,0,0,'L',true );
	    // END OF TERBILANG


	    // ---- FOOOTER ----------
	    // $pdfOpt->Cell(10, 0,null,0,0,'C',false );
	    $catatan_1 = \DB::table('appsetting')->whereName('inv_catatan_1')->first()->value;
	    $catatan_2 = \DB::table('appsetting')->whereName('inv_catatan_2')->first()->value;
	    $catatan_3 = \DB::table('appsetting')->whereName('inv_catatan_3')->first()->value;
	    $catatan_4 = \DB::table('appsetting')->whereName('inv_catatan_4')->first()->value;
	    $catatan_5 = \DB::table('appsetting')->whereName('inv_catatan_5')->first()->value;
	    $catatan_6 = \DB::table('appsetting')->whereName('inv_catatan_6')->first()->value;
	    $catatan_7 = \DB::table('appsetting')->whereName('inv_catatan_7')->first()->value;
	    $dicetak_oleh = \Auth::user()->name;
	    $footer_left_width = $pdfOpt->GetPageWidth()/2 - 8;
	    $footer_right_width = $pdfOpt->GetPageWidth()/2 - 8;
	    $catatan_height = 3;

	    $pdfOpt->Ln($col_height);
	    $pdfOpt->SetX(8);
	    $y_footer = $pdfOpt->GetY();
	    $pdfOpt->SetTextColor(0,0,0);
	    // $pdfOpt->Ln($table_row_height);
	    $pdfOpt->SetFont('Arial', null, 8);
	    $pdfOpt->Cell($footer_left_width*2,$catatan_height,'Dicetak oleh,',0,2,'R',false );
	    $pdfOpt->Ln(3);
	    $pdfOpt->SetX(8);
	    $pdfOpt->SetFont('Arial', 'BU', 6);
	    $pdfOpt->Cell($footer_left_width,$catatan_height,$catatan_1,0,2,'L',false );
	    $pdfOpt->SetFont('Arial', null, 6);
	    $pdfOpt->Cell($footer_left_width,$catatan_height,$catatan_2,0,2,'L',false );
	    $pdfOpt->Cell($footer_left_width,$catatan_height,$catatan_3,0,2,'L',false );
	    $pdfOpt->Cell($footer_left_width,$catatan_height,$catatan_4,0,2,'L',false );
	    $pdfOpt->Cell($footer_left_width,$catatan_height,$catatan_5,0,2,'L',false );
	    $pdfOpt->Cell($footer_left_width,$catatan_height,$catatan_6,0,0,'L',false );

	    	$pdfOpt->SetFont('Arial', 'B', 8);
	    	$pdfOpt->Cell($footer_left_width,$catatan_height,$dicetak_oleh,0,2,'R',false );

	    $pdfOpt->SetX(8);
	    $pdfOpt->SetFont('Arial', null, 6);
	    $pdfOpt->Cell($footer_left_width,$catatan_height,$catatan_7,0,0,'L',false );

	    	$pdfOpt->SetFont('Arial', null, 8);
	    	$pdfOpt->Cell($footer_left_width,$catatan_height,$company_name,0,2,'R',false );

	    // ---- END FOOOTER ----------
	   

	    $pdfOpt->Output('I','Rekapitulasi_data_tiket_'.$req->tanggal_cetak_awal.'-'.$req->tanggal_cetak_akhir  .'.pdf',false);
	    exit;

	}

}
