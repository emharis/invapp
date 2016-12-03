@extends('layouts.master')

@section('styles')
<style>
   
</style>
@append

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <a href="master/hotel" >Master Hotel</a> 
        <i class="fa fa-angle-double-right" ></i> Create
    </h1>
</section>

<!-- Main content -->
<section class="content">
  {{-- <form method="POST" action="master/hotel/insert" > --}}
    <div class="box box-solid" >
      <div class="box-body" >
        <form method="POST" action="master/hotel/update">
            <input type="hidden" name="hotel_id" value="{{$data->id}}">
            <table class="table table-bordered table-condensed" >
                <tbody>
                    <tr>
                        <td class="col-lg-2 col-md-2 col-sm-2" >
                            <label>Nama</label>
                        </td>
                        <td>
                            <input type="text" name="nama" class="form-control" value="{{$data->nama}}" required autofocus autocomplete="off" required >
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-primary" id="btn-save" >Save</button>
                            <a class="btn btn-danger" href="master/hotel" >Cancel</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
  {{-- </form> --}}
</section><!-- /.content -->

@stop

@section('scripts')

@append