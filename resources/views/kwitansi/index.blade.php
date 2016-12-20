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

    .form-horizontal .control-label{
        text-align: left;
    }

    .dl-horizontal dt{
        width: 100%;
        text-align: left;
    }

    .dl-horizontal dt.dt-normal{
        font-weight: normal;
        font-size: 12px;
    }

    input.input-clear{
        /*background-color: transparent;*/
        text-decoration: underline;
    }

    form input{
        text-transform: uppercase;
    }
</style>

@append

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Cetak Kwitansi
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header with-border" >
           <div class="row" >
                        <div class="col-sm-3" >
                            <img style="height: 60px;" src="img/{{$setting['logo']}}" >
                        </div>
                        <div class="col-sm-9" >
                            <dl class="dl-horizontal">
                                <dt>{{$setting['company_name']}}</dt>
                                <dt class="dt-normal">{{$setting['alamat']}}</dt>
                                <dt class="dt-normal" >{{$setting['alamat_2']}}</dt>
                                <dt class="dt-normal" >{{'T. ' . $setting['telp'] .' | E. ' . $setting['email']}}</dt>
                            </dl>
                        </div>
                    </div>   
        </div>
        <form name="form_kwitansi" method="POST" action="kwitansi/cetak" class="form-horizontal" target="_blank">
            <div class="box-body" >
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">SUDAH TERIMA DARI</label>
                  <div class="col-sm-10">
                        <input type="text" name="sudah_terima" class="form-control input-clear" placeholder="Sudah Terima Dari" autofocus required>
                    
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">BANYAKNYA UANG</label>
                  <div class="col-sm-10">
                        <input style="background-color: #FAE1F1;" type="text" name="banyaknya" class="form-control input-clear" placeholder="" disabled>
                    
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">UNTUK PEMBAYARAN</label>
                  <div class="col-sm-10">
                        <input type="text" name="untuk_pembayaran" class="form-control input-clear" placeholder="Untuk Pembayaran" required>
                    
                  </div>
                </div>
                <hr/>
                <div class="row" >
                    <div class="col-sm-3" >
                        <input type="text" name="jumlah_uang" class="uang text-center form-control input-clear" placeholder="Banyaknya Uang" required>
                    </div>

                    <div class="col-sm-9" style="visibility: hidden;" ><a class="btn btn-primary" >OK</a></div>
                    
                    <div class="col-sm-8" >
                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;font-size: 12px;">
                            {{$catatan[1]}}<br/>
                            {{$catatan[2]}}<br/>
                            {{$catatan[3]}}<br/>
                            {{$catatan[4]}}<br/>
                            {{$catatan[5]}}<br/>
                            {{$catatan[6]}}<br/>
                            {{$catatan[7]}}
                        </p>
                    </div>

                    <div class="col-sm-4 " style="margin-top: 10px;" >
                        {{-- <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;"> --}}
                            
                            <div class="row" >
                                <div class="col-sm-6" >
                                    <input type="text" name="kota" class="text-center form-control input-clear" placeholder="Kota" required >
                                </div>
                                <div class="col-sm-6" >
                                    <input type="text" name="tanggal" class="text-center form-control input-clear"  placeholder="Tanggal" required>
                                </div>
                                <div class="col-sm-12" style="visibility: hidden;" ><a class="btn btn-primary" >OK</a></div>
                                <div class="col-sm-12" >
                                    <input type="text" name="nama" class="text-center form-control input-clear" placeholder="Nama" style="font-weight: bold;" required>
                                </div>
                                <div class="col-sm-12 text-right"  >
                                    <input type="text" name="nama_perusahaan" value="{{$setting['company_name']}}" class="text-center form-control input-clear input-sm" placeholder="Nama Perusahaan" readonly style="margin-top: 4px;">
                                </div>
                            </div>

                        {{-- </p> --}}
                    </div>                       
                </div>

            </div>
            <div class="box-footer" >
                <button class="btn btn-primary " type="submit" ><i class="fa fa-print" ></i> Cetak</button>
                <a class="btn btn-success " target="_blank" href="kwitansi/cetak-kosong" ><i class="fa fa-print" ></i> Cetak Kwitansi Kosong</a>
                <button class="btn btn-danger " type="reset" ><i class="fa fa-refresh" ></i> Reset</button>
            </div>
        </form>
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

    $('input[name=tanggal]').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
    });

    $('.uang').autoNumeric('init',{
        vMin:'0.00',
        vMax:'9999999999.00',
        aSep: '.',
        aDec: ',', 
    });

    // get terbilang
    $('input[name=jumlah_uang]').keyup(function(){
        var uang = $(this).autoNumeric('get');
        // alert(uang);
        var url = 'kwitansi/get-banyaknya-uang-string/' + uang;
        // alert(url);
        // location.href = url;
        $.get(url,function(res){
            $('input[name=banyaknya]').val(res);
        }).error(function(){
            $('input[name=banyaknya]').val('');
        });
    });

    //  $('input[name=tanggal_cetak_awal]').datepicker({
    //     format: 'dd-mm-yyyy',
    //     // todayHighlight: true,
    //     autoclose: true
    // }).on('changeDate', function(){
    //     // $('input[name=tanggal_cetak_akhir]').datepicker('remove');
    //     $('input[name=tanggal_cetak_akhir]').val('');
    //     $('input[name=tanggal_cetak_akhir]').datepicker('setStartDate',$('input[name=tanggal_cetak_awal]').datepicker('getDate'));
    // });

    
    

})(jQuery);
</script>
@append