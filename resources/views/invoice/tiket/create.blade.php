@extends('layouts.master')

@section('styles')
<link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>
<link href="css/arrow-breadcrumb.css" rel="stylesheet" type="text/css"/>
<style>
    .autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
    .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
    .autocomplete-selected { background: #FFE291; }
    .autocomplete-suggestions strong { font-weight: normal; color: red; }
    .autocomplete-group { padding: 2px 5px; }
    .autocomplete-group strong { display: block; border-bottom: 1px solid #000; }

    .table-row-mid > tbody > tr > td {
        vertical-align:middle;
    }

    input.input-clear {
        display: block; 
        padding: 0; 
        margin: 0; 
        border: 0; 
        width: 100%;
        background-color:#EAF0F8;
        float:right;
        padding-right: 5px;
        padding-left: 5px;
    }

    table.table-tiket-group > tbody > tr:last-child{
        /*border-bottom:dashed 1px darkgray;*/
    }
/*
    table#table-penumpang tbody tr td{
        border:none;
    }*/

    .box .box-header{
        padding-top:0px;
        padding-bottom: 0px;
    }

    .box .box-header h3{
        margin-top: 10px;
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: bold;
        /*padding: 0;*/
    }

    .btn-remove-maskapai, .btn-remove-rute, .btn-reset-rute, .btn-reset-maskapai, .btn-reset-penumpang{
        cursor: pointer;
    }

    /*------------------------------------------------------------------------------*/

    /*.row-input-penumpang{
        border: dashed 1px #A5C8DC;
        border-radius: 5px;
        padding-left: 5px;
        padding-right: 5px;
        padding-bottom: 5px;
        margin-bottom: 5px;
    }

    .row-input-penumpang input,.row-input-penumpang select{
        margin-top:5px;
    }

    .addon-titel-penumpang{
        min-width: 75px;
    }*/

    .row-input-penumpang input,.row-input-penumpang select{
        margin-bottom:5px;
    }

    .row-input-penumpang{
        /*border-bottom: dashed 0.11em #D2D6DE;*/
        padding-bottom: 5px;
    }

    /*----------------------------------------------------------------------------*/
    
    .form-inline .form-group > div.col-xs-8 {
        padding-left: 0;
        padding-right: 0;
    }
    .form-inline label {
        line-height: 34px;
    }
    .form-inline .form-control {
        width: 100%;
    }
    @media (min-width: 768px) {
      .form-inline .form-group {
        margin-bottom: 15px;
      }
    }
         


</style>

@append

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <a href="invoice/tiket" >Invoice Tiket Pesawat</a> <i class="fa fa-angle-double-right" ></i> New
    </h1>
</section>

<!-- Main content -->
<section class="content">

<form id="form_invoice" method="POST" action="invoice/tiket/insert" >

    <div class="box box-solid" id="form-kustomer">
        <div class="box-header with-border" style="padding-top:5px;padding-bottom:5px;" >
            <div class="row" >
                <div class="col-sm-12 col-md-12 col-lg-8 btn-action-group"" >
                    <!-- <div class=" > -->
                        <label style="margin-top: 5px;" > 
                            <h4 style="font-weight: bolder;margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0;" >INVOICE</h4>
                        </label>    
                    <!-- </div> -->
                    
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4 data-counter-widget" >
                    <div class="arrow-breadcrumb-group" >
                         <ul class="arrow-breadcrumb" id="breadcrumbs-two">
                            <li><a  class="current" >Draft</a></li>
                            <li><a >Posted</a></li>
                            <li><a  class=" last-item"></a></li>
                        </ul>                   
                    </div>
                </div>
            </div>
        </div>
        <div class="box-header with-border" >
            
            <h3  style="color:#3C8DBC">DATA KUSTOMER</h3>
        </div>
        <div class="box-body" id="form-input-customer">

            <div class="row" >
                <div class="col-sm-6 col-md-6 col-lg-6" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Nama*</label>
                          <input autocomplete="off" required type="text" class="form-control" placeholder="Nama" name="nama" autofocus maxlength="{{$maxlen_data_kustomer}}" >
                        </div>
                        <div class="form-group">
                          <label>Kantor/Perusahaan</label>
                          <input autocomplete="off" type="text" class="form-control" placeholder="Kantor/Perusahaan" name="kantor" maxlength="{{$maxlen_data_kustomer}}" >
                        </div>

                        <!-- textarea -->
                        <div class="form-group">
                          <label>Telepon/HP*</label>
                          <input autocomplete="off" required type="text" class="form-control" placeholder="Telepon/HP" name="telp" maxlength="{{$maxlen_data_kustomer}}" >
                        </div>
                        <div class="form-group">
                          <label>E-Mail</label>
                          <input autocomplete="off" type="email" class="form-control" placeholder="E-Mail" name="email" maxlength="{{$maxlen_data_kustomer}}" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Alamat</label>
                          <textarea name="alamat" class="form-control" rows="4" placeholder="Alamat" style="resize:none;height: 109px;" maxlength="{{$maxlen_data_kustomer}}" ></textarea>
                        </div>
                        <div class="form-group">
                          <label>Tanggal Cetak*</label>
                          <input autocomplete="off" required type="text" class="form-control input-tanggal" placeholder="Tanggal Cetak" name="tanggal_cetak">
                        </div>

                        <!-- textarea -->
                        <div class="form-group">
                          <label>Tanggal Jatuh Tempo*</label>
                          <input autocomplete="off" required type="text" class="form-control input-tanggal" placeholder="Tanggal Jatuh Tempo" name="jatuh_tempo">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <!-- DATA PEMESANAN -->
    <div class="box box-solid form-pemesanan" >
        <div class="box-header with-border" >
            <h3 style="color:#3C8DBC">DATA PEMESANAN (1)</h3>
            <a href="#" class="pull-right btn-box-tool btn-remove-input-group hide"  ><i class="fa fa-times"></i></a>

        </div>
        <div class="box-body" >
            <div class="form" >
                <div class="col-sm-2 col-md-2 col-lg-2" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Kode Pemesanan*</label>
                          <input autocomplete="off" required type="text" name="kode_pemesanan" class="form-control" placeholder="Kode Pemesanan" maxlength="{{$maxlen_kode_pemesaan*2}}"> 
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-lg-5" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Maskapai*</label>
                          <input autocomplete="off" required type="text" name="maskapai" class="form-control input-maskapai" placeholder="Maskapai" maxlength="{{$maxlen_maskapai*2}}" > 
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-lg-5" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Rute*</label>
                          <div class="row" >
                              <div class="col-sm-6 col-md-6 col-lg-6" >
                                  <input autocomplete="off" required type="text" name="pergi" class="form-control" placeholder="Pergi" style="margin-bottom: 5px;" maxlength="{{$maxlen_rute}}" >
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-6" >
                                  <input autocomplete="off" type="text" name="pulang" class="form-control" placeholder="Pulang" maxlength="{{$maxlen_rute}}" >
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" >
                    <label>Penumpang*</label>
                    <div class="form-horizontal row-input-penumpang-group"  >
                    <!-- </div> -->
                        <div class="form-group row-input-penumpang" >
                            <div class="col-sm-2" >
                                <select required class="form-control input-titel "  name="titel" >
                                    <option value="mr" >Mr</option>
                                    <option value="mrs" >Mrs</option>
                                    <option value="ms" >Ms</option>
                                </select>
                            </div>
                            <div class="col-sm-5" >
                                <input autocomplete="off" required type="text" placeholder="Nama Penumpang" class="form-control " name="nama" value="" maxlength="{{$maxlen_nama_penumpang*2}}" >
                            </div>
                            <div class="col-sm-5" >
                                <div class="input-group" >
                                <input autocomplete="off" required type="text" placeholder="Nomor Tiket" class="form-control " name="nomor_tiket" maxlength="{{$maxlen_nomor_tiket*2}}" >
                                    <div class="input-group-addon"  >
                                        <a href="#" class="btn-add-penumpang" style="color: #00A65A;" ><i class="fa fa-plus-circle" ></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>

                </div>

            </div>
        </div>
        <div class="box-footer" style="margin-top: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;" >
            <div class="col-sm-7 col-md-7 col-lg-7" ></div>
            <div class="col-sm-5 col-md-5 col-lg-5" >
                <div class="form-group">
                  <label  class="">Harga*</label>
                  <!-- <div class="col-sm-4 " > -->
                    <input autocomplete="off" required type="text" name="harga" class="form-control input-harga uang text-right input-lg" style=""  placeholder="Harga">
                  <!-- </div> -->
                </div>  
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-body" >
            <div class="row" >
            <div class="col-sm-12 col-md-12 col-lg-6 data-counter-widget" >
                    <label class="arrow-breadcrumb-group">TOTAL : <span style="font-size: 1.5em;"  id="jumlah-harga" >0</span></label>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 btn-action-group"" >
                    <a class="btn btn-success" id="btn-add-pemesanan" ><i class="fa fa-plus-circle" ></i> Data Pemesanan</a>
                    <button id="btn-save" type="submit" class="btn btn-primary " ><i class="fa fa-save" ></i> Simpan</button>
                    {{-- <a id="btn-save-print"  class="btn btn-warning " ><i class="fa fa-print" ></i> Simpan & Cetak</a> --}}
                    <a id="btn-cancel" href="invoice/tiket" class="btn btn-danger" ><i class="fa fa-close" ></i> Batal</a>
                </div>
                
            </div>

        </div>
    </div>

</form>

</section><!-- /.content -->

<!-- ELEMENT FOR CLONE -->
<div class="hide" id="row-penumpang-for-clone"  >
    <div class="form-group row-input-penumpang" >
        <div class="col-sm-2" >
            <select required class="form-control input-titel " name="titel"  >
                <option value="mr" >Mr</option>
                <option value="mrs" >Mrs</option>
                <option value="ms" >Ms</option>
            </select>
        </div>
        <div class="col-sm-5" >
            <input autocomplete="off" required type="text" placeholder="Nama" class="form-control " name="nama" >
        </div>
        <div class="col-sm-5" >
            <div class="input-group" >
            <input autocomplete="off" required type="text" placeholder="Nomor Tiket" class="form-control " name="nomor_tiket" >
                <div class="input-group-addon" >
                    <a href="#" class="btn-delete-penumpang" style="color:#DD4B39;" ><i class="fa fa-trash" ></i></a>
                </div>
            </div>
        </div>
    </div>
    
</div>

<div class="hide" id="form-pemesanan-for-clone" >
    <div class="box box-solid " >
        <div class="box-header with-border" >
            <h3 style="color:#3C8DBC">DATA PEMESANAN (1)</h3>
            <a href="#" class="pull-right btn-box-tool btn-remove-input-group hide"  ><i class="fa fa-times"></i></a>

        </div>
        <div class="box-body" >
            <div class="form" >
                <div class="col-sm-2 col-md-2 col-lg-2" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Kode Pemesanan*</label>
                          <input autocomplete="off" required type="text" name="kode_pemesanan" class="form-control" placeholder="Kode Pemesanan"> 
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-lg-5" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Maskapai*</label>
                          <input autocomplete="off" required type="text" name="maskapai" class="form-control input-maskapai" placeholder="Maskapai" maxlength="28" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-lg-5" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Rute*</label>
                          <div class="row" >
                              <div class="col-sm-6 col-md-6 col-lg-6" >
                                  <input autocomplete="off" required type="text" name="pergi" class="form-control" placeholder="Pergi" style="margin-bottom: 5px;" maxlength="8" >
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-6" >
                                  <input autocomplete="off" type="text" name="pulang" class="form-control" placeholder="Pulang" maxlength="8" >
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" >
                    <label>Penumpang*</label>
                    <div class="form-horizontal row-input-penumpang-group" >
                    <!-- </div> -->
                        <div class="form-group row-input-penumpang" >
                            <div class="col-sm-2" >
                                <select required class="form-control input-titel " name="titel"  >
                                    <option value="mr" >Mr</option>
                                    <option value="mrs" >Mrs</option>
                                    <option value="ms" >Ms</option>
                                </select>
                            </div>
                            <div class="col-sm-5" >
                                <input autocomplete="off" required type="text" placeholder="Nama Penumpang" class="form-control " name="nama" value="" maxlength="40" >
                            </div>
                            <div class="col-sm-5" >
                                <div class="input-group" >
                                <input autocomplete="off" required type="text" placeholder="Nomor Tiket" class="form-control " name="nomor_tiket" maxlength="32" >
                                    <div class="input-group-addon"  >
                                        <!-- <a href="#" class="btn-reset-penumpang" ><i class="fa fa-history" ></i></a> -->
                                        <a href="#" class="btn-add-penumpang" style="color: #00A65A;" ><i class="fa fa-plus-circle" ></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>

                </div>
            </div>
        </div>
        <div class="box-footer" style="margin-top: 0;margin-bottom: 0;padding-top: 0;padding-bottom: 0;" >
            <div class="col-sm-7 col-md-7 col-lg-7" ></div>
            <div class="col-sm-5 col-md-5 col-lg-5" >
                <div class="form-group">
                  <label  class="">Harga*</label>
                  <!-- <div class="col-sm-4 " > -->
                    <input autocomplete="off" type="text" name="harga" class="form-control input-harga uang text-right input-lg" style=""  placeholder="Harga">
                  <!-- </div> -->
                </div>  
            </div>
        </div>
    </div>
</div>

<!-- END OF ELEMENT FOR CLONE -->


@stop

@section('scripts')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/jqueryform/jquery.form.min.js" type="text/javascript"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="plugins/autocomplete/jquery.autocomplete.min.js" type="text/javascript"></script>
<script src="plugins/autonumeric/autoNumeric-min.js" type="text/javascript"></script>

<script type="text/javascript">
(function ($) {
    $('textarea').bind('keypress', function(e) {
      if ((e.keyCode || e.which) == 13) {
        $(this).parents('form').submit();
        return false;
      }
    });
    
    // SET DATEPICKER
    $('.input-tanggal').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true
    }).on('changeDate', function(){
        var trigger = $(this);
        var input_tgl_cetak = $('input[name=tanggal_cetak]');
        if(trigger.is(input_tgl_cetak)){
            // $('input[name=jatuh_tempo]').val($(this).val());

            // set min date
            $('input[name=jatuh_tempo]').datepicker('setStartDate',$(this).datepicker('getDate'));
            // set current date
            $('input[name=jatuh_tempo]').datepicker('setDate',$(this).datepicker('getDate'));
        }
    });

    // END OF SET DATEPICKER

    // -----------------------------------------------------
    // SET AUTO NUMERIC
    // =====================================================
    $('.uang').autoNumeric('init',{
        vMin:'0.00',
        vMax:'9999999999.00',
        aSep: '.',
        aDec: ',', 
    });

    $('#jumlah-harga').autoNumeric('init',{
        vMin:'0.00',
        vMax:'9999999999.00',
        aSep: '.',
        aDec: ',', 
        aSign: 'Rp. '
    });
    // END OF AUTONUMERIC

    // FUNGSI REORDER ROWNUMBER
    function rownumReorder(){
        var rownum=1;
        $('#table-product > tbody > tr.row-product').each(function(){
            $(this).children('td:first').text(rownum++);
        });
    }
    // END OF FUNGSI REORDER ROWNUMBER

    // REMOVE FORM INPUT GROUP
    $(document).on('click','.btn-remove-input-group',function(){

        if(confirm('Anda akan menghapus data ini?')){
            var form_group = $(this).parent();
            form_group.slideUp(250,function(){
                form_group.remove();    
            });
        }
        
        return false;
    });
    // END REMOVE FORM INPUT GROUP

    // REMOVE PENUMPANG
    $(document).on('click','.btn-delete-penumpang',function(){
        // if(confirm('Anda akan menghapus data ini?')){
            var row = $(this).parent().parent().parent().parent();
            row.fadeOut(350,function(){
                row.remove();
            });
        // }

        return false;
    });
    // END REMOVE PENUMPAN

    // ADD PENUMPANG
    $(document).on('click','.btn-add-penumpang',function(){
        var row_input_penumpang = $('#row-penumpang-for-clone').clone();
        var btn_add_penumpang = $(this);
        var form_penumpang = btn_add_penumpang.parent().parent().parent().parent().parent();

        form_penumpang.children('div:last').after(row_input_penumpang.html());

        // set autocomplete nama
        setAutoCompleteNama();

        return false;
    });
    // END OF ADD PENUMPANG

    // AUTOCOMPLETE MASKAPAI

    function setAutoCompleteMaskapai(){
        var input_maskapai = $('.input-maskapai');
        input_maskapai.autocomplete({
            serviceUrl: 'api/get-auto-complete-maskapai',
            params: {  
                        'nama' : function() {
                                    return input_maskapai.val();
                                },
                    },
            onSelect:function(suggestions){
                // $(this).attr('data-maskapaiid',suggestions.data);
                // $(this).attr('readonly','readonly');
                $(this).parent().next().children('input').focus();
            }
        });

        $(document).on('keyup','.input-maskapai',function() {
            // alert('pret');
            var nama = $(this).val();
            $(this).autocomplete().setOptions({
                params: { nama: nama }
            });
        });    
    }
    setAutoCompleteMaskapai();
    

    // END OF AUTOCOMPLETE MASKAPAI

    // AUTOCOMPLETE NAMA INVOICE
    function setAutoCompleteNama(){
        var input_nama = $('input[name=nama]');

        input_nama.autocomplete({
            serviceUrl: 'api/get-auto-complete-nama',
            params: {  
                        'nama' : function() {
                                    return input_nama.val();
                                },
                    },
            onSelect:function(suggestions){
            }
        });   

        $(document).on('keyup','input[name=nama]',function() {
            // alert('pret');
            var nama = $(this).val();
            $(this).autocomplete().setOptions({
                params: { nama: nama }
            });
        }); 
    }
    setAutoCompleteNama();

    // END OF AUTOCOMPLETE NAMA INVOICE

    // SET AUTOCOMPLETE EMAIL
    function setAutoCompleteEmail(){
        var input_data = $('input[name=email]');

        input_data.autocomplete({
            serviceUrl: 'api/get-auto-complete-email',
            params: {  
                        'nama' : function() {
                                    return input_data.val();
                                },
                    },
            onSelect:function(suggestions){
            }
        });   

        $(document).on('keyup','input[name=email]',function() {
            // alert('pret');
            var nama = $(this).val();
            $(this).autocomplete().setOptions({
                params: { nama: nama }
            });
        }); 
    }
    setAutoCompleteEmail();

    // SET AUTOCOMPLETE KANTOR
    function setAutoCompleteKantor(){
        var input_data = $('input[name=kantor]');

        input_data.autocomplete({
            serviceUrl: 'api/get-auto-complete-kantor',
            params: {  
                        'nama' : function() {
                                    return input_data.val();
                                },
                    },
            onSelect:function(suggestions){
            }
        });   

        $(document).on('keyup','input[name=kantor]',function() {
            // alert('pret');
            var nama = $(this).val();
            $(this).autocomplete().setOptions({
                params: { nama: nama }
            });
        }); 
    }
    setAutoCompleteKantor();

    // // HITUNG TOTAL
    $(document).on('keyup','.input-harga',function(){
       hitungTotal();
    });
    

    // FUNGSI HITUNG TOTAL KESELURUHAN
    function hitungTotal(){
        // var disc = $('input[name=disc]').autoNumeric('get');
        $('#total-harga').text('pret');
        var total = 0;
        // $('.input-harga-on-row').each(function(){
        //     // alert('harga');
        //     var harga = $(this).autoNumeric('get');
        //     total = Number(total) + Number(harga);
        // });  

        $('.input-harga').each(function(){
            harga  = Number($(this).autoNumeric('get'));
            // alert('ok');
            total= Number(total)+Number(harga);

        });      

        $('#jumlah-harga').autoNumeric('set',total);
        // $('#total-harga').autoNumeric('set',total);

        // alert(total);

        // tampilkan subtotal dan total
        // $('#total-harga').autoNumeric('set',total);
        // $('#total-harga').text(total);
    }
    // END OF FUNGSI HITUNG TOTAL KESELURUHAN

    // DELETE ROW PRODUCT
    $(document).on('click','.btn-delete-row-product',function(){
        var row = $(this).parent().parent();
        row.fadeOut(250,null,function(){
            row.remove();
            // reorder row number
            rownumReorder();
            // hitung total
            hitungTotal();
        });

        return false;
    });
    // END OF DELETE ROW PRODUCT

    // submitting form
    $('#form_invoice').submit(function(){

        var can_save = true;
        // cek kelengkapan data
        var inv_master = {"nama":"",
                         "kantor":"",
                         "alamat":"",
                         "telp":"",
                         "email":"",
                         "tanggal_cetak":"",
                         "jatuh_tempo":"",
                         "total":"",
                         "terbilang":""
                     };
        // set inv_master data
        inv_master.nama = $('#form-kustomer').find('input[name=nama]').val();
        inv_master.kantor = $('#form-kustomer').find('input[name=kantor]').val();
        inv_master.alamat = $('#form-kustomer').find('textarea[name=alamat]').val();
        inv_master.telp = $('#form-kustomer').find('input[name=telp]').val();
        inv_master.email = $('#form-kustomer').find('input[name=email]').val();
        inv_master.tanggal_cetak = $('#form-kustomer').find('input[name=tanggal_cetak]').val();
        inv_master.jatuh_tempo = $('#form-kustomer').find('input[name=jatuh_tempo]').val();
        inv_master.total = $('#jumlah-harga').autoNumeric('get');


        // alert('master set done');
        if(inv_master.nama == "" || inv_master.tanggal_cetak == "" || inv_master.jatuh_tempo == "" || inv_master.telp == ""){
            can_save = false;
        }


        // get data barang;
        var inv_tiket = JSON.parse('{"tiket" : [] }');

        // set data tiket detail        
        $('.form-pemesanan').each(function(){
            // var first_col = $(this).find('input[name=kode_pemesanan]').val();

            var kode_pemesanan = $(this).find('input[name=kode_pemesanan]').val();
            var maskapai = $(this).find('input[name=maskapai]').val();
            var maskapai_id = $(this).find('input[name=maskapai]').data('maskapaiid');
            var pergi = $(this).find('input[name=pergi]').val();
            var pulang = $(this).find('input[name=pulang]').val();
            var harga = $(this).find('input[name=harga]').autoNumeric('get');
            var penumpang = JSON.parse('{"penumpang" : [] }');

           if(kode_pemesanan == "" || maskapai == "" || maskapai_id == "" || pergi == "" || harga == ""){
            can_save = false;
           }

            // $(this).find('.row-input-penumpang-group').children('.row-input-penumpang').each(function(){
            //     alert('ok');
            // });
            // alert('finding');
            var row_penumpang_group = $(this).find('.row-input-penumpang-group');
            row_penumpang_group.find('.row-input-penumpang').each(function(){
               // // add penumpang
                var titel = $(this).find('select[name=titel]').val();
                var nama = $(this).find('input[name=nama]').val();
                var no_tiket = $(this).find('input[name=nomor_tiket]').val();

               penumpang.penumpang.push({
                        titel : titel,//$(this).find('select[name=titel]').val(),
                        nama : nama,//$(this).find('input[name=nama]').val(),
                        no_tiket : no_tiket//$(this).find('input[name=nomor_tiket]').val()
                        
                    });

               if(titel == "" || nama == "" || no_tiket == ""){
                can_save = false;
               }
               
            });

            inv_tiket.tiket.push({
                        kode_pemesanan : kode_pemesanan,
                        maskapai : maskapai,
                        maskapai_id : maskapai_id,
                        pergi : pergi,
                        pulang : pulang,
                        harga : harga,
                        penumpang: penumpang
                    });
                   
        });
   

        if(can_save){
            $('#btn-save').attr('disabled','disabled');

            if(is_cetak){
                // dengan cetak
                $.post('invoice/tiket/insert',{
                    'inv_master' : JSON.stringify(inv_master),
                    'inv_tiket' : JSON.stringify(inv_tiket),
                    'is_cetak' : true
                },function(res){
                    // alert(res);
                    window.open('invoice/tiket/cetak-tiket/'+res, '_blank');
                    location.href = "invoice/tiket";
                });
            }else{
                // tanpa cetak
                var newform = $('<form>').attr('method','POST').attr('action','invoice/tiket/insert');
                newform.append($('<input autocomplete="off">').attr('type','hidden').attr('name','inv_master').val(JSON.stringify(inv_master)));
                newform.append($('<input autocomplete="off">').attr('type','hidden').attr('name','inv_tiket').val(JSON.stringify(inv_tiket)));
                newform.submit();    
            }

            
                // alert('submitting');
        }else{
            alert('Lengkapi data yang kosong.');
        }
        
        return false;
    });

    

    // RESET MASKAPAI
    $(document).on('click','.btn-reset-maskapai',function(){
        var input_maskapai = $(this).parent().prev();
        input_maskapai.val('');
        input_maskapai.data('maskapaiid','');
        input_maskapai.removeAttr('readonly');
        input_maskapai.focus();
    });
    // END RESET MASKAPAI

    // RESET RUTE
    $(document).on('click','.btn-reset-rute',function(){
        var input_rute_pulang = $(this).parent().prev().children('input');
        var input_rute_pergi = $(this).parent().prev().prev().children('input');
        is_sj = input_rute_pulang.attr('readonly') !== undefined;
        if(!is_sj){
            input_rute_pulang.val('');
        }
        input_rute_pergi.val('');        
        input_rute_pergi.focus();
    });
    // END RESET RUTE

    // RESET PENUMPANG
    $(document).on('click','.btn-reset-penumpang',function(){
        var row_penumpang = $(this).parent().parent().parent().parent();
        // row_penumpang.children('td:first').next().children('input').val('');
        // row_penumpang.children('td:first').next().next().children('input').val('');
        row_penumpang.find('input:text').val('');
        row_penumpang.find('select').val('mr');
        row_penumpang.find('input:first').focus();
        // row_penumpang.children('td:first').hide();

        return false;
    });
    // END OF RESET PENUMPANG

    // BTN COPY

    // --------------- ADD MASKAPAI ----------------------
    $(document).on('click','.btn-add-maskapai',function(){
        var btn = $(this);
        btn.parent('td').parent('tr').before('<tr class="row-maskapai" ><td><input autocomplete="off" type="text" placeholder="Maskapai" class="form-control  input-maskapai" ></td><td style="width: 25px;" ><a class="btn-remove-maskapai" ><i class="fa fa-trash" ></i></a></td></tr>');

        // autocomplete maskapai
        var input_maskapai = btn.parent('td').parent('tr').prev().children('td:first').children('input'); //form_pemesanan.find('input.input-maskapai');
         input_maskapai.autocomplete({
            serviceUrl: 'api/get-auto-complete-maskapai',
            params: {  
                        'nama' : function() {
                                    return input_maskapai.val();
                                },
                    },
            onSelect:function(suggestions){
                $(this).attr('data-maskapaiid',suggestions.data);
                // $(this).attr('readonly','readonly');
                // $(this).parent().next().children('input').focus();
            }
        });

         // fokuskan
         input_maskapai.focus();


    });
    // --------------- END ADD MASKAPAI ----------------------

   

    $(document).on('change','input[name=perjalanan]',function(){
        var form_pemesanan = $(this).parent('label').parent('div').parent('div').parent('div').parent('td').parent('tr').parent('tbody').parent('table').parent('div').parent();

        if($(this).val() == 'SJ' ) {
            form_pemesanan.find('input.input-pergi').removeAttr('readonly');
            form_pemesanan.find('input.input-pulang').attr('readonly','readonly');
            form_pemesanan.find('input.input-pulang').val('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
        }else{
            // if PP
            form_pemesanan.find('input.input-pergi').removeAttr('readonly');
            form_pemesanan.find('input.input-pulang').removeAttr('readonly');
            form_pemesanan.find('input.input-pulang').val('');
        }
    });
    // ---------------- END PERJALANAN CHANGE --------------------

    // ----------------- REMOVE MASKAPAI -------------------------
    $(document).on('click','.btn-remove-maskapai',function(){
        // if(confirm('Anda akan menghapus data ini?')){
            var row = $(this).parent().parent();
            row.fadeOut(350,function(){
                row.remove();
            });
        // }
        

        return false;
    });
    // ----------------- END REMOVE MASKAPAI -------------------------

    // ----------------- REMOVE RUTE -------------------------
    $(document).on('click','.btn-remove-rute',function(){
        // if(confirm('Anda akan menghapus data ini?')){
            var row = $(this).parent().parent();
            row.fadeOut(350,function(){
                row.remove();
            });
        // }
        

        return false;
    });
    // ----------------- END REMOVE RUTE -------------------------

    // ----------------- ADD FORM PEMESANAN ----------------------
    var form_pemesanan_index = 1;
    $('#btn-add-pemesanan').click(function(){

        // add form pemesanan
        // var form_pemesanan = $('#form-pemesanan-for-clone').children('div').clone().insertAfter($(this).parent().parent().parent());
        var form_pemesanan = $('#form-pemesanan-for-clone').children('div').clone().insertBefore($(this).parent().parent().parent().parent());

        // set title form pemesanan
        form_pemesanan_index++;
        form_pemesanan.children('div:first').children('h3').text('DATA PEMESANAN ('+form_pemesanan_index+')');

        // add class
        form_pemesanan.addClass('form-pemesanan');

        // animate
        form_pemesanan.hide();
        form_pemesanan.slideDown(300);

        setAutoCompleteMaskapai();
        setAutoCompleteNama();

        // auto numeric input-harga
        form_pemesanan.find('input.input-harga').autoNumeric('init',{
            vMin:'0.00',
            vMax:'9999999999.00',
            aSep: '.',
            aDec: ',', 
        });
        

        // add close button
        form_pemesanan.children('div:first').append('<div class="pull-right box-tools" ><a href="#" class="btn-remove-form-pemesanan" ><i class="fa fa-close" ></i></a></div>');

         $('html, body').animate({
                scrollTop: form_pemesanan.offset().top
            }, 1500,null,function(){
                // focuskan ke input kode pemesanan
                form_pemesanan.find('input[name=kode_pemesanan]').focus();
            });




       return false;
    });
    // ----------------- END ADD FORM PEMESANAN ----------------------

    // ------------------ REMOVE FORM PEMESANAN ----------------------
    $(document).on('click','.btn-remove-form-pemesanan',function(){

        if(confirm('Anda akan menghapus data ini?')){
            var form_pemesanan = $(this).parent('div').parent('div').parent('div');

            form_pemesanan_upper = form_pemesanan.prev();

            // // pindahkan button add pemesanan
            // var btn_add_pemesanan = form_pemesanan.children('div:last').children('a');
            // btn_add_pemesanan.fadeOut(250);            

            form_pemesanan.slideUp(1000,function(){
                // pindahkan btn add pemesanan
                form_pemesanan_upper.children('div:last').append(btn_add_pemesanan);
                btn_add_pemesanan.show();

                // remove form_pemesanan
                form_pemesanan.remove();

                // reorder form pemesanan number
                form_pemesanan_index = 1;
                $('.form-pemesanan').each(function(){
                    $(this).children('div:first').children('h3').text('DATA PEMESANAN (' + form_pemesanan_index + ')');
                    form_pemesanan_index++;
                });



            });
        }

        

        return false;
    });
    // ------------------ END REMOVE FORM PEMESANAN ----------------------


    var is_cetak = false;
    // -------------- SIMPAN & CETAK ---------------------------------
    $('#btn-save-print').click(function(){
        is_cetak =true;
        $('#form_invoice').submit();
        return false;
    })
    // ----------------------------------------------------------------


})(jQuery);
</script>
@append