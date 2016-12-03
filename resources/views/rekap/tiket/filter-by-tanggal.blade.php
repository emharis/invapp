@extends('layouts.master')

@section('styles')
<!--Bootsrap Data Table-->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>
<style>
    #table-data > tbody > tr{
        cursor:pointer;
    }

    #table-data thead tr th{
        text-align: center;
    }

    .table-left tbody tr td{
        text-align: left!important;
    }
</style>
@append

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Rekapitulasi Data Pemesanan Tiket
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box box-solid">
        <div class="box-header with-border" >
            <div class="row" >
                <div class="col-sm-12 col-md-12 col-lg-12" >
                    <div class="btn-action-group" >
                        <button class="btn btn-primary" id="btn-print"  ><i class="fa fa-print" ></i> Cetak</button>
                        <a href="rekap/tiket" class="btn btn-danger" id="btn-close"  ><i class="fa fa-close" ></i> Keluar</a>
                    </div>                    
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12" >
                    <form class="form-horizontal hide" id="form-filter" method="POST">
                      <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-2 ">
                                <label class="control-label">Tanggal Cetak</label>
                            </div>
                          
                          <div class="col-sm-10">
                            <div class="row" >
                                <div class="col-sm-6 col-md-6 col-lg-6" >
                                    <input type="text" name="tanggal_cetak_awal" class="form-control input-tanggal" placeholder="Awal" autocomplete="off" required>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6" >
                                    <input type="text" name="tanggal_cetak_akhir" class="form-control input-tanggal" placeholder="Akhir" autocomplete="off" required>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-2 ">
                            <div class="radio">
                                <label>
                                  <input type="radio" name="filter_option"  value="maskapai"  >
                                  <span style="font-weight: bold;" >Maskapai</span>
                                </label>
                              </div>
                          </div>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="maskapai"  placeholder="Maskapai" readonly>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-2 ">
                            <div class="radio">
                                <label>
                                  <input type="radio" name="filter_option"  value="customer"  >
                                  <span style="font-weight: bold;" >Kustomer</span>
                                </label>
                              </div>
                          </div>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_customer"  placeholder="Kustomer" readonly>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-2 ">
                            <div class="radio">
                                <label>
                                  <input type="radio" name="filter_option"  value="penumpang"  >
                                  <span style="font-weight: bold;" >Penumpang</span>
                                </label>
                              </div>
                          </div>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama_penumpang"  placeholder="Penumpang" readonly>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-2 ">
                            <div class="radio">
                                <label>
                                  <input type="radio" name="filter_option"  value="kantor"  >
                                  <span style="font-weight: bold;" >Kantor</span>
                                </label>
                              </div>
                          </div>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="kantor"  placeholder="Kantor" readonly>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <button class="btn btn-primary" type="submit" >Submit</button>
                            <button class="btn btn-danger" type="reset" id="btn-cancel-filter"  >Batal</button>
                          </div>
                        </div>
                      </div><!-- /.box-body -->
                      <div class="box-footer">
                        
                      </div><!-- /.box-footer -->
                    </form>                    
                </div>
            </div>
           
        </div>
        <div class="box-body">
            <table></table>

            <?php $rownum=1; ?>
            <div class="table-responsive" >
                <table class="table table-bordered table-condensed table-striped " id="table-data" >
                    <thead>
                        <tr>
                            <th>Nomor<br/>Invoice</th>
                            {{-- <th>Kode<br/>Pemesanan</th> --}}
                            <th>Tanggal<br/>Cetak</th>
                            <th>Tanggal<br/>Jatuh Tempo</th>
                            <th>Nama Kustomer</th>
                            <th>Kantor</th>
                            {{-- <th>Nama<br/>Kustomer</th> --}}
                            {{-- <th>Nama<br/>Penumpang</th> --}}
                            {{-- <th>Nomor<br/>Tiket</th> --}}
                            {{-- <th>Maskapai</th> --}}
                            <th>Total</th>
                            <th style="width:25px;" ></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $dt)
                        <tr data-rowid="{{$rownum}}" data-id="{{$dt->id}}"  >
                            <td  >
                                {{$dt->inv_num}}
                            </td>
                            {{-- <td  >
                                {{$dt->kode_pemesanan}}
                            </td> --}}
                            <td>
                                {{$dt->tgl_cetak_formatted}}
                            </td>
                            <td>
                                {{$dt->jatuh_tempo_formatted}}
                            </td>
                            <td class="td-text-left" >
                                {{$dt->nama}}
                            </td>
                            <td  >
                                {{$dt->kantor}}
                            </td>
                            {{-- <td class="td-text-left" >
                                {{$dt->nama_penumpang}}
                            </td>
                            <td  >
                                {{$dt->nomor_tiket}}
                            </td>
                            <td>
                                {{$dt->maskapai}}
                            </td>
                            <td class="uang text-right" >
                                {{$dt->harga}}
                            </td> --}}
                            <td class="uang text-right" >
                                {{$dt->total}}
                            </td>
                            <td class="text-center" >
                                {{-- <a class="btn btn-primary btn-xs" href="invoice/invoice-lain/edit/{{$dt->id}}" ><i class="fa fa-edit" ></i></a> --}}
                                <a class="btn btn-primary btn-xs btn-show" data-id="{{$dt->id}}" ><i class="fa fa-eye" ></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

