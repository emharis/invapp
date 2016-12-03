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

    .row-input-penumpang{
        border: dashed 1px #A5C8DC;
        border-radius: 5px;
        padding-left: 5px;
        padding-right: 5px;
        padding-bottom: 5px;
        margin-bottom: 5px;
    }

    .row-input-penumpang input,.row-input-penumpang select{
        margin-top:5px;
        /*margin-bottom:5px;*/
    }

    .addon-titel-penumpang{
        min-width: 75px;
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

    <div class="box box-solid">
        <div class="box-header with-border" style="padding-top:5px;padding-bottom:5px;" >
            <label style="margin-top: 5px;" > 
                {{-- <small>Invoice</small>  --}}
                <h4 style="font-weight: bolder;margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0;" >INVOICE</h4>
            </label>

            <div class="pull-right" >
                <ul id="breadcrumbs-two">
                    <li><a  class="current" >Draft</a></li>
                    <li><a >Posted</a></li>
                    <!-- <li><a  class=" last-item"></a></li> -->
                </ul>    
            </div>
            

        </div>
        <div class="box-body">
        <h4 class="page-header" style="font-size:14px;color:#3C8DBC"><strong>DATA CUSTOMER</strong></h4>

            <div class="row" >
                <div class="col-sm-6 col-md-6 col-lg-6">
                   <div class="form-horizontal">
                       <!-- <div class="box-body"> -->
                            <div class="form-group">
                              <label class="col-sm-4 ">Nama</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Nama">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-4 ">Kantor/Perusahaan</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Kantor/Perusahaan">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-4 ">Telepon/HP</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control" placeholder="Telepon/HP">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-4 ">Email</label>
                              <div class="col-sm-8">
                                <input type="email" class="form-control" placeholder="Email">
                              </div>
                            </div>
                      <!-- </div> -->
                      <!-- /.box-body -->
                   </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6">
                   <div class="form-horizontal">
                       <!-- <div class="box-body"> -->
                            <div class="form-group">
                              <label class="col-sm-4 ">Alamat</label>
                              <div class="col-sm-8">
                                <textarea class="form-control" rows="3" placeholder="Alamat"></textarea>
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-4 ">Tanggal Cetak</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control input-tanggal" placeholder="Tanggal Cetak">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-4 ">Jatuh Tempo</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control input-tanggal" placeholder="Jatuh Tempo">
                              </div>
                            </div>
                      <!-- </div> -->
                      <!-- /.box-body -->
                   </div>
                </div>

                <!----------------------- -->
                <!-- <div class="col-sm-6 col-md-6 col-lg-6">
                   <table class="table table-condensed no-border" >
                        <tbody>
                            <tr>
                                <td class="col-lg-2">
                                    <label>Nama</label>
                                </td>
                                <td class="col-lg-4" >
                                    <input type="text" name="nama" autofocus class="form-control" data-customerid="" required>
                                </td>

                            </tr>
                            <tr>
                                <td class="col-lg-2" >
                                    <label>Kantor/Perusahaan</label>
                                </td>
                                <td class="col-lg-4" >
                                    <input type="text" name="kantor" class="form-control" value="" >
                                </td>
                            </tr>
                            <tr>
                                <td class="col-lg-2">
                                    <label>Telepon/HP</label>
                                </td>
                                <td class="col-lg-4" >
                                    <input type="text" name="telp" class="form-control" data-salespersonid=""  >
                                </td>
                               
                            </tr>
                            <tr>
                                <td class="col-lg-2 " >
                                    <label>Email</label>
                                </td>
                                <td class="col-lg-4 " >
                                    <input type="text" name="email"  class="form-control" value="" >
                                </td>
                                
                            </tr>
                            
                        </tbody>
                    </table>
                </div> -->
                <!-- <div class="col-sm-6 col-md-6 col-lg-6">
                   <table class="table table-condensed no-border" >
                        <tbody>
                            <tr>
                                
                                <td class="col-lg-2">
                                    <label>Alamat</label>
                                </td>
                                <td class="col-lg-4"  rowspan="2" >
                                    <textarea class="form-control" name="alamat" rows="3" ></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td style="color:transparent;">.</td>
                            </tr>
                            
                            <tr>
                                <td class="col-lg-2">
                                    <label>Tanggal Cetak</label>
                                </td>
                                <td class="col-lg-4" >
                                    <input type="text" name="tanggal_cetak"  class="input-tanggal form-control" value="{{date('d-m-Y')}}" >
                                </td>
                            </tr>
                            <tr>
                                
                                
                                <td class="col-lg-2 " >
                                    <label>Tanggal Jatuh Tempo</label>
                                </td>
                                <td class="col-lg-4 " >
                                    <input type="text" name="jatuh_tempo"  class="input-tanggal form-control" value="{{date('d-m-Y')}}" >
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div> -->
            </div>

            


        </div><!-- /.box-body -->
    </div><!-- /.box -->

    <!-- Default box -->
    <!-- <div class="box box-solid">
        <div class="box-header with-border" style="padding-top:5px;padding-bottom:5px;" >
            <label style="margin-top: 5px;" > 
                {{-- <small>Invoice</small>  --}}
                <h4 style="font-weight: bolder;margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0;" >INVOICE</h4>
            </label>

            <label class="pull-right" >&nbsp;&nbsp;&nbsp;</label>
            <a class="btn btn-arrow-right pull-right disabled bg-gray" >Posted</a>

            <label class="pull-right" >&nbsp;&nbsp;&nbsp;</label>
            <a class="btn btn-arrow-right pull-right disabled bg-blue" >Draft</a>
        </div>
        <div class="box-body">
        <h4 class="page-header" style="font-size:14px;color:#3C8DBC"><strong>DATA CUSTOMER</strong></h4>

            <table class="table table-condensed" >
                <tbody>
                    <tr>
                        <td class="col-lg-2">
                            <label>Nama</label>
                        </td>
                        <td class="col-lg-4" >
                            <input type="text" name="nama" autofocus class="form-control" data-customerid="" required>
                        </td>

                        <td class="col-lg-2">
                            <label>Alamat</label>
                        </td>
                        <td class="col-lg-4" rowspan="2" >
                            {{-- <input type="text" name="alamat" class="form-control " data-salespersonid=""  > --}}
                            <textarea class="form-control" name="alamat" rows="3" ></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-lg-2" >
                            <label>Kantor/Perusahaan</label>
                        </td>
                        <td class="col-lg-4" >
                            <input type="text" name="kantor" class="form-control" value="" >
                        </td>
                    </tr>
                    <tr>
                        <td class="col-lg-2">
                            <label>Telepon/HP</label>
                        </td>
                        <td class="col-lg-4" >
                            <input type="text" name="telp" class="form-control" data-salespersonid=""  >
                        </td>
                        
                        <td class="col-lg-2">
                            <label>Tanggal Cetak</label>
                        </td>
                        <td class="col-lg-4" >
                            <input type="text" name="tanggal_cetak"  class="input-tanggal form-control" value="{{date('d-m-Y')}}" >
                        </td>
                    </tr>
                    <tr>
                        <td class="col-lg-2 " >
                            <label>Email</label>
                        </td>
                        <td class="col-lg-4 " >
                            <input type="text" name="email"  class="form-control" value="" >
                        </td>
                        
                        <td class="col-lg-2 " >
                            <label>Tanggal Jatuh Tempo</label>
                        </td>
                        <td class="col-lg-4 " >
                            <input type="text" name="jatuh_tempo"  class="input-tanggal form-control" value="{{date('d-m-Y')}}" >
                        </td>
                    </tr>
                    
                </tbody>
            </table>


        </div>
    </div> -->
    <!-- /.box -->

    {{-- DIV DATA TIKET --}}
    <div class="box box-solid form-pemesanan" >
        <div class="box-header with-border" >
            <h3>DATA PEMESANAN (1)</h3>
        </div>
        <div class="box-body" >
             
            <a href="#" class="pull-right btn-box-tool btn-remove-input-group hide"  ><i class="fa fa-times"></i></a>
            <div class="row" >
                <div class="col-sm-7 col-md-7 col-lg-7">
                   <div class="form-horizontal">
                        <div class="form-group">                          <label class="col-sm-3 ">Kode Pemesanan</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control " name="kode_pemesanan" placeholder="Kode Pemesanan">
                          </div>
                        </div>
                   </div>
                </div>

                <div class="col-sm-5 col-md-5 col-lg-5">
                   <div class="form-horizontal">
                        <div class="form-group">
                          <label class="col-sm-4 ">Maskapai</label>
                          <div class="col-sm-8">
                            <div class="input-group" >
                                <input type="text" class="form-control input-maskapai" name="maskapai" placeholder="Maskpai">
                                <div class="input-group-addon" style="border: none;" >
                                    <a  ><i class="fa fa-history" ></i></a>
                                </div>
                            </div>
                          </div>
                        </div>
                   </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12" >
                    <div class="form-horizontal">
                       <!-- <div class="box-body"> -->
                            <div class="form-group">
                              <label class="col-sm-2 ">Perjalanan</label>
                              <div class="col-sm-8">
                                <div class="row" >
                                    <div class="col-sm-4" >
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="perjalanan"  value="SJ" >
                                              Sekali Jalan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4" >
                                        <div class="radio">
                                            <label>
                                              <input type="radio" name="perjalanan"  value="PP" >
                                              Pulang Pergi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                      <!-- </div> -->
                      <!-- /.box-body -->
                   </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12" >
                    
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div>
                                <label class="col-sm-2 ">Penumpang</label>
                                <div class="col-sm-10" >
                                    <!-- <div class="row" > -->
                                        <div class="col-sm-12 row-input-penumpang"  >
                                            <div class="row" >
                                                <div  class="col-sm-6 col-md-6 col-lg-6"  >
                                                    <div class="input-group" >
                                                        <div class="input-group-btn addon-titel-penumpang" >
                                                            <select class="form-control input-titel "  >
                                                                <option value="mr" >Mr</option>
                                                                <option value="mrs" >Mrs</option>
                                                                <option value="ms" >Ms</option>
                                                            </select>
                                                        </div>
                                                        <input type="text" placeholder="Nama" class="form-control " name="nama" >
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6"  >
                                                    <div class="input-group" >
                                                    <input type="text" placeholder="Nomor Tiket" class="form-control " name="nomor_tiket" >
                                                        <div class="input-group-addon" style="border: none;" >
                                                            <a href="#" class="btn-reset-penumpang" ><i class="fa fa-history" ></i></a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <a class="btn btn-xs btn-primary btn-add-penumpang" ><i class="fa fa-plus-circle" ></i> Add Penumpang</a>
                                        
                                    <!-- </div> -->                                      
                                    </div>
                                </div>
                            </div>
                          

                        </div>
                   </div>

                    
                </div>
            </div>
            <table class="table table-condensed table-tiket-group no-border"  >
                <tbody>
                    <!-- <tr>
                        <td class="col-sm-2 col-md-2 col-lg-2" >
                            <label>Kode Pemesanan</label>
                        </td>
                        <td class="col-sm-6 col-md-6 col-lg-6" >
                            <input type="text" class="form-control input-clear input-sm" name="kode_pemesanan" />
                        </td>
                        <td class="col-sm-1 col-md-1 col-lg-1" >
                            <label>Harga</label>
                        </td>
                        <td class="col-sm-3 col-md-3 col-lg-3" >                                
                            <input type="text" class="form-control input-clear input-sm input-harga text-right" name="harga"/>
                        </td>
                    </tr> -->
                    <!-- <tr>
                        <td>
                            <label>Perjalanan</label>
                        </td>
                        <td colspan="3" >
                            <div class="row" >
                                <div class="col-sm-2 col-md-2 col-lg-2" >
                                    <div class="radio">
                                        <label>
                                          <input type="radio" name="perjalanan"  value="SJ" >
                                          Sekali Jalan
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2" >
                                    <div class="radio">
                                        <label>
                                          <input type="radio" name="perjalanan"  value="PP" >
                                          Pulang Pergi
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr> -->
                   <!--  <tr>
                        <td colspan="4" style="vertical-align: top;" >
                            <label>Penumpang :</label>       
                                                
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="no-padding" >
                            <table class="table table-condensed no-padding no-border" id="table-penumpang" style="margin-bottom: 5px;" >
                                <tbody>
                                    <tr class="row-penumpang" >
                                        <td style="width:75px;" >
                                            <select class="form-control input-titel "  >
                                                <option value="mr" >Mr</option>
                                                <option value="mrs" >Mrs</option>
                                                <option value="ms" >Ms</option>
                                            </select>
                                        </td>
                                        <td >
                                            <input type="text" placeholder="Nama" class="form-control " name="nama" >
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Nomor Tiket" class="form-control " name="nomor_tiket" >
                                        </td>
                                        <td style="width: 25px;" >
                                            <a href="#" class="btn-reset-penumpang" ><i class="fa fa-history" ></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"  >
                                            <a class="btn btn-xs btn-primary btn-add-penumpang" ><i class="fa fa-plus-circle" ></i> Add Penumpang</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr> -->
                    <tr>
                        <td colspan="4" class="no-padding" >
                            <div class="row" >
                                <div class="col-sm-6 col-md-6 col-lg-6" >
                                    <table class="table table-condensed no-border"  style="margin-bottom: 5px;">
                                        <tbody>
                                            <tr>
                                                <td colspan="2" >
                                                    <label>Maskapai :</label>
                                                </td>
                                            </tr>
                                            <tr class="row-maskapai" >
                                                <td colspan >
                                                    <input type="text" placeholder="Maskapai" class="form-control  input-maskapai" >
                                                </td>
                                                <td style="width: 25px" >
                                                    <a class="btn-reset-maskapai" ><i class="fa fa-history" ></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" >
                                                    <a class="btn btn-xs btn-primary btn-add-maskapai" ><i class="fa fa-plus-circle" ></i> Add Maskapai</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6" >
                                    <table class="table table-condensed no-border"  style="margin-bottom: 5px;">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" >
                                                    <label>Rute :</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Pergi" class="form-control  input-pergi" >
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Pulang" class="form-control  input-pulang" >
                                                </td>
                                                <td style="width: 25px" >
                                                    <a class="btn-reset-rute" ><i class="fa fa-history" ></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" >
                                                    <a class="btn btn-xs btn-primary btn-add-rute" ><i class="fa fa-plus-circle" ></i> Add Rute</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" ></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer" >
            <a class="btn btn-success" id="btn-add-pemesanan" ><i class="fa fa-plus-circle" ></i> Add Pemesanan</a>
        </div>
    </div>

</section><!-- /.content -->

<!-- ELEMENT FOR CLONE -->
<div class="hide"  >
    <table>
        <tbody id="row-penumpang-for-clone">
            <tr class="row-penumpang"  >
                <td style="width:75px;" >
                    <select class="form-control input-titel "  >
                        <option value="mr" >Mr</option>
                        <option value="mrs" >Mrs</option>
                        <option value="ms" >Ms</option>
                    </select>
                </td>
                <td >
                    <input type="text" placeholder="Nama" class="form-control " name="nama" >              
                </td>
                <td>
                    <input type="text" placeholder="Nomor Tiket" class="form-control " name="nomor_tiket" >
                    
                </td>
                <td>
                    <a href="#" class="btn-remove-penumpang" ><i class="fa fa-trash" ></i></a>
                </td>
            </tr>
        </tbody>
    </table>
    
</div>

<div class="hide" id="form-pemesanan-for-clone" >
    <div class="box box-solid " >
        <div class="box-header with-border" >
            <h3>DATA PEMESANAN (1)</h3>
        </div>
        <div class="box-body" >
            <a href="#" class="pull-right btn-box-tool btn-remove-input-group hide"  ><i class="fa fa-times"></i></a>
            <table class="table table-condensed table-tiket-group"  >
                <tbody>
                    <tr>
                        <td class="col-sm-2 col-md-2 col-lg-2" >
                            <label>Kode Pemesanan</label>
                        </td>
                        <td class="col-sm-6 col-md-6 col-lg-6" >
                            <input type="text" class="form-control input-clear input-sm" name="kode_pemesanan" />
                        </td>
                        <td class="col-sm-1 col-md-1 col-lg-1" >
                            <label>Harga</label>
                        </td>
                        <td class="col-sm-3 col-md-3 col-lg-3" >                                
                            <input type="text" class="form-control input-clear input-sm input-harga text-right" name="harga"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Perjalanan</label>
                        </td>
                        <td colspan="3" >
                            <div class="row" >
                                <div class="col-sm-2 col-md-2 col-lg-2" >
                                    <div class="radio">
                                        <label>
                                          <input type="radio" name="perjalanan"  value="SJ" >
                                          Sekali Jalan
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-md-2 col-lg-2" >
                                    <div class="radio">
                                        <label>
                                          <input type="radio" name="perjalanan"  value="PP" >
                                          Pulang Pergi
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="vertical-align: top;" >
                            <label>Penumpang :</label>                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="no-padding" >
                            <table class="table table-condensed no-padding no-border" id="table-penumpang" style="margin-bottom: 5px;" >
                                <tbody>
                                    <tr class="row-penumpang" >
                                        <td style="width:75px;" >
                                            <select class="form-control input-titel "  >
                                                <option value="mr" >Mr</option>
                                                <option value="mrs" >Mrs</option>
                                                <option value="ms" >Ms</option>
                                            </select>
                                        </td>
                                        <td >
                                            <input type="text" placeholder="Nama" class="form-control " name="nama" >
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Nomor Tiket" class="form-control " name="nomor_tiket" >
                                        </td>
                                        <td style="width: 25px;" >
                                            <a href="#" class="btn-reset-penumpang" ><i class="fa fa-history" ></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"  >
                                            <a class="btn btn-xs btn-primary btn-add-penumpang" ><i class="fa fa-plus-circle" ></i> Add Penumpang</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="no-padding" >
                            <div class="row" >
                                <div class="col-sm-6 col-md-6 col-lg-6" >
                                    <table class="table table-condensed no-border"  style="margin-bottom: 5px;">
                                        <tbody>
                                            <tr>
                                                <td colspan="2" >
                                                    <label>Maskapai :</label>
                                                </td>
                                            </tr>
                                            <tr class="row-maskapai" >
                                                <td colspan >
                                                    <input type="text" placeholder="Maskapai" class="form-control  input-maskapai" >
                                                </td>
                                                <td style="width: 25px" >
                                                    <a class="btn-reset-maskapai" ><i class="fa fa-history" ></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" >
                                                    <a class="btn btn-xs btn-primary btn-add-maskapai" ><i class="fa fa-plus-circle" ></i> Add Maskapai</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6" >
                                    <table class="table table-condensed no-border"  style="margin-bottom: 5px;">
                                        <tbody>
                                            <tr>
                                                <td colspan="3" >
                                                    <label>Rute :</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" placeholder="Pergi" class="form-control  input-pergi" >
                                                </td>
                                                <td>
                                                    <input type="text" placeholder="Pulang" class="form-control  input-pulang" >
                                                </td>
                                                <td style="width: 25px" >
                                                    <a class="btn-reset-rute" ><i class="fa fa-history" ></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" >
                                                    <a class="btn btn-xs btn-primary btn-add-rute" ><i class="fa fa-plus-circle" ></i> Add Rute</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" ></td>
                    </tr>
                </tbody>
            </table>
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
        // if(confirm('Anda akan menghapus data ini?')){
            var row = $(this).parent().parent();
            row.fadeOut(350,function(){
                row.remove();
            });
        // }

        return false;
    });
    // END REMOVE PENUMPAN

    // ADD PENUMPANG
    $(document).on('click','.btn-add-penumpang',function(){
        var row_penumpang = $('#row-penumpang-for-clone').children('tr').clone().insertBefore($(this).parent().parent());
        // set autocomplete maskapai
        var input_maskapai = row_penumpang.children('td:first').children('div').children('input');

        input_maskapai.autocomplete({
            serviceUrl: 'api/get-auto-complete-maskapai',
            params: {  
                        'nama' : function() {
                                    return input_maskapai.val();
                                },
                    },
            onSelect:function(suggestions){
                $(this).data('maskapaiid',suggestions.data);
                $(this).attr('readonly','readonly');
                $(this).parent().parent().next().children('div').children('input').focus();
            }
        });

        // $(this).hide();

        // fokuskan ke input nama di row baru Penumpang
        // row_input_penumpang.find('select[name=titel]').focus();

        // format harga auto numeric
        $('.input-harga').autoNumeric('init',{
            vMin:'0',
            vMax:'9999999999'
        });
    });
    // END OF ADD PENUMPANG

    // AUTOCOMPLETE MASKAPAI
    var init_input_maskapai = $('.input-maskapai');
    init_input_maskapai.autocomplete({
        serviceUrl: 'api/get-auto-complete-maskapai',
        params: {  
                    'nama' : function() {
                                return init_input_maskapai.val();
                            },
                },
        onSelect:function(suggestions){
            $(this).attr('data-maskapaiid',suggestions.data);
            $(this).attr('readonly','readonly');
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

    // END OF AUTOCOMPLETE MASKAPAI

    // // HITUNG TOTAL
    $(document).on('keyup','.input-harga',function(){
       hitungTotal();
    });
    

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
        var input_maskapai = $(this).parent().prev().children('input');
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
        var row_penumpang = $(this).parent().parent();
        row_penumpang.children('td:first').next().children('input').val('');
        row_penumpang.children('td:first').next().next().children('input').val('');
        // row_penumpang.children('td:first').hide();

        return false;
    });
    // END OF RESET PENUMPANG

    // BTN COPY

    // ------------- COPY MASKAPAI ----------------------
    $(document).on('click','.btn-copy-maskapai',function(){
        var btn_copy = $(this);        
        var upper_row = $(this).parent('div').parent('div').parent('td').parent('tr').prev();
        var tbody = upper_row.parent('tbody');
        var first_row = tbody.children('tr:first');
        var input_maskapai_upper;
        var input_maskapai_current = btn_copy.parent().prev();
        
        if(upper_row.is(first_row)){
            // jika first row
            input_maskapai_upper = upper_row.children('td:first').children('input');
        }else{
            input_maskapai_upper = upper_row.children('td:first').children('div').children('input');
        }

        input_maskapai_current.val(input_maskapai_upper.val());
        input_maskapai_current.attr('data-maskapaiid',input_maskapai_upper.data('maskapaiid'));    
        input_maskapai_current.attr('readonly','readonly');    
    });

    // ------------ COPY RUTE --------------------
    $(document).on('click','.btn-copy-rute',function(){
        var btn_copy = $(this);        
        var upper_row = $(this).parent('div').parent('div').parent('td').parent('tr').prev();
        var tbody = upper_row.parent('tbody');
        var first_row = tbody.children('tr:first');
        var input_rute_upper;
        var input_rute_current = btn_copy.parent().prev();
        
        if(upper_row.is(first_row)){
            // jika first row
            input_rute_upper = upper_row.children('td:first').next().children('input');
        }else{
            input_rute_upper = upper_row.children('td:first').next().children('div').children('input');
        }

        input_rute_current.val(input_rute_upper.val());
    });

    // ------------ COPY NAMA --------------------
    $(document).on('click','.btn-copy-nama',function(){
        var btn_copy = $(this);        
        var upper_row = $(this).parent('div').parent('div').parent('td').parent('tr').prev();
        var tbody = upper_row.parent('tbody');
        var first_row = tbody.children('tr:first');
        var input_nama_upper;
        var input_nama_current = btn_copy.parent().prev();
        
        if(upper_row.is(first_row)){
            // jika first row
            input_nama_upper = upper_row.children('td:first').next().next().next().children('input');
        }else{
            input_nama_upper = upper_row.children('td:first').next().next().next().children('div').children('input');
        }

        input_nama_current.val(input_nama_upper.val());
    });

    // ------------ COPY TIKET --------------------
    $(document).on('click','.btn-copy-nomor-tiket',function(){
        var btn_copy = $(this);        
        var upper_row = $(this).parent('div').parent('div').parent('td').parent('tr').prev();
        var tbody = upper_row.parent('tbody');
        var first_row = tbody.children('tr:first');
        var input_nomor_tiket_upper;
        var input_nomor_tiket_current = btn_copy.parent().prev();
        
        if(upper_row.is(first_row)){
            // jika first row
            input_nomor_tiket_upper = upper_row.children('td:first').next().next().next().next().children('input');
        }else{
            input_nomor_tiket_upper = upper_row.children('td:first').next().next().next().next().children('div').children('input');
        }

        input_nomor_tiket_current.val(input_nomor_tiket_upper.val());
    });

    // BTN COPY

    // --------------- ADD MASKAPAI ----------------------
    $(document).on('click','.btn-add-maskapai',function(){
        var btn = $(this);
        btn.parent('td').parent('tr').before('<tr class="row-maskapai" ><td><input type="text" placeholder="Maskapai" class="form-control  input-maskapai" ></td><td style="width: 25px;" ><a class="btn-remove-maskapai" ><i class="fa fa-trash" ></i></a></td></tr>');

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
                $(this).attr('readonly','readonly');
                // $(this).parent().next().children('input').focus();
            }
        });

         // fokuskan
         input_maskapai.focus();


    });
    // --------------- END ADD MASKAPAI ----------------------

    // --------------- ADD RUTE ----------------------
    $(document).on('click','.btn-add-rute',function(){
        var btn = $(this);
        var new_rute = '<tr><td><input type="text" placeholder="Pergi" class="form-control  input-pergi" ></td><td><input type="text" placeholder="Pulang" class="form-control  input-pulang" ></td><td style="width: 25px" ><a class="btn-remove-rute" ><i class="fa fa-trash" ></i></a></td></tr>';
        new_rute = $.parseHTML(new_rute);
        // alert(new_rute);
        btn.parent('td').parent('tr').before(new_rute);

        // cek apakah sekali jalan atau PP
        var form_pemesanan = btn.parent('td').parent('tr').parent('tbody').parent('table').parent('div').parent('div').parent('td').parent('tr').parent('tbody').parent('table').parent('div').parent('div');
        // form_pemesanan.hide();
        var is_sj = form_pemesanan.find('input[name=perjalanan]:checked').val() == 'SJ' ;
        if(is_sj){
            // disable input rute pulang
            var input_rute_pulang = btn.parent('td').parent('tr').prev().children('td:first').next().children('input');
            input_rute_pulang.attr('readonly','readonly');
            input_rute_pulang.val('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
        }
        // alert(is_app);


        // var new_rute_obj = jQuery.parseHTML(new_rute);
        // new_rute_obj.hide();
    });
    // --------------- END ADD MASKAPAI ----------------------

    // ---------------- PERJALANAN CHANGE --------------------
    // $('input[name=perjalanan]').change(function(){
    //     if($(this).val() == 'SJ' ) {
    //         $('.input-pergi').removeAttr('readonly');
    //         $('.input-pulang').attr('readonly','readonly');
    //     }else{
    //         // if PP
    //         $('.input-pergi').removeAttr('readonly');
    //         $('.input-pulang').removeAttr('readonly');
    //     }
    // });

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
        var form_pemesanan = $('#form-pemesanan-for-clone').children('div').clone().insertAfter($(this).parent().parent());

        // set title form pemesanan
        form_pemesanan_index++;
        form_pemesanan.children('div:first').children('h3').text('DATA PEMESANAN ('+form_pemesanan_index+')');

        // add class
        form_pemesanan.addClass('form-pemesanan');

        form_pemesanan.hide();
        form_pemesanan.slideDown(300);

        // pindahkan button
        var btn_add_pemesanan = $(this);
        btn_add_pemesanan.fadeOut(250,function(){
            btn_add_pemesanan.appendTo(form_pemesanan.children('div:last'));
            btn_add_pemesanan.show();    
        });

        // autocomplete maskapai
        var input_maskapai = form_pemesanan.find('input.input-maskapai');
         input_maskapai.autocomplete({
            serviceUrl: 'api/get-auto-complete-maskapai',
            params: {  
                        'nama' : function() {
                                    return input_maskapai.val();
                                },
                    },
            onSelect:function(suggestions){
                $(this).attr('data-maskapaiid',suggestions.data);
                $(this).attr('readonly','readonly');
                // $(this).parent().next().children('input').focus();
            }
        });
        

        // add close button
        form_pemesanan.children('div:first').append('<div class="pull-right box-tools" ><a href="#" class="btn-remove-form-pemesanan" ><i class="fa fa-close" ></i></a></div>');

         $('html, body').animate({
            scrollTop: form_pemesanan.offset().top
        }, 1500);


       return false;
    });
    // ----------------- END ADD FORM PEMESANAN ----------------------

    // ------------------ REMOVE FORM PEMESANAN ----------------------
    $(document).on('click','.btn-remove-form-pemesanan',function(){

        if(confirm('Anda akan menghapus data ini?')){
            var form_pemesanan = $(this).parent('div').parent('div').parent('div');

            form_pemesanan_upper = form_pemesanan.prev();

            // pindahkan button add pemesanan
            var btn_add_pemesanan = form_pemesanan.children('div:last').children('a');
            btn_add_pemesanan.fadeOut(250);            

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


    

    // // $('#btn-test').click(function(){
    // //     hitungTotal();
    // //     return false;
    // // });
    // // END OF FUNGSI HITUNG TOTAL KESELURUHAN

})(jQuery);
</script>
@append