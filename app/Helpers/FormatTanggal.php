<?php

if (!function_exists('FormatTanggal')) {

    /**
     * description
     *  $tanggal = dd-mm-yyyy
     * @param
     * @return
     */
    function FormatTanggal($tanggal)
    {
    	// generate tanggal
        // generate tanggal_cetak
        $arr_tgl = explode('-',$tanggal);
        // $tanggal_cetak = new \DateTime();
        // $tanggal_cetak->setDate($arr_tgl[2],$arr_tgl[1],$arr_tgl[0]);     

        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        $bulan_angka = $arr_tgl[1];

        $ptn = "/^0/";  // Regex
        $str = $arr_tgl[1]; //Your input, perhaps $_POST['textbox'] or whatever
        $rpltxt = "";  // Replacement string
        $bulan_angka =  preg_replace($ptn, $rpltxt, $str);

        $tanggal_id = $arr_tgl[0] . ' ' . strtoupper($bulan[$bulan_angka]) . ' ' . $arr_tgl[2];
        return $tanggal_id;
    }

    
}
