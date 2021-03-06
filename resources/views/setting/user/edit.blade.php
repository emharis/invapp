@extends('layouts.master')

@section('styles')
<style>
   .form-horizontal .control-label{
        text-align: left;
    }
</style>
@append

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <a href="setting/user" >Pengaturan Pengguna</a> 
        <i class="fa fa-angle-double-right" ></i> Edit
    </h1>
</section>

<!-- Main content -->
<section class="content">
  {{-- <form method="POST" action="setting/user/insert" > --}}
    <div class="box box-solid" >
        <div class="box-header with-border" style="padding-top:5px;padding-bottom:5px;" >
            <label><h3 style="margin:0;padding:0;font-weight:bold;" >Data Pengguna</h3></label>
        </div>
    <form method="POST" action="setting/user/update" class="form-horizontal" >
        <input type="hidden" name="id" value="{{$data->id}}">
        <div class="box-body" >
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
              <div class="col-sm-10">
                <input type="text" name="username" class="form-control"  autofocus autocomplete="off" required value="{{$data->username}}" {{$data->username == 'admin' ? 'readonly':''}} >                
              </div>
            </div> 
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10">
                <input type="text" name="password" class="form-control"  autocomplete="off" required placeholder="Masukkan untuk merubah password" >                
              </div>
            </div> 
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Nama Cetak</label>
              <div class="col-sm-10">
                <input type="text" name="nama" class="form-control text-uppercase"  autocomplete="off" required value="{{$data->name}}" >                
              </div>
            </div>       
        </div>
        <div class="box-footer" >
            <button type="submit" class="btn btn-primary" id="btn-save" ><i class="fa fa-save" ></i> Simpan</button>
            <a class="btn btn-danger" href="setting/user" ><i class="fa fa-close" ></i> Batal</a>
        </div>
    </form>
  {{-- </form> --}}
</section><!-- /.content -->

@stop

@section('scripts')

@append