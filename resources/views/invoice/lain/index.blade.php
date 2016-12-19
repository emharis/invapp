@extends('layouts.master')

@section('styles')
<!--Bootsrap Data Table-->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

<style>
    #table-data > tbody > tr{
        cursor:pointer;
    }


</style>

@append

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Invoice Lain
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box box-solid">
        <div class="box-header with-border" >
            <div class="row" >
                <div class="col-sm-12 col-md-12 col-lg-8" >
                    <div class="btn-action-group" >
                        <a class="btn btn-primary  " id="btn-add" href="invoice/invoice-lain/create" ><i class="fa fa-plus-circle" ></i> Tambah Baru</a>
                        {{-- <a class="btn btn-success" ><i class="fa fa-filter" ></i> Filter</a> --}}
                        <a class="btn btn-danger hide" id="btn-delete" href="#" ><i class="fa fa-trash-o" ></i> Delete</a>    
                    </div>
                    
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4 " >
                        <div class="data-counter-widget"  >
                            <table style="background-color: #ECF0F5; text-align:center;"   >
                                <tr>
                                    <td class="bg-green text-center" rowspan="2" style="width: 50px;" ><i class="fa fa-tags" ></i></td>
                                    <td style="padding-left: 10px;padding-right: 5px;">
                                        JUMLAH DATA
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right"  style="padding-right: 5px;" >
                                        <label class="uang">{{count($data)}}</label>
                                    </td>
                                </tr>
                            </table>                            
                        </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <table></table>

            <?php $rownum=1; ?>
            <div class="table-responsive" >
                <table class="table table-bordered table-condensed table-striped table-hover" id="table-data" >
                    <thead>
                        <tr>
                            <th style="width:25px;" class="text-center">
                                <input type="checkbox" name="ck_all" style="margin-left:15px;padding:0;" >
                            </th>
                            <th>Nomor Invoice</th>
                            <th>Nama kustomer</th>
                            <!-- <th>Kantor/Perusahaan</th> -->
                            <th>Tanggal Cetak</th>
                            <th>Jatuh Tempo</th>
                            <th>Total</th>
                            <th  ></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $dt)
                        <tr data-rowid="{{$rownum}}" data-id="{{$dt->id}}">
                            <td class="text-center" >
                                <input type="checkbox" class="ck_row" >
                            </td>
                            <td class="" >
                                {{$dt->inv_num}}
                            </td>
                            <td class="td-text-left" >
                                {{$dt->nama}}
                            </td>
                            <!-- <td class="" >
                                {{$dt->kantor}}
                            </td> -->
                            <td class="" >
                                {{$dt->tgl_cetak_formatted}}
                            </td>
                            <td class="" >
                                {{$dt->jatuh_tempo_formatted}}
                            </td>
                            <td class="text-right uang" >
                                {{$dt->total}}
                            </td>
                            <td class="text-center" >
                                <a class="btn btn-primary btn-xs" href="invoice/invoice-lain/edit/{{$dt->id}}" ><i class="fa fa-edit" ></i></a>

                                <a class="btn btn-success btn-xs" target="_blank" data-toggle="tooltip" title="Cetak Invoice" href="invoice/invoice-lain/cetak-invoice/{{$dt->id}}" ><i class="fa fa-file-text-o" ></i></a>
                                <a class="btn btn-warning btn-xs" target="_blank" data-toggle="tooltip" title="Cetak Kwitansi" href="invoice/invoice-lain/cetak-kwitansi/{{$dt->id}}" ><i class="fa fa-file-text-o" ></i></a>
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

<script type="text/javascript">
(function ($) {

    var TBL_KATEGORI = $('#table-data').DataTable({
        sort:false,
        "iDisplayLength": 25
    });

    $('.uang').autoNumeric('init',{
        vMin:'0',
        vMax:'9999999999'
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

    // Row Clicked
    // $(document).on('click','.',function(){        
    //     var row = $(this).parent();        
    //     var data_id = row.data('id');            
    //     location.href = 'invoice/invoice-lain/edit/' + data_id ;        
    // });

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

    

})(jQuery);
</script>
@append