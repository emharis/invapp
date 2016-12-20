<?php

if (!function_exists('GeneratePdfHeader')) {

    /**
     * description
     *  $tanggal = dd-mm-yyyy
     * @param
     * @return
     */
    function GeneratePdfHeader(&$pdf, $kworinv = 'inv')
    {
    	$company_name = \DB::table('appsetting')->whereName('nama_perusahaan')->first()->value;	    
		$alamat = \DB::table('appsetting')->whereName('alamat')->first()->value;	    
		$alamat_2 = \DB::table('appsetting')->whereName('alamat_2')->first()->value;	    
		$kecamatan = \DB::table('appsetting')->whereName('kecamatan')->first()->value;	    
		$kabupaten = \DB::table('appsetting')->whereName('kabupaten')->first()->value;	    
		$kodepos = \DB::table('appsetting')->whereName('kodepos')->first()->value;	    
		$telp = \DB::table('appsetting')->whereName('telp')->first()->value;	    
		$email = \DB::table('appsetting')->whereName('email')->first()->value;	    
		// $fax = \DB::table('appsetting')->whereName('fax')->first()->value;	    
		// $website = \DB::table('appsetting')->whereName('website')->first()->value;	 
		$logo = \DB::table('appsetting')->whereName('logo')->first()->value;
    	// image logo
		$pdf->image('img/' . $logo,8,9,45);	    
	    $pdf->SetX(55);
		$pdf->SetFont('Arial', 'B', 8);
	    $pdf->Cell(50, 4,$company_name,0,2,'L',false );
	    $y = $pdf->GetY();
	    $pdf->SetFont('Arial', null, 8);
	    $pdf->SetTextColor(0,0,0);
	    $pdf->Cell(50, 4,$alamat,0,2,'L',false );
	    $x = 0;
	    $pdf->Cell(50, 4,$alamat_2 ,0,2,'L',false );
	    $pdf->Cell(50, 4,'T. ' . $telp .' | ' . 'E. ' . $email ,0,2,'L',false );

	     $y_for_line_under_header = $pdf->GetY() -3;

	    // KWITANSI TITEL
	    // KWITANSI TITEL
	    $pdf->SetTextColor(4,82,127);
	    $pdf->SetFont('Arial', 'B', 25);
	    // $pdf->Cell(110, 15,null,0,0,'L',false );
	    // $pdf->SetXY(0,$y);
	    // $pdf->Cell(0,10,'KWITANSI     ',0,2,'R',false );
	    if($kworinv == 'kw'){
		    $pdf->SetXY(10,$y);
		    $titel = 'KWITANSI';
		    $pdf->Cell($pdf->GetPageWidth()-15,10,$titel,0,2,'R',false );
	    	
	    }elseif($kworinv == 'inv'){

	       	$pdf->SetXY(7,$y);
	    	$pdf->Cell($pdf->GetPageWidth()-14,10,'INVOICE',0,2,'R',false );
	    }else{
	    	// rekapitulasi
	       	$pdf->SetXY(7,$y);
			$pdf->Cell($pdf->GetPageWidth()-14,10,'REKAPITULASI',0,2,'R',false );
	    }


	    // LINE
	    if($kworinv == 'kw'){
		    $pdf->SetXY(8,$y_for_line_under_header+5);
		    $pdf->SetDrawColor(82,82,86);
		    $pdf->Cell(195,1,null,'B',2,'L',false);
	    	
	    }
	    // $pdf->Cell(0,1,null,'B',2,'L',false);
    }

    
}
