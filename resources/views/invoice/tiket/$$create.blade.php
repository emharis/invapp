@extends('layouts.master')

@section('styles')
<link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>
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
        background-color:#EEF0F0;
        float:right;
        padding-right: 5px;
        padding-left: 5px;
    }

    table.table-tiket-group > tbody > tr:last-child{
        border-bottom:dashed 1px darkgray;
    }

    table#table-penumpang tbody tr td{
        border:none;
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

    <!-- Default box -->
    <div class="box box-solid">
        <div class="box-header with-border" style="padding-top:5px;padding-bottom:5px;" >
            <label> <small>Invoice</small> <h4 style="font-weight: bolder;margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0;" >New</h4></label>

            <label class="pull-right" >&nbsp;&nbsp;&nbsp;</label>
            <a class="btn btn-arrow-right pull-right disabled bg-gray" >Posted</a>

            <label class="pull-right" >&nbsp;&nbsp;&nbsp;</label>
            <a class="btn btn-arrow-right pull-right disabled bg-blue" >Draft</a>
        </div>
        <div class="box-body">
            <table class="table table-condensed" >
                <tbody>
                    <tr>
                        <td class="col-lg-2">
                            <label>Nama</label>
                        </td>
                        <td class="col-lg-4" >
                            <input type="text" name="nama" autofocus class="form-control" data-customerid="" required>
                        </td>
                        
                        <td class="col-lg-2" >
                            <label>Kantor/Perusahaan</label>
                        </td>
                        <td class="col-lg-4" >
                            <input type="text" name="kantor" class="form-control" value="" >
                        </td>
                    </tr>
                    <tr>
                        <td class="col-lg-2">
                            <label>Alamat</label>
                        </td>
                        <td class="col-lg-4" colspan="3" >
                            <input type="text" name="alamat" class="form-control " data-salespersonid=""  >
                        </td>
                    </tr>
                    <tr>
                        <td class="col-lg-2">
                            <label>Telp</label>
                        </td>
                        <td class="col-lg-4" >
                            <input type="text" name="telp" class="form-control" data-salespersonid=""  >
                        </td>
                        
                        <td class="col-lg-2 " >
                            <label>Email</label>
                        </td>
                        <td class="col-lg-4 " >
                            <input type="text" name="email"  class="form-control" value="" >
                        </td>
                    </tr>
                    <tr>
                        <td class="col-lg-2">
                            <label>Tanggal Cetak</label>
                        </td>
                        <td class="col-lg-4" >
                            <input type="text" name="tanggal_cetak"  class="input-tanggal form-control" value="{{date('d-m-Y')}}" >
                        </td>
                        
                        <td class="col-lg-2 " >
                            <label>Jatuh Tempo</label>
                        </td>
                        <td class="col-lg-4 " >
                            <input type="text" name="jatuh_tempo"  class="input-tanggal form-control" value="{{date('d-m-Y')}}" >
                        </td>
                    </tr>
                    
                </tbody>
            </table>


        </div><!-- /.box-body -->
    </div><!-- /.box -->

    {{-- DIV DATA TIKET --}}
    <div class="box box-solid" >
        <div class="box-body" >
            <h4 class="page-header" style="font-size:14px;color:#3C8DBC"><strong>PRODUCT DETAILS</strong></h4>

            <div class="row" >
                <!-- FORM INPUT FOR CLONE -->
                <div class="col-sm-12 col-md-12 col-lg-12 form-input-group hide" id="first-form-input-group" >
                     <a href="#" class="pull-right btn-box-tool btn-remove-input-group hide"  ><i class="fa fa-times"></i></a>
                    <table class="table table-condensed table-tiket-group"  >
                        <tbody>
                            <tr>
                                <td class="col-sm-2 col-md-2 col-lg-2" >
                                    <label>Kode Pemesanan</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control input-clear input-sm" name="kode_pemesanan" />
                                </td>
                                <td class="col-sm-2 col-md-2 col-lg-2" >
                                    <label>Nomor Penerbangan</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control input-clear input-sm" name="nomor_penerbangan"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-sm-2 col-md-2 col-lg-2" >
                                    <label>Maskapai</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control input-clear input-sm" name="maskapai" />
                                </td>
                                <td class="col-sm-2 col-md-2 col-lg-2" >
                                    <label>Rute</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control input-clear input-sm" name="rute"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;" >
                                    <label>Penumpang</label>                            
                                </td>
                                <td colspan="3" class="no-padding" >
                                    <table class="table table-condensed no-padding" id="table-penumpang" >
                                        <tbody>
                                            <tr class="row-passanger" >
                                                <td style="width:75px;" >
                                                    <select class="form-control input-titel input-sm input-clear"  >
                                                        <option value="mr" >Mr</option>
                                                        <option value="mrs" >Mrs</option>
                                                        <option value="ms" >Ms</option>
                                                    </select>
                                                </td>
                                                <td >
                                                    <input type="text" placeholder="Nama" class="form-control input-sm input-clear" name="nama" >
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Nomor Tiket" class="form-control input-sm input-clear" name="nomor_tiket" >
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Harga" class="form-control input-sm input-clear input-harga text-right" name="harga" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" >
                                                    <a class="btn btn-xs btn-primary btn-add-penumpang" ><i class="fa fa-plus-circle" ></i> Add Penumpang</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> <!-- FORM INPUT FOR CLONE -->

                <div class="col-sm-12 col-md-12 col-lg-12 form-input-group " id="form-input-group-1" >
                     <a href="#" class="pull-right btn-box-tool btn-remove-input-group hide"  ><i class="fa fa-times"></i></a>
                    <table class="table table-condensed table-tiket-group"  >
                        <tbody>
                            <tr>
                                <td class="col-sm-2 col-md-2 col-lg-2" >
                                    <label>Kode Pemesanan</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control input-clear input-sm" name="kode_pemesanan" />
                                </td>
                                <td class="col-sm-2 col-md-2 col-lg-2" >
                                    <label>Maskapai</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control input-clear input-sm" name="nomor_penerbangan"/>                                    
                                </td>
                            </tr>
                            <tr>
                                <td class="col-sm-2 col-md-2 col-lg-2" >
                                    <label>Rute</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control input-clear input-sm" name="rute"/>
                                </td>
                                <td class="col-sm-2 col-md-2 col-lg-2" >
                                    <label>Harga</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control input-clear input-sm input-harga" name="rute"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;" >
                                    <label>Penumpang</label>                            
                                </td>
                                <td colspan="3" class="no-padding" >
                                    <table class="table table-condensed no-padding" id="table-penumpang" >
                                        <tbody>
                                            <tr class="row-passanger" >
                                                <td style="width:75px;" >
                                                    <select class="form-control input-titel input-sm input-clear"  >
                                                        <option value="mr" >Mr</option>
                                                        <option value="mrs" >Mrs</option>
                                                        <option value="ms" >Ms</option>
                                                    </select>
                                                </td>
                                                <td >
                                                    <input type="text" placeholder="Nama" class="form-control input-sm input-clear" name="nama" >
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Nomor Tiket" class="form-control input-sm input-clear" name="nomor_tiket" >
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Harga" class="form-control input-sm input-clear input-harga text-right" name="harga" >
                                                </td>
                                                <td style="width: 25px;" class="text-right" >
                                                    <a class="btn-remove-penumpang hide" style="cursor: pointer;" ><i class="fa fa-trash" ></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" >
                                                    <a class="btn btn-xs btn-primary btn-add-penumpang" ><i class="fa fa-plus-circle" ></i> Add Penumpang</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div> <!-- END ROW -->


           
            <a class="btn btn-primary btn-sm" id="btn-add-item" style="margin-top:5px;" ><i class="fa fa-plus-circle" ></i> Add an item</a>

            <!--<h4 class="page-header" style="font-size:14px;color:#3C8DBC"><strong>TOTAL</strong></h4>-->
            <div class="row" >
                <div class="col-lg-8" >
                   
                </div>
                <div class="col-lg-4" >
                    <table class="table table-condensed" >
                        <tbody>
                           
                            <tr>
                                <td class="text-right" style="border-top:solid darkgray 1px;" >
                                    Total :
                                </td>
                                <td class="label-total text-right" style="font-size:18px;font-weight:bold;border-top:solid darkgray 1px;" >
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12" >
                    <button type="submit" class="btn btn-primary" id="btn-save" >Save</button>
                    <a href="invoice/tiket" class="btn btn-danger" id="btn-cancel-save" >Cancel</a>
                </div>
            </div>
        </div>
    </div>

