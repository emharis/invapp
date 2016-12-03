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
           <label style="margin-top: 5px;" > 
                <h4 style="font-weight: bolder;margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0;" >Input Option</h4>
            </label>    
        </div>
        <div class="box-body" >
            <form class="form-horizontal" id="form-filter" method="POST" action="rekap/tiket/default-filter">
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

    $('input[name=tanggal_cetak_akhir]').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

     $('input[name=tanggal_cetak_awal]').datepicker({
        format: 'dd-mm-yyyy',
        // todayHighlight: true,
        autoclose: true
    }).on('changeDate', function(){
        // $('input[name=tanggal_cetak_akhir]').datepicker('remove');
        $('input[name=tanggal_cetak_akhir]').val('');
        $('input[name=tanggal_cetak_akhir]').datepicker('setStartDate',$('input[name=tanggal_cetak_awal]').datepicker('getDate'));
    });

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
    


    // check all checkbox
    $('input[name=ck_all]').change(function(){
        if($(this).prop('checked')){
            $('input.ck_row').prop('checked',true);
        }else{
            $('input.ck_row').prop('checked',false);

        };
        showOptionButton();
    });

    // tampilkan btn delete
    $(document).on('change','.ck_row',function(){
        showOptionButton();
    });

    function showOptionButton(){
        var checkedCk = $('input.ck_row:checked');
        
        if(checkedCk.length > 0){
            // tampilkan option button
            $('#btn-delete').removeClass('hide');
        }else{
            $('#btn-delete').addClass('hide');
        }
    }

    // Delete Data Lokasi
    $('#btn-delete').click(function(e){
        if(confirm('Anda akan menhapus data ini?')){
            var dataid = [];
            $('input.ck_row:checked').each(function(i){
                var data_id = $(this).parent().parent().data('id');
                // alert(data_id);
                var newdata = {"id":data_id}
                dataid.push(newdata);
            });

            var deleteForm = $('<form>').attr('method','POST').attr('action','invoice/invoice-lain/delete');
            deleteForm.append($('<input>').attr('type','hidden').attr('name','dataid').attr('value',JSON.stringify(dataid)));
            deleteForm.submit();
        }

        e.preventDefault();
        return false;
    });

    // BUTTON FILTER CLICK
    $('#btn-filter').click(function(){
        if($('#form-filter').hasClass('hide')){
            $('#form-filter').hide();
            $('#form-filter').removeClass('hide');
            // $('#form-filter').find('input').val('');
            $('#form-filter').slideDown(250);    
        }
        
    });

    // FILTER SUBMIT
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

    // FILTER OPTION
    $('input[name=filter_option]').change(function(){
        var val = $(this).val();
        if(val == 'maskapai'){
            $('input[name=maskapai]').removeAttr('readonly');
            $('input[name=nama_customer]').attr('readonly','readonly');
            $('input[name=nama_penumpang]').attr('readonly','readonly');
            $('input[name=kantor]').attr('readonly','readonly');
        }else if(val == 'customer'){
            $('input[name=nama_customer]').removeAttr('readonly');
            $('input[name=maskapai]').attr('readonly','readonly');
            $('input[name=nama_penumpang]').attr('readonly','readonly');
            $('input[name=kantor]').attr('readonly','readonly');
        }else if(val == 'penumpang'){
            $('input[name=nama_penumpang]').removeAttr('readonly');
            $('input[name=nama_customer]').attr('readonly','readonly');
            $('input[name=maskapai]').attr('readonly','readonly');
            $('input[name=kantor]').attr('readonly','readonly');
        }else if(val == 'kantor'){
            $('input[name=kantor]').removeAttr('readonly');
            $('input[name=nama_customer]').attr('readonly','readonly');
            $('input[name=nama_penumpang]').attr('readonly','readonly');
            $('input[name=maskapai]').attr('readonly','readonly');
        }
    });

    // CANCEL FILTER
    $('#btn-cancel-filter').click(function(){
        $('#form-filter').slideUp(250,function(){$('#form-filter').addClass('hide')});

        $('input[name=kantor]').attr('readonly','readonly');
        $('input[name=nama_customer]').attr('readonly','readonly');
        $('input[name=nama_penumpang]').attr('readonly','readonly');
        $('input[name=maskapai]').attr('readonly','readonly'); 
    });

    

})(jQuery);
</script>
@append