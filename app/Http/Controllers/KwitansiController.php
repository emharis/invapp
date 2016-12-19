<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class KwitansiController extends Controller
{
	public function index(){
		 $catatan[1] = \DB::table('appsetting')->whereName('inv_catatan_1')->first()->value;
	    $catatan[2] = \DB::table('appsetting')->whereName('inv_catatan_2')->first()->value;
	    $catatan[3] = \DB::table('appsetting')->whereName('inv_catatan_3')->first()->value;
	    $catatan[4] = \DB::table('appsetting')->whereName('inv_catatan_4')->first()->value;
	    $catatan[5] = \DB::table('appsetting')->whereName('inv_catatan_5')->first()->value;
	    $catatan[6] = \DB::table('appsetting')->whereName('inv_catatan_6')->first()->value;
	    $catatan[7] = \DB::table('appsetting')->whereName('inv_catatan_7')->first()->value;

		$setting['logo'] = \DB::table('appsetting')->whereName('logo')->first()->value;
		$setting['company_name'] = \DB::table('appsetting')->whereName('nama_perusahaan')->first()->value;
		$setting['alamat'] = \DB::table('appsetting')->whereName('alamat')->first()->value;	    
		$setting['alamat_2'] = \DB::table('appsetting')->whereName('alamat_2')->first()->value;	    
		$setting['telp'] = \DB::table('appsetting')->whereName('telp')->first()->value;	    
		$setting['email'] = \DB::table('appsetting')->whereName('email')->first()->value;	    

		return view('kwitansi.index',[
				'catatan' => $catatan,	
				'setting' => $setting		
			]);
	}

	public function getTerbilang($number){
		return strtoupper(convertTerbilang($number));
	}

	public function cetak(Request $req){
		
		$company_name = \DB::table('appsetting')->whereName('nama_perusahaan')->first()->value;	    
		$alamat = \DB::table('appsetting')->whereName('alamat')->first()->value;	    
		$alamat_2 = \DB::table('appsetting')->whereName('alamat_2')->first()->value;	    
		$kecamatan = \DB::table('appsetting')->whereName('kecamatan')->first()->value;	    
		$kabupaten = \DB::table('appsetting')->whereName('kabupaten')->first()->value;	    
		$kodepos = \DB::table('appsetting')->whereName('kodepos')->first()->value;	    
		$telp = \DB::table('appsetting')->whereName('telp')->first()->value;	    
		$email = \DB::table('appsetting')->whereName('email')->first()->value;	    

		$pdfKw = new \Codedge\Fpdf\Fpdf\FPDF('L','mm',array(210,99));
		$pdfKw->AddPage();
		$pdfKw->SetMargins(0,0,0);
		$pdfKw->SetAutoPageBreak(true,0);

		$pdfKw->SetXY(8,5);
		// image logo
		$pdfKw->image('img/' . \DB::table('appsetting')->whereName('logo')->first()->value,8,5,50);
	    
		// generate header
	    $pdfKw->SetFont('Arial', 'B', 8);
	    $pdfKw->Cell(55, 4,null,0,0,'L',false );
	    $pdfKw->Cell(50, 4,$company_name,0,2,'L',false );
	    $y = $pdfKw->GetY();
	    $pdfKw->SetFont('Arial', null, 8);
	    $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->Cell(50, 4,$alamat,0,2,'L',false );
	    $x = 0;
    		
	    // $pdfKw->Cell(50, 4,$kecamatan . ', ' . $kabupaten .' ' . $kodepos ,0,2,'L',false );
	    $pdfKw->Cell(50, 4,$alamat_2 ,0,2,'L',false );
	    $pdfKw->Cell(50, 4,'T. ' . $telp .' | ' . 'E. ' . $email ,0,2,'L',false );
	    $y_for_line_under_header = $pdfKw->GetY();

	    // KWITANSI TITEL
	    $pdfKw->SetTextColor(4,82,127);
	    $pdfKw->SetFont('Arial', 'B', 25);
	    // $pdfKw->Cell(110, 15,null,0,0,'L',false );
	    // $pdfKw->SetXY(0,$y);
	    // $pdfKw->Cell(0,10,'KWITANSI     ',0,2,'R',false );
	    $pdfKw->SetXY(10,$y);
	    $pdfKw->Cell($pdfKw->GetPageWidth()-15,10,'KWITANSI',0,2,'R',false );

	    // LINE
	    $pdfKw->SetXY(8,$y_for_line_under_header+5);
	    $pdfKw->SetDrawColor(82,82,86);
	    $pdfKw->Cell(195,1,null,'B',2,'L',false);
	    // $pdfKw->Cell(0,1,null,'B',2,'L',false);

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
	    $pdfKw->Cell(0,5,$req->sudah_terima,0,2,'L',false);
	    // titik titik
	    $pdfKw->SetXY($x,$y+1);
	    $pdfKw->Cell(0,5,'................................................................',0,2,'L',false);

	    $pdfKw->Ln(3);

	    $pdfKw->SetX(10);
		$pdfKw->SetFont('Courier', 'B', 10);
	    $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->Cell(50,5,'BANYAKNYA UANG',0,0,'L',false);
	    $pdfKw->Cell(4,5,':',0,0,'L',false);
	    $pdfKw->SetFont('Courier', null, 10);
	    $uang = str_replace('.','',substr($req->jumlah_uang, 0, -3));
	    $terbilang = strtoupper(convertTerbilang($uang) . ' Rupiah');

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

	    $pdfKw->Ln(3);

	    $pdfKw->SetX(10);
	    $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->SetFont('Courier', 'B', 10);
	    $pdfKw->Cell(50,5,'UNTUK PEMBAYARAN',0,0,'L',false);
	    $pdfKw->Cell(4,5,':',0,0,'L',false);
	    $pdfKw->SetFont('Courier', null, 10);
	    $x = $pdfKw->GetX();
	    $y = $pdfKw->GetY();
	    $pdfKw->MultiAlignCell(145,5,$req->untuk_pembayaran,0,2,'L',false);
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
	    if($req->jumlah_uang != ""){
	    	$uang = str_replace('.','',substr($req->jumlah_uang , 0, -3));
	    	
	    }else{
	    	$uang = 0;
	    }
	    $pdfKw->Cell(42,6,'Rp. ' . number_format($uang,2,',','.'),0,0,'C',true);
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
	    

	    $pdfKw->SetFont('Arial', null, 6);
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
		// generate tanggal
		$tanggal = $req->tanggal;
		$pdfKw->Cell($col_width-6,$col_height_catatan,$req->kota . ', ' . $tanggal,0,2,'R',false);

		$pdfKw->Ln(18);

		$pdfKw->SetX($col_width);
		$pdfKw->SetFont('Arial', 'B', 8);
		$pdfKw->Cell($col_width-6,$col_height_catatan,$req->nama,0,2,'R',false);
		$pdfKw->SetFont('Arial', null, 8);
		$pdfKw->Cell($col_width-6,$col_height_catatan,$company_name,0,2,'R',false);


	    
	    // $pdfKw->Output('I',$data_invoice->inv_num .'_'.date('dmYHis') .'.pdf',false);
	    $pdfKw->Output('I','CetakKwitansi.pdf',false);
	    exit;
	}

	public function cetakKosong(){
		$company_name = \DB::table('appsetting')->whereName('nama_perusahaan')->first()->value;	    
		$alamat = \DB::table('appsetting')->whereName('alamat')->first()->value;	    
		$alamat_2 = \DB::table('appsetting')->whereName('alamat_2')->first()->value;	    
		$kecamatan = \DB::table('appsetting')->whereName('kecamatan')->first()->value;	    
		$kabupaten = \DB::table('appsetting')->whereName('kabupaten')->first()->value;	    
		$kodepos = \DB::table('appsetting')->whereName('kodepos')->first()->value;	    
		$telp = \DB::table('appsetting')->whereName('telp')->first()->value;	    
		$email = \DB::table('appsetting')->whereName('email')->first()->value;	    

		$pdfKw = new \Codedge\Fpdf\Fpdf\FPDF('L','mm',array(210,99));
		$pdfKw->AddPage();
		$pdfKw->SetMargins(0,0,0);
		$pdfKw->SetAutoPageBreak(true,0);

		$pdfKw->SetXY(8,5);
		// image logo
		$pdfKw->image('img/' . \DB::table('appsetting')->whereName('logo')->first()->value,8,5,50);
	    
		// generate header
	    $pdfKw->SetFont('Arial', 'B', 8);
	    $pdfKw->Cell(55, 4,null,0,0,'L',false );
	    $pdfKw->Cell(50, 4,$company_name,0,2,'L',false );
	    $y = $pdfKw->GetY();
	    $pdfKw->SetFont('Arial', null, 8);
	    $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->Cell(50, 4,$alamat,0,2,'L',false );
	    $x = 0;
    		
	    $pdfKw->Cell(50, 4,$alamat_2 ,0,2,'L',false );
	    $pdfKw->Cell(50, 4,'T. ' . $telp .' | ' . 'E. ' . $email ,0,2,'L',false );
	    $y_for_line_under_header = $pdfKw->GetY();

	    // KWITANSI TITEL
	    $pdfKw->SetTextColor(4,82,127);
	    $pdfKw->SetFont('Arial', 'B', 25);
	    $pdfKw->SetXY(10,$y);
	    $pdfKw->Cell($pdfKw->GetPageWidth()-15,10,'KWITANSI',0,2,'R',false );

	    // LINE
	    $pdfKw->SetXY(8,$y_for_line_under_header+5);
	    $pdfKw->SetDrawColor(82,82,86);
	    $pdfKw->Cell(195,1,null,'B',2,'L',false);

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
	    $pdfKw->Cell(0,5,null,0,2,'L',false);
	    // titik titik
	    $pdfKw->SetXY($x,$y+1);
	    $pdfKw->Cell(0,5,'................................................................',0,2,'L',false);

	    $pdfKw->Ln(3);

	    $pdfKw->SetX(10);
		$pdfKw->SetFont('Courier', 'B', 10);
	    $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->Cell(50,5,'BANYAKNYA UANG',0,0,'L',false);
	    $pdfKw->Cell(4,5,':',0,0,'L',false);
	    $pdfKw->SetFont('Courier', null, 10);
	    // $terbilang = strtoupper($data_invoice->terbilang . ' Rupiah');

	    	$x = $pdfKw->GetX();
	    	$y = $pdfKw->GetY();
	    	$pdfKw->MultiAlignCell(140,5,'',0,2,'L',false);
	    	$x_ed = $pdfKw->GetX();
	    	$y_ed = $pdfKw->GetY();

	    	$pdfKw->SetXY($x,$y+1);
	    	$pdfKw->Cell(0,5,'................................................................',0,2,'L',false);
	    	$x = $pdfKw->GetX();
	    	$y = $pdfKw->GetY();
	    	$pdfKw->SetXY($x,$y);
	    	$pdfKw->Cell(0,5,'................................................................',0,2,'L',false);

	    $pdfKw->Ln(3);

	    $pdfKw->SetX(10);
	    $pdfKw->SetTextColor(0,0,0);
	    $pdfKw->SetFont('Courier', 'B', 10);
	    $pdfKw->Cell(50,5,'UNTUK PEMBAYARAN',0,0,'L',false);
	    $pdfKw->Cell(4,5,':',0,0,'L',false);
	    $pdfKw->SetFont('Courier', null, 10);
	    $x = $pdfKw->GetX();
	    $y = $pdfKw->GetY();
	    $pdfKw->MultiAlignCell(145,5,'',0,2,'L',false);
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
	    $pdfKw->SetFillColor(4,82,127);
	    $pdfKw->SetDrawColor(4,82,127);
	    $pdfKw->SetFont('Arial', 'B', 12);
	    $pdfKw->Ln(3);
	    $x_catatan = $pdfKw->GetX();
	    $y_catatan = $pdfKw->GetY();
	    $pdfKw->SetX(11);
	    $pdfKw->Cell(42,6,null,1,0,'C',false);
	    // ----- TOTAL -----------


	    $pdfKw->Ln(10);
	    $pdfKw->SetDrawColor(0,0,0);
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

	    $pdfKw->SetFont('Arial', null, 6);
	    $pdfKw->SetX(8);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_1,0,2,'L',false);	    		
	    $pdfKw->SetFont('Arial', null, 6);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_2,0,2,'L',false); 
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_3,0,2,'L',false);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_4,0,2,'L',false);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_5,0,2,'L',false);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_6,0,2,'L',false);
	    $pdfKw->SetX(8);
	    $pdfKw->SetFont('Arial', null, 6);
	    $pdfKw->Cell($col_width,$col_height_catatan,$catatan_7,0,0,'L',false);

	    $pdfKw->SetXY($col_width,$y_catatan + 2);
	    $pdfKw->SetFont('Arial', null, 8);

	    // col 

		$pdfKw->Cell(($col_width-6)/4,$col_height_catatan,null,null,0,'R',false);
		$pdfKw->Cell(($col_width-6)/4 ,$col_height_catatan,null,'B',0,'R',false);
		$pdfKw->Cell(($col_width-6)/4 - 2,$col_height_catatan,null,'B',0,'R',false);
		$pdfKw->Cell(2,$col_height_catatan,',',0,0,'R',false);
		$pdfKw->Cell(($col_width-6)/4,$col_height_catatan,null,'B',2,'R',false);

		$pdfKw->Ln(18);

		$pdfKw->SetX($col_width);
		$pdfKw->SetFont('Arial', 'B', 8);
		// $pdfKw->Cell($col_width/2,$col_height_catatan,null,0,0,'R',false);
		$y = $pdfKw->GetY();
		$pdfKw->SetXY($col_width,$y-2);
		$pdfKw->Cell(($col_width-6)/4,$col_height_catatan,null,0,0,'R',false);
		$pdfKw->Cell(($col_width-6)/4,$col_height_catatan,null,'B',0,'R',false);
		$pdfKw->Cell(($col_width-6)/4,$col_height_catatan,null,'B',0,'R',false);
		$pdfKw->Cell(($col_width-6)/4,$col_height_catatan,null,'B',2,'R',false);
		$y = $pdfKw->GetY();
		$pdfKw->SetXY($col_width,$y+2);
		$pdfKw->SetFont('Arial', null, 8);
		$pdfKw->Cell($col_width-6,$col_height_catatan,$company_name,0,2,'R',false);

		// exit
	    $pdfKw->Output('I','KwitansiKosong.pdf',false);
	    exit;
	}

}
