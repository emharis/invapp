@extends('layouts.master')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Beranda
    </h1>
<!--    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
    </ol>-->
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{$jml_invoice_tiket}}</h3>
                  <p>Tiket Pesawat</p>
                </div>
                <div class="icon">
                  <i class="ion ion-jet"></i>
                </div>
                <a href="invoice/tiket" class="small-box-footer">Tampilkan <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{$jml_invoice_hotel}}</h3>
                  <p>Reservasi Hotel</p>
                </div>
                <div class="icon">
                  <i class="ion ion-home"></i>
                </div>
                <a href="invoice/hotel" class="small-box-footer">Tampilkan <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{$jml_invoice_lain}}</h3>
                  <p>Invoice Lain</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-paper"></i>
                </div>
                <a href="invoice/invoice-lain" class="small-box-footer">Tampilkan <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><i class="fa fa-file-o" ></i></h3>
                  <p>Cetak Kwitansi</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-paper-outline"></i>
                </div>
                <a href="kwitansi" class="small-box-footer">Tampilkan <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-blue">
                <div class="inner">
                  <h3>Rp</h3>
                  <p>Laporan Finansial</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Tampilkan <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->


            @if(Auth::user()->username == 'admin')
              <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-maroon">
                  <div class="inner">
                    <h3><i class="fa fa-users" ></i></h3>
                    <p>Pengguna</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-ios-people"></i>
                  </div>
                  <a href="setting/user" class="small-box-footer">Tampilkan <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div><!-- ./col -->
            
            @else
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-purple">
                <div class="inner">
                  <h3><i class="fa fa-user" ></i></h3>
                  <p>Profil</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person"></i>
                </div>
                <a href="profile" class="small-box-footer">Tampilkan <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->

            @endif

            

          </div><!-- /.row -->

</section><!-- /.content -->
@stop