</section><!-- /.content -->

@stop

@section('scripts')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/jqueryform/jquery.form.min.js" type="text/javascript"></script>
<script src="plugins/autonumeric/autoNumeric-min.js" type="text/javascript"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>

<script type="text/javascript">
(function ($) {

    // $('input[name=tanggal_cetak_akhir]').datepicker({
    //     format: 'dd-mm-yyyy',
    //     autoclose: true,
    // });

    //  $('input[name=tanggal_cetak_awal]').datepicker({
    //     format: 'dd-mm-yyyy',
    //     // todayHighlight: true,
    //     autoclose: true
    // }).on('changeDate', function(){
    //     // $('input[name=tanggal_cetak_akhir]').datepicker('remove');
    //     $('input[name=tanggal_cetak_akhir]').val('');
    //     $('input[name=tanggal_cetak_akhir]').datepicker('setStartDate',$('input[name=tanggal_cetak_awal]').datepicker('getDate'));
    // });

    var TBL_KATEGORI = $('#table-data').DataTable({
        sort:false,
        "iDisplayLength": 25
    });

    $('.uang').autoNumeric('init',{
         vMin:'0.00',
            vMax:'9999999999.00',
            aSep: '.',
            aDec: ',', 
    });



    $('.uang').each(function(){
        // alert('ok');
        $(this).autoNumeric('set',$(this).autoNumeric('get'));
    });

    $('.btn-show').click(function(){
        var data_id = $(this).data('id');
        var data_row = $(this).parent().parent();

        // var newrow = $('<tr>');
        // var row_content $('<td>').attr('colspan','7');
        // row_content.html('<label>Ereis Hermanto</label>');
        $('.row-detail').remove();
        $.get('rekap/tiket/get-detail-invoice/' + data_id,null,function(res){
            var newrow = '<tr style="background-color:#EEF0F0;" class="row-detail" ><td colspan="7" class="text-align:center;" >' + res +'</td></tr>';
            data_row.after(newrow);
            data_row.next().children().children().hide();
            data_row.next().children().children().slideDown(100);
            // data_row.next().slideDown(250);
            // newrow.children('td:first').children('div').fadeIn('slow');
        });
        // newrow.append(row_content);
        
// alert('ok');
        // data_row.after('')

    });
    

    // // check all checkbox
    // $('input[name=ck_all]').change(function(){
    //     if($(this).prop('checked')){
    //         $('input.ck_row').prop('checked',true);
    //     }else{
    //         $('input.ck_row').prop('checked',false);

    //     };
    //     showOptionButton();
    // });

    // // tampilkan btn delete
    // $(document).on('change','.ck_row',function(){
    //     showOptionButton();
    // });

    // function showOptionButton(){
    //     var checkedCk = $('input.ck_row:checked');
        
    //     if(checkedCk.length > 0){
    //         // tampilkan option button
    //         $('#btn-delete').removeClass('hide');
    //     }else{
    //         $('#btn-delete').addClass('hide');
    //     }
    // }

    // // Delete Data Lokasi
    // $('#btn-delete').click(function(e){
    //     if(confirm('Anda akan menhapus data ini?')){
    //         var dataid = [];
    //         $('input.ck_row:checked').each(function(i){
    //             var data_id = $(this).parent().parent().data('id');
    //             // alert(data_id);
    //             var newdata = {"id":data_id}
    //             dataid.push(newdata);
    //         });

    //         var deleteForm = $('<form>').attr('method','POST').attr('action','invoice/invoice-lain/delete');
    //         deleteForm.append($('<input>').attr('type','hidden').attr('name','dataid').attr('value',JSON.stringify(dataid)));
    //         deleteForm.submit();
    //     }

    //     e.preventDefault();
    //     return false;
    // });

    // // BUTTON FILTER CLICK
    // $('#btn-filter').click(function(){
    //     if($('#form-filter').hasClass('hide')){
    //         $('#form-filter').hide();
    //         $('#form-filter').removeClass('hide');
    //         // $('#form-filter').find('input').val('');
    //         $('#form-filter').slideDown(250);    
    //     }
        
    // });

    // // FILTER SUBMIT
    // $('#form-filter').submit(function(){
    //     var tgl_cetak_awal = $('input[name=tanggal_cetak_awal]').val();
    //     var tgl_cetak_akhir = $('input[name=tanggal_cetak_akhir]').val();
        
    //     var post_url = "rekap/tiket/default-filter";

    //     var newform = $('<form>').attr('method','POST').attr('action',post_url);
    //     newform.append($('<input>').attr('type','hidden').attr('name','tgl_cetak_awal').val(tgl_cetak_awal));
    //     newform.append($('<input>').attr('type','hidden').attr('name','tgl_cetak_akhir').val(tgl_cetak_akhir));


        
    //     newform.submit();

    //     return false;
    // });

    // // FILTER OPTION
    // $('input[name=filter_option]').change(function(){
    //     var val = $(this).val();
    //     if(val == 'maskapai'){
    //         $('input[name=maskapai]').removeAttr('readonly');
    //         $('input[name=nama_customer]').attr('readonly','readonly');
    //         $('input[name=nama_penumpang]').attr('readonly','readonly');
    //         $('input[name=kantor]').attr('readonly','readonly');
    //     }else if(val == 'customer'){
    //         $('input[name=nama_customer]').removeAttr('readonly');
    //         $('input[name=maskapai]').attr('readonly','readonly');
    //         $('input[name=nama_penumpang]').attr('readonly','readonly');
    //         $('input[name=kantor]').attr('readonly','readonly');
    //     }else if(val == 'penumpang'){
    //         $('input[name=nama_penumpang]').removeAttr('readonly');
    //         $('input[name=nama_customer]').attr('readonly','readonly');
    //         $('input[name=maskapai]').attr('readonly','readonly');
    //         $('input[name=kantor]').attr('readonly','readonly');
    //     }else if(val == 'kantor'){
    //         $('input[name=kantor]').removeAttr('readonly');
    //         $('input[name=nama_customer]').attr('readonly','readonly');
    //         $('input[name=nama_penumpang]').attr('readonly','readonly');
    //         $('input[name=maskapai]').attr('readonly','readonly');
    //     }
    // });

    // // CANCEL FILTER
    // $('#btn-cancel-filter').click(function(){
    //     $('#form-filter').slideUp(250,function(){$('#form-filter').addClass('hide')});

    //     $('input[name=kantor]').attr('readonly','readonly');
    //     $('input[name=nama_customer]').attr('readonly','readonly');
    //     $('input[name=nama_penumpang]').attr('readonly','readonly');
    //     $('input[name=maskapai]').attr('readonly','readonly'); 
    // });

    

})(jQuery);
</script>
@append