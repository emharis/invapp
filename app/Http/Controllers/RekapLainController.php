<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class RekapLainController extends Controller
{
	public function index(){
		
		return view('rekap.lain.index',[
			]);
	}

	public function defaultFilter(Request $req){
		return $this->filterWithOption($req);
	}

	public function filterWithOption(Request $req){
		$where_pemesanan = "";
		$where_keterangan = "";

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
				}
				
				else if($ft == 'keterangan'){
					$where_keterangan =  " keterangan like '%" . $req->keterangan . "%'";
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
        	$data = \DB::table('invoice_lain')
        					->select('*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        					->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
        					->whereRaw($where_pemesanan)
	        				->get();
        	
        }else{
        	$data = \DB::table('invoice_lain')
        					->select('*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        					->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
	        				->get();
        }


        if($where_keterangan != ""){
        	foreach($data as $dt){
		    	$dt->data_detail = \DB::table('invoice_lain_detail')
											->where('invoice_lain_id',$dt->id)
											->whereRaw($where_keterangan)
											->get();
		    }
        }else{
		    foreach($data as $dt){
		    	$dt->data_detail = \DB::table('invoice_lain_detail')
											->where('invoice_lain_id',$dt->id)
											->get();
		    }
        	
        }

        // echo json_encode($data);
        return view('rekap.lain.filter-with-option',[
        		'data' => $data
        	])->with($req->input());
	}


	public function cetakWithOption(Request $req){
		$where_pemesanan = "";
		$where_keterangan = "";

		if($req->kustomer != ''){
			$where_pemesanan = $where_pemesanan . " and nama like '%" . $req->kustomer . "%'";
		}

		if($req->kantor != ""){
			$where_pemesanan =  $where_pemesanan . " and  kantor like '%" . $req->kantor . "%'";
		}

		if($req->keterangan != ""){
			$where_keterangan =  "keterangan like '%" . $req->keterangan . "%'";
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
        	$data = \DB::table('invoice_lain')
        					->select('*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        					->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
        					->whereRaw($where_pemesanan)
	        				->get();
        	
        }else{
        	$data = \DB::table('invoice_lain')
        					->select('*',\DB::raw('date_format(tgl_cetak,"%d-%m-%Y") as tgl_cetak_formatted'),\DB::raw('date_format(jatuh_tempo,"%d-%m-%Y") as jatuh_tempo_formatted'))
        					->whereBetween('tgl_cetak',[$tanggal_cetak_awal_str,$tanggal_cetak_akhir_str])
	        				->get();
        }


        if($where_keterangan != ""){
        	foreach($data as $dt){
		    	$dt->data_detail = \DB::table('invoice_lain_detail')
											->where('invoice_lain_id',$dt->id)
											->whereRaw($where_keterangan)
											->get();
		    }
        }else{
		    foreach($data as $dt){
		    	$dt->data_detail = \DB::table('invoice_lain_detail')
											->where('invoice_lain_id',$dt->id)
											->get();
		    }
        	
        }

	    // -------- HEADER ----------------
	    $company_name = \DB::table('appsetting')->whereName('nama_perusahaan')->first()->value;	    
		$alamat = \DB::table('appsetting')->whereName('alamat')->first()->value;	    
		$alamat_2 = \DB::table('appsetting')->whereName('alamat_2')->first()->value;	    
		$kecamatan = \DB::table('appsetting')->whereName('kecamatan')->first()->value;	    
		$kabupaten = \DB::table('appsetting')->whereName('kabupaten')->first()->value;	    
		$kodepos = \DB::table('appsetting')->whereName('kodepos')->first()->value;	    
		$telp = \DB::table('appsetting')->whereName('telp')->first()->value;	    
		$email = \DB::table('appsetting')->whereName('email')->first()->value;	    

		$pdfOpt = new \Codedge\Fpdf\Fpdf\FPDF($req->orientasi,'mm','A4');
		$pdfOpt->AddPage();
		$pdfOpt->setMargins(10,10,10);
		$pdfOpt->SetAutoPageBreak(false,10);
	    $pdfOpt->SetXY(8,8);

		// // image logo
		// $pdfOpt->image('img/' . \DB::table('appsetting')->whereName('logo')->first()->value,8,8,50);
		// // header text
	 //    $pdfOpt->SetFont('Arial', 'B', 8);
	 //    $pdfOpt->Cell(55, 4,null,0,0,'L',false );
	 //    $pdfOpt->Cell(50, 4,$company_name,0,2,'L',false );
	 //    $y = $pdfOpt->GetY();
	 //    $pdfOpt->SetFont('Arial', null, 8);
	 //    $pdfOpt->SetTextColor(0,0,0);
	 //    $pdfOpt->Cell(50, 4,$alamat,0,2,'L',false );
	 //    $x = 0;
	 //    $pdfOpt->Cell(50, 4,$alamat_2 ,0,2,'L',false );
	 //    $pdfOpt->Cell(50, 4,'T. ' . $telp .' | ' . 'E. ' . $email ,0,2,'L',false );
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
	    $pdfOpt->Cell($pdfOpt->GetPageWidth()/2-8-32,5, 'REKAPITULASI DATA PEMESANAN LAIN',0,0,'L',false);

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

	    if($req->keterangan != ""){
	    	if($idx_header == 1 || $idx_header == 3) $pdfOpt->SetX(8);
		    
		    $pdfOpt->SetFont('Arial', 'B', 8);
		    $pdfOpt->Cell(30,5,'KETERANGAN',0,0,'L',false);
		    $pdfOpt->Cell(2,5,':',0,0,'L',false);
		    $pdfOpt->SetFont('Arial', null, 8);
		    $pdfOpt->Cell($pdfOpt->GetPageWidth()/2-8-32,5, $req->keterangan != "" ? $req->keterangan : '-',0,0,'L',false);


		    if($idx_header == 2 ){
		    	$pdfOpt->Ln(5);
		    }
		    $idx_header++;
		    $option_sampek_tiga_baris = true;
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
		$width_nomor_invoice = 10/100 * $content_width -1;
		$width_tanggal_cetak = 10/100 * $content_width -1;
		$width_keterangan = 29/100 * $content_width -1;
		$width_harga_satuan = 13/100 * $content_width -1;
		$width_jumlah = 7/100 * $content_width -1;
		$width_subtotal = 13/100 * $content_width - 1;
		$width_total = 13/100 * $content_width ;
		
		$col_heider_height  = 10;
		$col_height  = 8;

		$pdfOpt->Ln(5);
	    $pdfOpt->SetX(8);
	    $pdfOpt->SetTextColor(255,255,255);
	    $pdfOpt->SetFont('Arial', 'B', 7);

	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($width_no,$col_heider_height,'NO',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(4,82,127);
	    $x_nomor_invoice = $pdfOpt->GetX();
	    $y_nomor_invoice = $pdfOpt->GetY();
	    if($pdfOpt->GetStringWidth('NOMOR INVOICE') > $width_nomor_invoice){
		    $pdfOpt->Cell($width_nomor_invoice,$col_heider_height,null,0,0,'C',true);
		    $pdfOpt->SetXY($x_nomor_invoice,$y_nomor_invoice+2);
		    $pdfOpt->MultiAlignCell($width_nomor_invoice,$col_heider_height/2-2,'NOMOR INVOICE',0,0,'C',true);
		    $pdfOpt->SetXY($pdfOpt->GetX(),$y_nomor_invoice);
	    	
	    }else{
	    	$pdfOpt->Cell($width_nomor_invoice,$col_heider_height,'NOMOR INVOICE',0,0,'C',true);
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
	    $pdfOpt->Cell($width_keterangan,$col_heider_height,'KETERANGAN',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

		$pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($width_harga_satuan,$col_heider_height,'HARGA SATUAN',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($width_jumlah,$col_heider_height,'JUMLAH',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($width_subtotal,$col_heider_height,'SUBTOTAL',0,0,'C',true);
	    $pdfOpt->SetFillColor(255,255,255);
	    $pdfOpt->Cell($width_separator,$col_heider_height,null,0,0,'C',true);

	    $pdfOpt->SetFillColor(0,0,0);
	    $pdfOpt->Cell($width_total,$col_heider_height,'TOTAL',0,2,'C',true);

	       // LINE PUTIH
	    $pdfOpt->SetX(8);
	    $y = $pdfOpt->GetY();
	    $pdfOpt->SetFillColor(4,82,127);

	    $pdfOpt->Cell($content_width,1,null,0,2,'C',false);
	    $pdfOpt->SetY($y);
	    $pdfOpt->SetX(8 + $width_no + 1);
	    $pdfOpt->Cell($width_nomor_invoice,1,null,0,0,'C',true);
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
	    $pdfOpt->SetX(8 );
	    $pdfOpt->SetTextColor(0,0,0);
	    $pdfOpt->SetFont('Arial', null, 7);
    	$subtotal_harga=0;
    	$rownum=1;
        $rowdt = 1; 
        foreach($data as $dt){
             $oddeven = $rowdt & 1 ? 'row-odd' : 'row-even'; 
             $rowpg=1; 
            
            $y_per_row_tamu = $pdfOpt->GetY();
            foreach($dt->data_detail as $dpg){

            	// cek new page
            	if($pdfOpt->GetY()+(count($dt->data_detail)*$col_height) >= ($pdfOpt->GetPageHeight()-10) ){
            		$pdfOpt->AddPage();
            		$pdfOpt->SetXY(8,10);
            		$y_per_row_tamu = 10;
            	}

            	$pdfOpt->SetX(8 );
            	$min_tanggal_cetak = str_replace('-','/',$dt->tgl_cetak_formatted);

            			$page_y_height = $pdfOpt->GetY() . '  -  ' . $pdfOpt->GetPageHeight();
                    
                        if(count($dt->data_detail) > 1){
                            if($rowpg == 1){
                            	$pdfOpt->Cell($width_no,$col_height *count($dt->data_detail),$rownum++ ,0,0,'C',false);
            					$pdfOpt->Cell($width_separator,$col_height*count($dt->data_detail),null,0,0,'C',false);

                                $pdfOpt->Cell($width_nomor_invoice,$col_height*count($dt->data_detail),$dt->inv_num,0,0,'C',false);
                                $pdfOpt->Cell($width_separator,$col_height*count($dt->data_detail),null,0,0,'C',false);

                                $pdfOpt->Cell($width_tanggal_cetak,$col_height*count($dt->data_detail),$min_tanggal_cetak,0,0,'C',false);
                                $pdfOpt->Cell($width_separator,$col_height*count($dt->data_detail),null,0,0,'C',false);
                                
                            }
                        }else{
                        	$pdfOpt->Cell($width_no,$col_height,$rownum++ ,0,0,'C',false);
            				$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);

                            $pdfOpt->Cell($width_nomor_invoice,$col_height,$dt->inv_num,0,0,'C',false);
                            $pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                            
                            $pdfOpt->Cell($width_tanggal_cetak,$col_height,$min_tanggal_cetak,0,0,'C',false);
                            $pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                        }
                        
                        $pdfOpt->SetXY(8+$width_no+$width_nomor_invoice + $width_tanggal_cetak+3,$y_per_row_tamu);

                        $keterangan = $dpg->keterangan;
                        	$pdfOpt->Cell($width_keterangan,$col_height,$keterangan,0,0,'L',false);
                        	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);
                      

                        
                    	$pdfOpt->Cell(3,$col_height,'Rp.',0,0,'L',false);
                    	$pdfOpt->Cell($width_harga_satuan - 3,$col_height, number_format($dpg->harga_satuan,2,'.',','),0,0,'R',false);
                    	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);

                    	$pdfOpt->Cell($width_jumlah,$col_height,$dpg->jumlah,0,0,'C',false);
                    	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);

                    	$pdfOpt->Cell(3,$col_height,'Rp.',0,0,'L',false);
                    	$pdfOpt->Cell($width_subtotal-3,$col_height,number_format($dpg->jumlah * $dpg->harga_satuan,2,'.',','),0,0,'R',false);
                    	$pdfOpt->Cell($width_separator,$col_height,null,0,0,'C',false);

                    	if(count($dt->data_detail) > 1){
                            if($rowpg == 1){
                            	$pdfOpt->Cell(3,$col_height *count($dt->data_detail),'Rp.',0,0,'L',false);
                            	$pdfOpt->Cell($width_total-3,$col_height *count($dt->data_detail),number_format($dt->total,2,'.',',') ,0,0,'R',false);
                            	$subtotal_harga += $dt->total;
                            }
                        }else{
                        	$pdfOpt->Cell(3,$col_height,'Rp.',0,0,'L',false);
                        	$pdfOpt->Cell($width_total-3,$col_height,number_format($dt->total,2,'.',',') ,0,0,'R',false);
                        	$subtotal_harga += $dt->total;
                        }
                        	
                       
                        $pdfOpt->Ln($col_height);
                        $y_per_row_tamu = $y_per_row_tamu+$col_height;

                        if(count($dt->data_detail) > 1){
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
	    $subtotal_height = 10;
	    $pdfOpt->SetFont('Arial', 'B', 12);
	    $pdfOpt->Ln(5);	    
	    $pdfOpt->SetX(0);
	    $pdfOpt->SetX( 8 + $width_no + $width_separator + $width_nomor_invoice + $width_separator  + $width_separator + $width_tanggal_cetak + $width_separator + $width_keterangan + $width_separator );
	    $pdfOpt->SetFillColor(4,82,127);
	    $pdfOpt->SetTextColor(255,255,255);
	    $pdfOpt->Cell($width_harga_satuan + $width_jumlah  , $subtotal_height,'TOTAL',0,0,'C',true );
	    $pdfOpt->Cell($width_subtotal + $width_total + 2 , $subtotal_height ,'Rp. ' . number_format($subtotal_harga,2,',','.'),0,2,'C',true );
        // END OF TOTAL

        // TERBILANG
	    $pdfOpt->Ln(5);
	    $pdfOpt->SetX(8);
	    $pdfOpt->SetFont('Arial', 'B', 8);
	    $pdfOpt->SetTextColor(255,255,255);
	    $terbilang =  strtoupper(convertTerbilang($subtotal_harga) . ' Rupiah');
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

	    $pdfOpt->Output('I','Rekapitulasi_data_hotel_'.$req->tanggal_cetak_awal.'-'.$req->tanggal_cetak_akhir  .'.pdf',false);
	    exit;

	}

}
