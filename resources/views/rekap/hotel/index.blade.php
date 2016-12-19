@extends('layouts.master')

@section('styles')
<!--Bootsrap Data Table-->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css"/>
<style>
    .autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
    .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
    .autocomplete-selected { background: #FFE291; }
    .autocomplete-suggestions strong { font-weight: normal; color: red; }
    .autocomplete-group { padding: 2px 5px; }
    .autocomplete-group strong { display: block; border-bottom: 1px solid #000; }

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
        Rekapitulasi Data Pemesanan Hotel
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box box-solid">
        <div class="box-header with-border" >
           <label style="margin-top: 5px;" > 
                <h4 style="font-weight: bolder;margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0;" >Pencarian</h4>
            </label>    
        </div>
        <div class="box-body" >
            <form  id="form-filter" method="POST" action="rekap/hotel/default-filter" role="form" >
                <div class="row" >
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <div class="form-group">
                          <label >Tanggal Cetak </label>
                          <input type="text" class="form-control" name="tanggal_cetak_awal"  placeholder="Tanggal Cetak Awal" required>
                        </div>    
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <div class="form-group">
                          <label style="color: transparent;" >Tanggal Cetak Akhir</label>
                          <input type="text" class="form-control" name="tanggal_cetak_akhir"  placeholder="Tanggal Cetak Akhir" required>
                        </div>    
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="filter_option[]" class="ck_filter_option" value="kustomer">
                                  Kustomer
                                </label>
                            </div>
                            {{-- <label>
                              <input type="radio" name="filter_option" value="kustomer" >
                              Kustomer
                            </label> --}}
                            <input type="text" class="form-control" name="kustomer"  placeholder="Kustomer" readonly >
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <div class="form-group">
                          {{-- <label>
                              <input type="radio" name="filter_option" value="kantor" >
                              Kantor
                            </label> --}}
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="filter_option[]" class="ck_filter_option" value="kantor">
                                  Kantor
                                </label>
                            </div>
                            <input type="text" class="form-control" name="kantor"  placeholder="Kantor" readonly >
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <div class="form-group">
                            {{-- <label>
                              <input type="radio" name="filter_option" value="tamu" >
                              Tamu
                            </label> --}}
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="filter_option[]" class="ck_filter_option" value="tamu">
                                  Tamu
                                </label>
                            </div>
                            <input type="text" class="form-control" name="tamu"  placeholder="Tamu" readonly >
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <div class="form-group">
                            {{-- <label>
                              <input type="radio" name="filter_option" value="hotel" >
                              Hotel
                            </label> --}}
                            <div class="checkbox">
                                <label>
                                  <input type="checkbox" name="filter_option[]" class="ck_filter_option" value="hotel">
                                  Hotel
                                </label>
                            </div>
                            <input type="text" class="form-control" name="hotel"  placeholder="Hotel" readonly >
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6" >
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search" ></i> Cari</button>
                    </div>
                </div>
            </form> 
        </div>
        <div class="box-footer" ></div>
    </div><!-- /.box -->

</section><!-- /.content -->

@stop

@section('scripts')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/jqueryform/jquery.form.min.js" type="text/javascript"></script>
<script src="plugins/autonumeric/autoNumeric-min.js" type="text/javascript"></script>
<script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="plugins/autocomplete/jquery.autocomplete.min.js" type="text/javascript"></script>

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


    // AUTOCOMPLETE MASKAPAI
    function setAutoCompleteHotel(){
        var input_hotel = $('input[name=hotel]');
        input_hotel.autocomplete({
            serviceUrl: 'api/get-auto-complete-hotel',
            params: {  
                        'nama' : function() {
                                    return input_hotel.val();
                                },
                    },
            onSelect:function(suggestions){

            }
        });

        $(document).on('keyup','input[name=hotel]',function() {
            // alert('pret');
            var nama = $(this).val();
            $(this).autocomplete().setOptions({
                params: { nama: nama }
            });
        });    
    }
    setAutoCompleteHotel();

    // AUTOCOMPLETE KUSTOMER
    function setAutoCompleteKustomer(){
        var input_kustomer = $('input[name=kustomer]');
        input_kustomer.autocomplete({
            serviceUrl: 'api/get-auto-complete-nama',
            params: {  
                        'nama' : function() {
                                    return input_kustomer.val();
                                },
                    },
            onSelect:function(suggestions){

            }
        });

        $(document).on('keyup','input[name=kustomer]',function() {
            // alert('pret');
            var nama = $(this).val();
            $(this).autocomplete().setOptions({
                params: { nama: nama }
            });
        });    
    }
    setAutoCompleteKustomer();

    // AUTOCOMPLETE KUSTOMER
    function setAutoCompleteKantor(){
        var input_kustomer = $('input[name=kantor]');
        input_kustomer.autocomplete({
            serviceUrl: 'api/get-auto-complete-kantor',
            params: {  
                        'nama' : function() {
                                    return input_kustomer.val();
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

    // AUTOCOMPLETE PENUMPANG
    function setAutoCompleteTamu(){
        var input_tamu = $('input[name=tamu]');
        input_tamu.autocomplete({
            serviceUrl: 'api/get-auto-complete-nama',
            params: {  
                        'nama' : function() {
                                    return input_tamu.val();
                                },
                    },
            onSelect:function(suggestions){

            }
        });

        $(document).on('keyup','input[name=tamu]',function() {
            // alert('pret');
            var nama = $(this).val();
            $(this).autocomplete().setOptions({
                params: { nama: nama }
            });
        });    
    }
    setAutoCompleteTamu();
   

    // FILTER OPTION
    $('input.ck_filter_option').change(function(){
        var val = $(this).val();
        if(val == 'hotel'){
            // $('input[name=hotel]').removeAttr('readonly').val('');
            // $('input[name=kustomer]').attr('readonly','readonly').val('');
            // $('input[name=tamu]').attr('readonly','readonly').val('');
            // $('input[name=kantor]').attr('readonly','readonly').val('');
            if($(this).prop('checked')){
                $('input[name=hotel]').removeAttr('readonly').val('');
            }else{
                $('input[name=hotel]').attr('readonly','readonly').val('');
            }
        }else if(val == 'kustomer'){
            // $('input[name=kustomer]').removeAttr('readonly').val('');
            // $('input[name=hotel]').attr('readonly','readonly').val('');
            // $('input[name=tamu]').attr('readonly','readonly').val('');
            // $('input[name=kantor]').attr('readonly','readonly').val('');
            if($(this).prop('checked')){
                $('input[name=kustomer]').removeAttr('readonly').val('');
            }else{
                $('input[name=kustomer]').attr('readonly','readonly').val('');
            }
        }else if(val == 'tamu'){
            // $('input[name=tamu]').removeAttr('readonly').val('');
            // $('input[name=kustomer]').attr('readonly','readonly').val('');
            // $('input[name=hotel]').attr('readonly','readonly').val('');
            // $('input[name=kantor]').attr('readonly','readonly').val('');
            if($(this).prop('checked')){
                $('input[name=tamu]').removeAttr('readonly').val('');
            }else{
                $('input[name=tamu]').attr('readonly','readonly').val('');
            }
        }else if(val == 'kantor'){
            // $('input[name=kantor]').removeAttr('readonly').val('');
            // $('input[name=kustomer]').attr('readonly','readonly').val('');
            // $('input[name=tamu]').attr('readonly','readonly').val('');
            // $('input[name=hotel]').attr('readonly','readonly').val('');
            if($(this).prop('checked')){
                $('input[name=kantor]').removeAttr('readonly').val('');
            }else{
                $('input[name=kantor]').attr('readonly','readonly').val('');
            }
        }
    });

    // CANCEL FILTER
    $('#btn-cancel-filter').click(function(){
        $('#form-filter').slideUp(250,function(){$('#form-filter').addClass('hide')});

        $('input[name=kantor]').attr('readonly','readonly');
        $('input[name=kustomer]').attr('readonly','readonly');
        $('input[name=tamu]').attr('readonly','readonly');
        $('input[name=hotel]').attr('readonly','readonly'); 
    });



    

})(jQuery);
</script>
@append