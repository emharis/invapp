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

    .table.table-min thead tr th,.table.table-min tbody tr td{
        padding-left:5px;
        padding-top:1px;
        padding-bottom:1px;
        padding-right:5px;
    }

    .table.table-min tbody tr.row-header-penumpang{
        background-color: #C8DBFA;
    }

    .table.table-min tbody tr.row-penumpang{
        background-color: #F2F7F7;
    }

    .table thead tr th{
        text-align: center;
        text-transform: uppercase;
    }

    .table tbody tr td.row-odd{
        background-color: #EEF0F0;   
        /*border-top: solid 2px red;*/
    }

    @media (min-width: 768px) {
        .dl-horizontal dt { 
            text-align: left; 
            white-space: normal;
            width: 100px;
        }
        
        .dl-horizontal dd { 
            margin-left: 0;
        }
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
            <form name="form-cetak" target="_blank" method="POST" action="rekap/tiket/cetak-with-option" >
                <input type="hidden" name="tanggal_cetak_awal" value="{{$tanggal_cetak_awal}}">
                <input type="hidden" name="tanggal_cetak_akhir" value="{{$tanggal_cetak_akhir}}">
                <input type="hidden" name="kustomer" value="{{$kustomer}}">
                <input type="hidden" name="kantor" value="{{$kantor}}">
                <input type="hidden" name="maskapai" value="{{$maskapai}}">
                <input type="hidden" name="penumpang" value="{{$penumpang}}">
                <input type="hidden" name="orientasi" value="P">

                {{-- <div class="btn-group">
                    <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown"    >Cetak <i class="fa fa-angle-down" ></i></a>
                
                  <ul class="dropdown-menu" role="menu">
                    <li><a data-orientasi="P" href="#" class="btn-cetak" >Potrait</a></li>
                    <li><a data-orientasi="L"  href="#" class="btn-cetak" >Landscape</a></li>
                  </ul>
                </div> --}}
                <button type="submit" class="btn btn-primary" data-orientasi="P" href="#" class="btn-cetak" ><i class="fa fa-print" ></i> Cetak</button>

                {{-- <button type="" class="btn btn-primary" id="btn-print"  ><i class="fa fa-print" ></i> Cetak</button> --}}
                <a href="rekap/tiket" class="btn btn-danger" id="btn-close"  ><i class="fa fa-close" ></i> Keluar</a>
            </form> 

        </div>
        <div class="box-body">
            <dl class="dl-horizontal">
                <dt>Tanggal Cetak</dt>
                <dd><b>:</b>  {{str_replace('-','/',$tanggal_cetak_awal) . ' - ' . str_replace('-','/',$tanggal_cetak_akhir)}}</dd>
                {!! $kustomer != "" ? '<dt>Kustomer</dt>':'' !!}
                {!! $kustomer != "" ? '<dd><b>:</b>  '.$kustomer.'</dd>':'' !!}
                
                {!! $kantor != "" ? '<dt>Kantor</dt>':'' !!}
                {!! $kantor != "" ? '<dd><b>:</b>  '.$kantor.'</dd>':'' !!}

                {!! $maskapai != "" ? '<dt>Maskapai</dt>':'' !!}
                {!! $maskapai != "" ? '<dd><b>:</b>  '.$maskapai.'</dd>':'' !!}

                {!! $penumpang != "" ? '<dt>Penumpang</dt>':'' !!}
                {!! $penumpang != "" ? '<dd><b>:</b>  '.$penumpang.'</dd>':'' !!}
                
            </dl>

            {{-- <div class="clearfix" ></div>
            <br/> --}}

            <div class="table-responsive" >
                <table class="table table-bordered table-condensed table-data " >
                    <thead>
                        <tr>
                            <th>
                                Nomor Invoice
                            </th>
                            <th>
                                Kode Pemesanan
                            </th>
                            <th>
                                Tanggal Cetak
                            </th>
                            <th>
                                Nama Penumpang
                            </th>
                            <th>
                                Nomor Tiket
                            </th>
                            <th>
                                Maskapai
                            </th>
                            <th>
                                Harga
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php $rownum=1;?>
                        <?php $rowdt = 1; ?>
                        @foreach($data as $dt)
                            <?php $oddeven = $rowdt & 1 ? 'row-odd' : 'row-even'; ?>
                            <?php $rowpg=1; ?>
                            
                            @foreach($dt->data_penumpang as $dpg)
                                    <tr  >
                                        @if(count($dt->data_penumpang) > 1)
                                            @if($rowpg == 1)
                                                <td class="{{$oddeven}}" rowspan="{{count($dt->data_penumpang)}}" >
                                                    {{$dt->inv_num}} 
                                                </td>
                                                <td rowspan="{{count($dt->data_penumpang)}}" class="{{$oddeven}}">
                                                    {{$dt->kode_pemesanan}}
                                                </td>
                                                <td class="{{$oddeven}}" rowspan="{{count($dt->data_penumpang)}}" >
                                                    {{$dt->tgl_cetak_formatted}}
                                                </td>
                                                
                                            @endif
                                        @else
                                            <td class="{{$oddeven}}">
                                                {{$dt->inv_num }} 
                                            </td>
                                            <td class="{{$oddeven}}" >
                                                {{$dt->kode_pemesanan}}
                                            </td>
                                            <td class="{{$oddeven}}">
                                                {{$dt->tgl_cetak_formatted}}
                                            </td>
                                        @endif
                                        
                                        <td  class="td-text-left {{$oddeven}}"  >
                                           {{ucfirst(strtolower($dpg->titel)) . '. ' . $dpg->nama}}
                                        </td>
                                        <td class="{{$oddeven}}">
                                            {{$dpg->nomor_tiket}}
                                        </td>

                                        @if(count($dt->data_penumpang) > 1)
                                            @if($rowpg == 1)                                
                                                <td rowspan="{{count($dt->data_penumpang)}}" class="{{$oddeven}}">
                                                    {{$dt->maskapai}}
                                                </td>
                                            @endif
                                        @else
                                            <td class="{{$oddeven}}" >
                                                {{$dt->maskapai}}
                                            </td>
                                        @endif

                                        @if(count($dt->data_penumpang) > 1)
                                            @if($rowpg == 1)
                                                <td rowspan="{{count($dt->data_penumpang)}}" class="text-right {{$oddeven}}">
                                                    {{number_format($dt->harga,2,',','.')}}
                                                </td>
                                            @endif
                                        @else
                                            <td class="text-right  {{$oddeven}}" >
                                                {{number_format($dt->harga,2,',','.')}}
                                            </td>
                                        @endif

                                    </tr>

                                        @if(count($dt->data_penumpang) > 1)
                                            @if($rowpg == 1)
                                                <?php $rowdt++;?>
                                            @endif
                                        @else
                                            <?php $rowdt++;?>
                                        @endif

                                        <?php $rowpg++;?>

                                @endforeach
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

    });

    $('.btn-cetak').click(function(){

        var orientasi = $(this).data('orientasi');
        $('input[name=orientasi]').val(orientasi);
        $('form[name=form-cetak]').submit();

        return false;
    });
    

    

})(jQuery);
</script>
@append