</section><!-- /.content -->

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
    });
    // END OF SET DATEPICKER

    // SET AUTOCOMPLETE CUSTOMER
    // $('input[name=customer]').autocomplete({
    //     serviceUrl: 'invoice/tiket/get-customer',
    //     params: {  'nama': function() {
    //                     return $('input[name=customer]').val();
    //                 }
    //             },
    //     onSelect:function(suggestions){
    //         // set data customer
    //         $('input[name=customer]').data('customerid',suggestions.data);
    //     }

    // });
    // END OF SET AUTOCOMPLETE CUSTOMER

    // SET AUTOCOMPLETE SALESPERSON
    // $('input[name=salesperson]').autocomplete({
    //     serviceUrl: 'invoice/tiket/get-salesperson',
    //     params: {  'nama': function() {
    //                     return $('input[name=salesperson]').val();
    //                 }
    //             },
    //     onSelect:function(suggestions){
    //         // set data customer
    //         $('input[name=salesperson]').data('salespersonid',suggestions.data);
    //     }

    // });
    // END OF SET AUTOCOMPLETE SALESPERSON

    // -----------------------------------------------------
    // SET AUTO NUMERIC
    // =====================================================
    $('.label-total, .input-harga').autoNumeric('init',{
        vMin:'0',
        vMax:'9999999999'
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

    // ~BTN ADD ITEM
    var form_input_index = 1;
    $('#btn-add-item').click(function(){
        // tampilkan form add new item
        form_input_index++;
        var new_form_group = $('#first-form-input-group').clone();
        new_form_group.removeClass('hide');
        new_form_group.hide();
        new_form_group.attr('id','form-input-group-'+(form_input_index));
        new_form_group.find('input:text').val('');
        new_form_group.find('.btn-remove-input-group').removeClass('hide');
        $('#btn-add-item').prev().append(new_form_group);

        // format harga auto numeric
        $('.input-harga').autoNumeric('init',{
            vMin:'0',
            vMax:'9999999999'
        });

        new_form_group.slideDown(250);

        return false;
    });
    // END OF ~BTN ADD ITEM

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
    $(document).on('click','.btn-remove-penumpang',function(){
        if(confirm('Anda akan menghapus data ini?')){
            var row = $(this).parent().parent();
            row.remove();
        }
    });
    // END REMOVE PENUMPAN

    // ADD PENUMPANG
    $(document).on('click','.btn-add-penumpang',function(){
        var row_input_penumpang = $(this).parent().parent().prev().clone();
        row_input_penumpang.find('input:text').val('');
        row_input_penumpang.find('.btn-remove-penumpang').removeClass('hide');
        $(this).parent().parent().before(row_input_penumpang);

        // fokuskan ke input nama di row baru Penumpang
        row_input_penumpang.find('select[name=titel]').focus();

        // format harga auto numeric
        $('.input-harga').autoNumeric('init',{
            vMin:'0',
            vMax:'9999999999'
        });
    });
    // END OF ADD PENUMPANG

    $(document).on('keyup','.input-maskapai',function() {
        // alert('pret');
        var nama = $(this).val();
        $(this).autocomplete().setOptions({
            params: { nama: nama }
        });
    });

    // // HITUNG TOTAL
    $(document).on('keyup','.input-harga',function(){
       hitungTotal();
    });
    // $(document).on('input','.input-quantity',function(){
    //     calcSubtotal($(this));
    // });

    // function generateInput(inputElm){
    //     first_col = inputElm.parent().parent().children('td:first');
    //     input_product = first_col.next().children('input');
    //     input_qty_on_hand = first_col.next().next().children('input');
    //     input_qty = first_col.next().next().next().children('input');
    //     input_unit_price = first_col.next().next().next().next().children('input');
    //     input_sup = first_col.next().next().next().next().next().children('input');
    //     input_subtotal = first_col.next().next().next().next().next().next().children('input');
    // }

    // function calcSubtotal(inputElm){
    //     generateInput(inputElm);

    //     // hitung sub total
    //     var subtotal = Number(input_qty.val()) * Number(input_sup.autoNumeric('get'));

    //     // tampilkan sub total
    //     input_subtotal.autoNumeric('set',subtotal);

    //     // hitung TOTAL
    //     hitungTotal();
    // }
    // // END HITUNG SUBTOTAL

    // FUNGSI HITUNG TOTAL KESELURUHAN
    function hitungTotal(){
        // var disc = $('input[name=disc]').autoNumeric('get');
        var total = 0;
        $('.input-harga-on-row').each(function(){
            // alert('harga');
            var harga = $(this).autoNumeric('get');
            total = Number(total) + Number(harga);
        });        

        // tampilkan subtotal dan total
        // $('.label-total-subtotal').autoNumeric('set',subtotal);
        $('.label-total').autoNumeric('set',total);
    }
    // END OF FUNGSI HITUNG TOTAL KESELURUHAN

    // // INPUT DISC ON KEYUP
    // $(document).on('keyup','input[name=disc]',function(){
    //     hitungTotal();
    // });
    // // END OF INPUT DISC ON KEYUP

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


    // BTN SAVE TRANSACTION
    $('#btn-save').click(function(){
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
        inv_master.nama = $('input[name=nama]').val();
        inv_master.kantor = $('input[name=kantor]').val();
        inv_master.alamat = $('input[name=alamat]').val();
        inv_master.telp = $('input[name=telp]').val();
        inv_master.email = $('input[name=email]').val();
        inv_master.tanggal_cetak = $('input[name=tanggal_cetak]').val();
        inv_master.jatuh_tempo = $('input[name=jatuh_tempo]').val();
        inv_master.total = $('.label-total').autoNumeric('get');



        if(inv_master.nama == "" || inv_master.tanggal_cetak == "" || inv_master.jatuh_tempo == ""){
            can_save = false;
        }


        // get data barang;
        var inv_tiket = JSON.parse('{"tiket" : [] }');

        // set data tiket detail        
        $('.row-product').each(function(){
            var first_col = $(this).children('td:first');
            var order_ref_val = first_col.next().children('input').val();
            var flight_no_val = first_col.next().next().children('input').val();
            var maskapai_id_val = first_col.next().next().next().children('div').children('input').data('maskapaiid');
            var maskapai_val = first_col.next().next().next().children('div').children('input').val();
            var rute_val = first_col.next().next().next().next().children('input').val();
            var titel_val = first_col.next().next().next().next().next().children('select').val();
            var nama_val = first_col.next().next().next().next().next().next().children('input').val();
            var no_tiket_val = first_col.next().next().next().next().next().next().next().children('input').val();
            var harga_val = first_col.next().next().next().next().next().next().next().next().children('input').autoNumeric('get');

            if(order_ref_val !="" 
                && flight_no_val != "" 
                && maskapai_val != "" 
                && rute_val != "" 
                && titel_val != "" 
                && nama_val != "" 
                && nama_val != "" 
                && no_tiket_val != "" 
                && harga_val != ""){

                inv_tiket.tiket.push({
                        order_ref : order_ref_val,
                        flight_no : flight_no_val,
                        maskapai_id : maskapai_id_val,
                        maskapai : maskapai_val,
                        rute : rute_val,
                        titel : titel_val,
                        nama : nama_val,
                        no_tiket : no_tiket_val,
                        harga : harga_val
                    });

            }else{
                can_save = false;
            }            
        });

        if(inv_tiket.tiket.length == 0){
            can_save = false;
        }

     
        if(can_save){
            var newform = $('<form>').attr('method','POST').attr('action','invoice/tiket/insert');
                newform.append($('<input>').attr('type','hidden').attr('name','inv_master').val(JSON.stringify(inv_master)));
                newform.append($('<input>').attr('type','hidden').attr('name','inv_tiket').val(JSON.stringify(inv_tiket)));
                newform.submit();
                // alert('submitting');
        }else{
            alert('Lengkapi data yang kosong.');
        }
        


        return false;
    });
    // END OF BTN SAVE TRANSACTION


    // RESET MASKAPAI
    $(document).on('click','.btn-reset-maskapai',function(){
        var input_maskapai = $(this).parent().prev();
        input_maskapai.val('');
        input_maskapai.data('maskapaiid','');
        input_maskapai.removeAttr('readonly');
        input_maskapai.focus();
    });
    // END RESET MASKAPAI


    

    // // $('#btn-test').click(function(){
    // //     hitungTotal();
    // //     return false;
    // // });
    // // END OF FUNGSI HITUNG TOTAL KESELURUHAN

})(jQuery);
</script>
@append