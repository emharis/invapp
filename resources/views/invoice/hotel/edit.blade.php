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

    table.table-hotel-group > tbody > tr:last-child{
        /*border-bottom:dashed 1px darkgray;*/
    }
/*
    table#table-tamu tbody tr td{
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

    .btn-remove-hotel, .btn-remove-rute, .btn-reset-rute, .btn-reset-hotel, .btn-reset-tamu{
        cursor: pointer;
    }

    /*------------------------------------------------------------------------------*/

    /*.row-input-tamu{
        border: dashed 1px #A5C8DC;
        border-radius: 5px;
        padding-left: 5px;
        padding-right: 5px;
        padding-bottom: 5px;
        margin-bottom: 5px;
    }

    .row-input-tamu input,.row-input-tamu select{
        margin-top:5px;
    }

    .addon-titel-tamu{
        min-width: 75px;
    }*/

    .row-input-tamu input,.row-input-tamu select{
        margin-bottom:5px;
    }

    .row-input-tamu{
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
        <a href="invoice/hotel" >Invoice Reservasi Hotel </a> <i class="fa fa-angle-double-right" ></i> {{$data->inv_num}}
    </h1>
</section>

<!-- Main content -->
<section class="content">

<form id="form_invoice" method="POST" action="invoice/hotel/update" >
    <input type="hidden" name="invoice_hotel_id" value="{{$data->id}}">
    <div class="box box-solid" id="form-kustomer">
        <div class="box-header with-border" style="padding-top:5px;padding-bottom:5px;" >
            <div class="row" >
                <div class="col-sm-12 col-md-12 col-lg-8 btn-action-group"" >
                    <!-- <div class=" > -->
                        <label style="margin-top: 5px;" > 
                            <h4 style="font-weight: bolder;margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0;" >EDIT INVOICE : <i>{{$data->inv_num}}</i></h4>
                        </label>    
                    <!-- </div> -->
                    
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4 data-counter-widget" >
                    <div class="arrow-breadcrumb-group" >
                         <ul class="arrow-breadcrumb" id="breadcrumbs-two">
                            <li><a   >Draft</a></li>
                            <li><a class="current" >Posted</a></li>
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
                          <input autocomplete="off" required type="text" class="form-control" placeholder="Nama" name="nama" value="{{$data->nama}}" autofocus >
                        </div>
                        <div class="form-group">
                          <label>Kantor/Perusahaan</label>
                          <input autocomplete="off" type="text" class="form-control" placeholder="Kantor/Perusahaan" name="kantor" value="{{$data->kantor}}" >
                        </div>

                        <!-- textarea -->
                        <div class="form-group">
                          <label>Telepon/HP*</label>
                          <input autocomplete="off" required type="text" class="form-control" placeholder="Telepon/HP" name="telp" value="{{$data->telp}}" >
                        </div>
                        <div class="form-group">
                          <label>E-Mail</label>
                          <input autocomplete="off" type="email" class="form-control" placeholder="E-Mail" name="email" value="{{$data->email}}">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Alamat</label>
                          <textarea name="alamat" class="form-control" rows="4" placeholder="Alamat" style="resize:none;height: 109px;" >{{$data->alamat}}</textarea>
                        </div>
                        <div class="form-group">
                          <label>Tanggal Cetak*</label>
                          <input autocomplete="off" required type="text" class="form-control input-tanggal" placeholder="Tanggal Cetak" name="tanggal_cetak" value="{{$data->tgl_cetak_formatted}}" >
                        </div>

                        <!-- textarea -->
                        <div class="form-group">
                          <label>Tanggal Jatuh Tempo*</label>
                          <input autocomplete="off" required type="text" class="form-control input-tanggal" placeholder="Tanggal Jatuh Tempo" name="jatuh_tempo" value="{{$data->jatuh_tempo_formatted}}" >
                        </div>
                        
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <!-- DATA PEMESANAN -->
    <?php $dps_idx=1; ?>
    @foreach($data->data_pemesanan as $dps)

    <div class="box box-solid form-pemesanan" >
        <div class="box-header with-border" >
            <h3 style="color:#3C8DBC">DATA PEMESANAN ({{$dps_idx}})</h3>
            <a href="#" class="pull-right btn-box-tool btn-remove-input-group hide"  ><i class="fa fa-times"></i></a>

        </div>
        <div class="box-body" >
            <div class="form" >
                <div class="col-sm-2 col-md-2 col-lg-2" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Kode Pemesanan*</label>
                          <input autocomplete="off" required type="text" name="kode_pemesanan" class="form-control" placeholder="Kode Pemesanan" value="{{$dps->kode_pemesanan}}"> 
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-lg-5" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Hotel*</label>
                          <input autocomplete="off" required type="text" name="hotel" class="form-control input-hotel" placeholder="Hotel" value="{{$dps->hotel}}"> 
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-lg-5" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Durasi*</label>
                          <div class="row" >
                              <div class="col-sm-6 col-md-6 col-lg-6" >
                                  <input autocomplete="off" required type="text" name="check_in" class="form-control" placeholder="Check In" style="margin-bottom: 5px;" value="{{$dps->check_in_formatted}}" >
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-6" >
                                  <input autocomplete="off" type="text" name="check_out" class="form-control" placeholder="Check Out" value="{{$dps->check_out_formatted}}" >
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" >
                    <label>Tamu*</label>
                    <div class="form-horizontal row-input-tamu-group"  >

                        <?php $dtm_idx=1;?>
                        @foreach($dps->data_tamu as $dtm)

                        <div class="form-group row-input-tamu" >
                            <div class="col-sm-2" >
                                <select required class="form-control input-titel "  name="titel" >
                                    <option value="mr" {{$dtm->titel == 'mr' ? 'selected' :''}} >Mr</option>
                                    <option value="mrs" {{$dtm->titel == 'mrs' ? 'selected' :''}} >Mrs</option>
                                    <option value="ms" {{$dtm->titel == 'ms' ? 'selected' :''}} >Ms</option>
                                </select>
                            </div>
                            <div class="col-sm-5" >
                                <input autocomplete="off" required type="text" placeholder="Nama Tamu" class="form-control " name="nama" value="{{$dtm->nama}}" >
                            </div>
                            <div class="col-sm-5" >
                                <div class="input-group" >
                                    <input autocomplete="off" required type="text" placeholder="Nomor Voucher" class="form-control " name="nomor_voucher" value="{{$dtm->nomor_voucher}}" >
                                    <div class="input-group-addon"  >
                                        @if($dtm_idx == 1)
                                                <a href="#" class="btn-add-tamu" style="color: #00A65A;" ><i class="fa fa-plus-circle" ></i></a>
                                        @else
                                                <a href="#" class="btn-delete-tamu" style="color:#DD4B39;" ><i class="fa fa-trash" ></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div> 

                            <?php $dtm_idx++;?>
                        @endforeach                       
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
                    <input autocomplete="off" required type="text" name="harga" class="form-control input-harga uang text-right input-lg" style=""  placeholder="Harga" value="{{$dps->harga}}" >
                  <!-- </div> -->
                </div>  
            </div>
        </div>
    </div>

        <?php $dps_idx++; ?>
    @endforeach

    <div class="box box-solid">
        <div class="box-body" >
            <div class="row" >
            <div class="col-sm-12 col-md-12 col-lg-6 data-counter-widget" >
                    <label class="arrow-breadcrumb-group">TOTAL : <span style="font-size: 1.5em;" id="jumlah-harga" >{{$data->total != "" ? $data->total : '0'}}</span></label>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 btn-action-group"" >
                    <a class="btn btn-success" id="btn-add-pemesanan" ><i class="fa fa-plus-circle" ></i> Data Pemesanan</a>
                    <button id="btn-save" type="submit" class="btn btn-primary " ><i class="fa fa-save" ></i> Simpan</button>

                    <div class="btn-group">
                        <a class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="btn-cetak" target="_blank" href="#"  >Cetak <i class="fa fa-angle-down" ></i></a>
                    
                      <ul class="dropdown-menu" role="menu">
                        <li><a target="_blank" href="invoice/hotel/cetak-invoice/{{$data->id}}">Cetak Invoice</a></li>
                        <li><a target="_blank" href="invoice/hotel/cetak-kwitansi/{{$data->id}}">Cetak Kwitansi</a></li>
                      </ul>
                    </div>

                    <a id="btn-cancel" href="invoice/hotel" class="btn btn-danger" ><i class="fa fa-close" ></i> Batal</a>
                </div>
                
            </div>

        </div>
    </div>

</form>

</section><!-- /.content -->

<!-- ELEMENT FOR CLONE -->
<div class="hide" id="row-tamu-for-clone"  >
    <div class="form-group row-input-tamu" >
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
            <input autocomplete="off" required type="text" placeholder="Nomor Voucher" class="form-control " name="nomor_voucher" >
                <div class="input-group-addon" >
                    <a href="#" class="btn-delete-tamu" style="color:#DD4B39;" ><i class="fa fa-trash" ></i></a>
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
                          <label>Hotel*</label>
                          {{-- <div class="input-group" >
                            <input autocomplete="off" required type="text" name="hotel" class="form-control input-hotel" placeholder="Hotel"> 
                            <div class="input-group-addon"  >
                                <a class="btn-reset-hotel" ><i class="fa fa-history" ></i></a>
                            </div>
                          </div> --}}
                          <input autocomplete="off" required type="text" name="hotel" class="form-control input-hotel" placeholder="Hotel">
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 col-md-5 col-lg-5" >
                    <div role="form">
                        <!-- text input -->
                        <div class="form-group">
                          <label>Durasi*</label>
                          <div class="row" >
                              <div class="col-sm-6 col-md-6 col-lg-6" >
                                  <input autocomplete="off" required type="text" name="check_in" class="form-control" placeholder="Check In" style="margin-bottom: 5px;" >
                              </div>
                              <div class="col-sm-6 col-md-6 col-lg-6" >
                                  <input autocomplete="off" type="text" name="check_out" class="form-control" placeholder="Check Out">
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" >
                    <label>Tamu*</label>
                    <div class="form-horizontal row-input-tamu-group" >
                    <!-- </div> -->
                        <div class="form-group row-input-tamu" >
                            <div class="col-sm-2" >
                                <select required class="form-control input-titel " name="titel"  >
                                    <option value="mr" >Mr</option>
                                    <option value="mrs" >Mrs</option>
                                    <option value="ms" >Ms</option>
                                </select>
                            </div>
                            <div class="col-sm-5" >
                                <input autocomplete="off" required type="text" placeholder="Nama Tamu" class="form-control " name="nama" value="" >
                            </div>
                            <div class="col-sm-5" >
                                <div class="input-group" >
                                <input autocomplete="off" required type="text" placeholder="Nomor Voucher" class="form-control " name="nomor_voucher" >
                                    <div class="input-group-addon"  >
                                        <!-- <a href="#" class="btn-reset-tamu" ><i class="fa fa-history" ></i></a> -->
                                        <a href="#" class="btn-add-tamu" ><i class="fa fa-plus-circle" ></i></a>
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
<script src="plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
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
            // set min date
            $('input[name=jatuh_tempo]').datepicker('setStartDate',$(this).datepicker('getDate'));
            // set current date
            $('input[name=jatuh_tempo]').datepicker('setDate',$(this).datepicker('getDate'));
        }
    });

    function setTanggalDurasi(){
        $('input[name=check_in], input[name=check_out]').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true
        }).on('changeDate', function(){
            var trigger = $(this);
            var input_check_in = $('input[name=check_in]');
            if(trigger.is(input_check_in)){
                var next_date = moment($(this).datepicker('getDate')).add(1, 'day').toDate();
                $('input[name=check_out]').datepicker('setStartDate',next_date);
                $('input[name=check_out]').datepicker('setDate', next_date);

            //     var toDatepicker = $(this).parents('.input-daterange').find('.datepicker.to');
            // toDatepicker.datepicker('update', moment($(this).datepicker('getDate')).add(1, 'week').toDate());
            }
        });    
    }
    setTanggalDurasi();

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
    $(document).on('click','.btn-delete-tamu',function(){
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
    $(document).on('click','.btn-add-tamu',function(){
        var row_input_tamu = $('#row-tamu-for-clone').clone();
        var btn_add_tamu = $(this);
        var form_tamu = btn_add_tamu.parent().parent().parent().parent().parent();

        form_tamu.children('div:last').after(row_input_tamu.html());

        // set autocomplete nama
        setAutoCompleteNama();

        return false;
    });
    // END OF ADD PENUMPANG

    // AUTOCOMPLETE MASKAPAI
    var init_input_hotel = $('.input-hotel');
    init_input_hotel.autocomplete({
        serviceUrl: 'api/get-auto-complete-hotel',
        params: {  
                    'nama' : function() {
                                return init_input_hotel.val();
                            },
                },
        onSelect:function(suggestions){
            $(this).attr('data-hotelid',suggestions.data);
            // $(this).attr('readonly','readonly');
            $(this).parent().next().children('input').focus();
        }
    });

    $(document).on('keyup','.input-hotel',function() {
        // alert('pret');
        var nama = $(this).val();
        $(this).autocomplete().setOptions({
            params: { nama: nama }
        });
    });

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
                         "invoice_hotel_id":"",
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
        inv_master.invoice_hotel_id = $('input[name=invoice_hotel_id]').val();
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
        var inv_hotel = JSON.parse('{"hotel" : [] }');

        // set data hotel detail        
        $('.form-pemesanan').each(function(){
            // var first_col = $(this).find('input[name=kode_pemesanan]').val();

            var kode_pemesanan = $(this).find('input[name=kode_pemesanan]').val();
            var hotel = $(this).find('input[name=hotel]').val();
            var hotel_id = $(this).find('input[name=hotel]').data('hotelid');
            var check_in = $(this).find('input[name=check_in]').val();
            var check_out = $(this).find('input[name=check_out]').val();
            var harga = $(this).find('input[name=harga]').autoNumeric('get');
            var tamu = JSON.parse('{"tamu" : [] }');

           if(kode_pemesanan == "" || hotel == "" || hotel_id == "" || check_in == "" || harga == ""){
            can_save = false;
           }

            // $(this).find('.row-input-tamu-group').children('.row-input-tamu').each(function(){
            //     alert('ok');
            // });
            // alert('finding');
            var row_tamu_group = $(this).find('.row-input-tamu-group');
            row_tamu_group.find('.row-input-tamu').each(function(){
               // // add tamu
                var titel = $(this).find('select[name=titel]').val();
                var nama = $(this).find('input[name=nama]').val();
                var nomor_voucher = $(this).find('input[name=nomor_voucher]').val();

               tamu.tamu.push({
                        titel : titel,//$(this).find('select[name=titel]').val(),
                        nama : nama,//$(this).find('input[name=nama]').val(),
                        nomor_voucher : nomor_voucher//$(this).find('input[name=nomor_voucher]').val()
                        
                    });

               if(titel == "" || nama == "" || nomor_voucher == ""){
                can_save = false;
               }
               
            });

            inv_hotel.hotel.push({
                        kode_pemesanan : kode_pemesanan,
                        hotel : hotel,
                        hotel_id : hotel_id,
                        check_in : check_in,
                        check_out : check_out,
                        harga : harga,
                        tamu: tamu
                    });
                   
        });
   

        if(can_save){
            $('#btn-save').attr('disabled','disabled');
            var newform = $('<form>').attr('method','POST').attr('action','invoice/hotel/update');
                newform.append($('<input autocomplete="off">').attr('type','hidden').attr('name','inv_master').val(JSON.stringify(inv_master)));
                newform.append($('<input autocomplete="off">').attr('type','hidden').attr('name','inv_hotel').val(JSON.stringify(inv_hotel)));
                newform.submit();
                // alert('submitting');
        }else{
            alert('Lengkapi data yang kosong.');
        }
        
        return false;
    });

    

    // RESET MASKAPAI
    $(document).on('click','.btn-reset-hotel',function(){
        var input_hotel = $(this).parent().prev();
        input_hotel.val('');
        input_hotel.data('hotelid','');
        input_hotel.removeAttr('readonly');
        input_hotel.focus();
    });
    // END RESET MASKAPAI

    // RESET RUTE
    $(document).on('click','.btn-reset-rute',function(){
        var input_rute_check_out = $(this).parent().prev().children('input');
        var input_rute_check_in = $(this).parent().prev().prev().children('input');
        is_sj = input_rute_check_out.attr('readonly') !== undefined;
        if(!is_sj){
            input_rute_check_out.val('');
        }
        input_rute_check_in.val('');        
        input_rute_check_in.focus();
    });
    // END RESET RUTE

    // RESET PENUMPANG
    $(document).on('click','.btn-reset-tamu',function(){
        var row_tamu = $(this).parent().parent().parent().parent();
        // row_tamu.children('td:first').next().children('input').val('');
        // row_tamu.children('td:first').next().next().children('input').val('');
        row_tamu.find('input:text').val('');
        row_tamu.find('select').val('mr');
        row_tamu.find('input:first').focus();
        // row_tamu.children('td:first').hide();

        return false;
    });
    // END OF RESET PENUMPANG

    // BTN COPY

    // --------------- ADD MASKAPAI ----------------------
    $(document).on('click','.btn-add-hotel',function(){
        var btn = $(this);
        btn.parent('td').parent('tr').before('<tr class="row-hotel" ><td><input autocomplete="off" type="text" placeholder="Hotel" class="form-control  input-hotel" ></td><td style="width: 25px;" ><a class="btn-remove-hotel" ><i class="fa fa-trash" ></i></a></td></tr>');

        // autocomplete hotel
        var input_hotel = btn.parent('td').parent('tr').prev().children('td:first').children('input'); //form_pemesanan.find('input.input-hotel');
         input_hotel.autocomplete({
            serviceUrl: 'api/get-auto-complete-hotel',
            params: {  
                        'nama' : function() {
                                    return input_hotel.val();
                                },
                    },
            onSelect:function(suggestions){
                $(this).attr('data-hotelid',suggestions.data);
                // $(this).attr('readonly','readonly');
                // $(this).parent().next().children('input').focus();
            }
        });

         // fokuskan
         input_hotel.focus();


    });
    // --------------- END ADD MASKAPAI ----------------------

   

    $(document).on('change','input[name=perjalanan]',function(){
        var form_pemesanan = $(this).parent('label').parent('div').parent('div').parent('div').parent('td').parent('tr').parent('tbody').parent('table').parent('div').parent();

        if($(this).val() == 'SJ' ) {
            form_pemesanan.find('input.input-check_in').removeAttr('readonly');
            form_pemesanan.find('input.input-check_out').attr('readonly','readonly');
            form_pemesanan.find('input.input-check_out').val('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
        }else{
            // if PP
            form_pemesanan.find('input.input-check_in').removeAttr('readonly');
            form_pemesanan.find('input.input-check_out').removeAttr('readonly');
            form_pemesanan.find('input.input-check_out').val('');
        }
    });
    // ---------------- END PERJALANAN CHANGE --------------------

    // ----------------- REMOVE MASKAPAI -------------------------
    $(document).on('click','.btn-remove-hotel',function(){
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

        // // pindahkan button
        // var btn_add_pemesanan = $(this).parent();
        // btn_add_pemesanan.fadeOut(250,function(){
        //     btn_add_pemesanan.appendTo(form_pemesanan.children('div:last'));
        //     btn_add_pemesanan.show();    
        // });

        // autocomplete hotel
        var input_hotel = form_pemesanan.find('input.input-hotel');
         input_hotel.autocomplete({
            serviceUrl: 'api/get-auto-complete-hotel',
            params: {  
                        'nama' : function() {
                                    return input_hotel.val();
                                },
                    },
            onSelect:function(suggestions){
                $(this).attr('data-hotelid',suggestions.data);
                // $(this).attr('readonly','readonly');
                // $(this).parent().next().children('input').focus();
            }
        });

        // auto numeric input-harga
        form_pemesanan.find('input.input-harga').autoNumeric('init',{
            vMin:'0.00',
            vMax:'9999999999.00',
            aSep: '.',
            aDec: ',', 
        });

        // set tanggal durasi
        setTanggalDurasi();

        // set auto complete nama
        setAutoCompleteNama();
        

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



})(jQuery);
</script>
@append