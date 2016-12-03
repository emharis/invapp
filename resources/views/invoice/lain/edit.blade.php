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
    table#table-item tbody tr td{
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

    .btn-remove-hotel, .btn-remove-rute, .btn-reset-rute, .btn-reset-hotel, .btn-reset-item{
        cursor: pointer;
    }

    /*------------------------------------------------------------------------------*/

    /*.row-input-item{
        border: dashed 1px #A5C8DC;
        border-radius: 5px;
        padding-left: 5px;
        padding-right: 5px;
        padding-bottom: 5px;
        margin-bottom: 5px;
    }

    .row-input-item input,.row-input-item select{
        margin-top:5px;
    }

    .addon-titel-item{
        min-width: 75px;
    }*/

    .row-input-item input,.row-input-item select{
        margin-bottom:5px;
    }

    .row-input-item{
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
        <a href="invoice/invoice-lain" >Invoice Lain </a> <i class="fa fa-angle-double-right" ></i> {{$data->inv_num}}
    </h1>
</section>

<!-- Main content -->
<section class="content">

<form id="form_invoice" method="POST" action="invoice/invoice-lain/update" >
    <input type="hidden" name="invoice_lain_id" value="{{$data->id}}">

    <div class="box box-solid" id="form-kustomer">
        <div class="box-header with-border" style="padding-top:5px;padding-bottom:5px;" >
            <div class="row" >
                <div class="col-sm-12 col-md-12 col-lg-8 btn-action-group"" >
                    <!-- <div class=" > -->
                        <label style="margin-top: 5px;" > 
                            <h4 style="font-weight: bolder;margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0;" >EDIT INVOICE : <i style="color:#3C8DBC;" >{{$data->inv_num}}</i></h4>
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
                          <input autocomplete="off" required type="text" class="form-control" placeholder="Nama" name="nama" autofocus value="{{$data->nama}}" >
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
                          <input autocomplete="off" type="email" class="form-control" placeholder="E-Mail" name="email" value="{{$data->email}}" >
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
    <div class="box box-solid form-pemesanan" >
        <div class="box-header with-border" >
            <h3 style="color:#3C8DBC">DATA PEMESANAN</h3>
            <a href="#" class="pull-right btn-box-tool btn-remove-input-group hide"  ><i class="fa fa-times"></i></a>

        </div>
        <div class="box-body" >
            <div id="row-item-group" class="row" >
                <?php $dt_idx=1; ?>
                @foreach($data->data_pemesanan as $dt)

                    <div class="row-item col-xs-12" >
                        <div class="col-sm-5 col-md-5 col-lg-5" >
                            <div class="form-group">
                                @if($dt_idx == 1)
                                  <label>Keterangan*</label>
                                @endif
                                  {{-- <input autocomplete="off" required type="text" name="keterangan" class="form-control" placeholder="Keterangan" value="{{$dt->keterangan}}" >  --}}
                                  <textarea class="form-control" name="keterangan" style="resize:none;overflow: hidden;" rows="1" >{{$dt->keterangan}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2" >
                            <div class="form-group">
                                @if($dt_idx == 1)
                                    <label>Harga Satuan*</label>
                                @endif
                              <input autocomplete="off" required type="text" name="harga_satuan" class="form-control uang text-right" placeholder="Harga Satuan" value="{{$dt->harga_satuan}}"> 
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2" >
                            <div class="form-group">
                                @if($dt_idx == 1)
                                    <label>Jumlah*</label>
                                @endif
                              <input autocomplete="off" required type="text" name="jumlah" class="form-control text-right" placeholder="Jumlah" value="{{$dt->jumlah}}" > 
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3" >
                            <div class="form-group">
                                @if($dt_idx == 1)
                                    <label>Total Harga*</label>
                                @endif
                              <div class="input-group" >
                                <input autocomplete="off" required type="text" placeholder="Total Harga" class="form-control uang text-right" name="total_harga" readonly value="{{$dt->total_harga}}" >
                                    <div class="input-group-addon"  >
                                        @if($dt_idx == 1)
                                        <a href="#" class="btn-add-item " ><i class="fa fa-plus-circle " style="color: #00A65A;" ></i></a>
                                        @else 
                                            <a href="#" class="btn-delete-item" ><i class="fa fa-trash" style="color:#DD4B39;" ></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $dt_idx++; ?>
                @endforeach
            </div>

            
        </div>
        <div class="box-footer"  >
            {{-- <div class="row"  > --}}
                <div class="col-sm-12 col-md-12 col-lg-6 data-counter-widget" {{-- style="border: dashed thin grey;border-radius: 5px;" --}} >
                    <label class="arrow-breadcrumb-group">TOTAL : <span style="font-size: 1.5em;" id="jumlah-harga" >{{$data->total}}</span></label>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 btn-action-group"" >
                    <button id="btn-save" type="submit" class="btn btn-primary " ><i class="fa fa-save" ></i> Simpan</button>
                    <a id="btn-cancel" href="invoice/invoice-lain" class="btn btn-danger" ><i class="fa fa-close" ></i> Batal</a>
                </div>
                
            {{-- </div> --}}
        </div>
    </div>

</form>

</section><!-- /.content -->

<!-- ELEMENT FOR CLONE -->
<div class="hide" id="row-item-for-clone"  >
    <div class="row-item  col-xs-12" >
        <div class="col-sm-5 col-md-5 col-lg-5" >
            <div class="form-group">
              {{-- <input autocomplete="off" required type="text" name="keterangan" class="form-control" placeholder="Keterangan">  --}}
              <textarea class="form-control" name="keterangan" style="resize:none;overflow: hidden;" rows="1" ></textarea>
            </div>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2" >
            <div class="form-group">
              <input autocomplete="off" required type="text" name="harga_satuan" class="form-control uang text-right" placeholder="Harga Satuan"> 
            </div>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2" >
            <div class="form-group">
              <input autocomplete="off" required type="text" name="jumlah" class="form-control text-right" placeholder="Jumlah"> 
            </div>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3" >
            <div class="form-group">              <div class="input-group" >
                <input autocomplete="off" required type="text" placeholder="Total Harga" class="form-control uang text-right" name="total_harga" readonly >
                    <div class="input-group-addon"  >
                        <a href="#" class="btn-delete-item" ><i class="fa fa-trash" style="color:#DD4B39;" ></i></a>
                    </div>
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

    // AUTO GROUW TEXT AREA
    function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight)+"px";
    }

    $(document).on('keyup','textarea[name=keterangan]',function(){
        auto_grow(this);
    });
    // END OF AUTOGROW TEXT AREA

    // -----------------------------------------------------
    // SET AUTO NUMERIC
    // =====================================================
    function setAutoNumericUang(){
        $('.uang').autoNumeric('init',{
            vMin:'0.00',
            vMax:'9999999999.00',
            aSep: '.',
            aDec: ',', 
        });
    }
    setAutoNumericUang();

    $('#jumlah-harga').autoNumeric('init',{
        vMin:'0.00',
        vMax:'9999999999.00',
        aSep: '.',
        aDec: ',', 
        aSign: 'Rp. '
    });
    // END OF AUTONUMERIC

   


    // REMOVE ITEM
    $(document).on('click','.btn-delete-item',function(){
        // if(confirm('Anda akan menghapus data ini?')){
            var row = $(this).parent().parent().parent().parent().parent();
            row.fadeOut(350,function(){
                row.remove();

                hitungTotalJumlahHarga();
            });
        // }

        return false;
    });
    // END REMOVE PENUMPAN

    // ADD TAMU
    $(document).on('click','.btn-add-item',function(){
        var row_input_item = $('#row-item-for-clone').clone();
        var btn_add_item = $(this);
        var form_item = btn_add_item.parent().parent().parent().parent().parent().parent();

        form_item.children('div:last').after(row_input_item.html());

        // set autonumeric
        setAutoNumericUang();

        // focuskan ke input keterangan
        form_item.children('div:last').find('input[name=keterangan]').focus();

        return false;
    });
    // END OF ADD TAMU

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

   

    // submitting form
    $('#form_invoice').submit(function(){

        var can_save = true;
        // cek kelengkapan data
        var inv_master = {"nama":"",
                         "invoic_lain_id":"",
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
        inv_master.invoice_lain_id = $('input[name=invoice_lain_id]').val();
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
        var inv_data_pemesanan = JSON.parse('{"data" : [] }');

        $('#row-item-group').find('.row-item').each(function(){
            var keterangan = $(this).find('input[name=keterangan]').val();     
            var harga_satuan = $(this).find('input[name=harga_satuan]').autoNumeric('get');    
            var jumlah = $(this).find('input[name=jumlah]').val();    
            var total_harga = $(this).find('input[name=total_harga]').autoNumeric('get');

            if(keterangan == "" || harga_satuan == "" || jumlah == "" ){
                can_save = false;
            }

            inv_data_pemesanan.data.push({
                keterangan:keterangan,
                harga_satuan:harga_satuan,
                jumlah:jumlah,
                total_harga:total_harga
            });    

        });

        if(can_save){
            $('#btn-save').attr('disabled','disabled');
            var newform = $('<form>').attr('method','POST').attr('action','invoice/invoice-lain/update');
                newform.append($('<input autocomplete="off">').attr('type','hidden').attr('name','inv_master').val(JSON.stringify(inv_master)));
                newform.append($('<input autocomplete="off">').attr('type','hidden').attr('name','inv_data_pemesanan').val(JSON.stringify(inv_data_pemesanan)));
                newform.submit();
                // alert('submitting');
        }else{
            alert('Lengkapi data yang kosong.');
        }
        
        return false;
    });

    // HITUNG TOTAL HARGA
    $(document).on('keyup','input[name=harga_satuan]',function(){
        var harga_satuan = $(this).autoNumeric('get');
        // alert(harga_satuan);
        var row_item = $(this).parent().parent().parent();
        var jumlah = row_item.find('input[name=jumlah]').val();
        var total_harga = Number(jumlah) * Number(harga_satuan);
        // alert(total_harga);
        row_item.find('input[name=total_harga]').autoNumeric('set',total_harga);

        hitungTotalJumlahHarga();
        // row_item.hide();
        // row_item.find('input[name=total_harga]').hide();

    });

    $(document).on('keyup','input[name=jumlah]',function(){
        var jumlah = $(this).val();
        // alert(harga_satuan);
        var row_item = $(this).parent().parent().parent();
        var harga_satuan = row_item.find('input[name=harga_satuan]').autoNumeric('get');
        var total_harga = Number(jumlah) * Number(harga_satuan);
        // alert(total_harga);
        row_item.find('input[name=total_harga]').autoNumeric('set',total_harga);

        hitungTotalJumlahHarga();
    });

    function hitungTotalJumlahHarga(){
        var total_jumlah_harga = 0;
        $('.row-item').each(function(){
            var total = $(this).find('input[name=total_harga]').autoNumeric('get');
            total_jumlah_harga = Number(total_jumlah_harga) + Number(total);
        });

        $('#jumlah-harga').autoNumeric('set',total_jumlah_harga);
    }


})(jQuery);
</script>
@append