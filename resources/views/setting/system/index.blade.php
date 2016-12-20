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
        Pengaturan Sistem
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Data Perusahaan</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Pengaturan Invoice & Kwitansi</a></li>                  
                  {{-- <li><a href="#tab_3" data-toggle="tab">Setting Umum</a></li>                   --}}
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1">
                    <form name="form_data_perusahaan" method="POST" action="setting/system/update-data-perusahaan" enctype="multipart/form-data" >
                        <table class="table no-border" >
                            <tbody>
                                <tr>
                                    <td class="col-sm-2" >
                                        <label>Nama Perusahaan</label>
                                    </td>
                                    <td>
                                        <input name="nama_perusahaan" class="form-control" maxlength="40" placeholder="Nama Perusahaan" value="{{$setting['nama_perusahaan']}}" >
                                    </td>
                                    <td rowspan="6" class="col-sm-2" >
                                        <img id="img-logo" src="img\{{$setting['logo']}}" class="col-sm-12" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                        <label>Alamat</label>
                                    </td>
                                    <td>
                                        <input name="alamat" class="form-control" maxlength="40" placeholder="Alamat"  value="{{$setting['alamat']}}">
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                        
                                    </td>
                                    <td>
                                        <input name="alamat_2" class="form-control" maxlength="40" placeholder="Alamat" value="{{$setting['alamat_2']}}" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                        <label>Telepon</label>
                                    </td>
                                    <td>
                                        <input name="telepon" class="form-control"  placeholder="Telepon" value="{{$setting['telepon']}}" >
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td class="col-sm-2" >
                                        <label>Telepon</label>
                                    </td>
                                    <td>
                                        <input name="telepon_2" class="form-control"  placeholder="Telepon" value="{{$setting['telepon_2']}}" >
                                    </td>
                                </tr> --}}
                                <tr>
                                    <td class="col-sm-2" >
                                        <label>Fax</label>
                                    </td>
                                    <td>
                                        <input name="fax" class="form-control"  placeholder="Fax" value="{{$setting['fax']}}" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                        <label>Email</label>
                                    </td>
                                    <td>
                                        <input name="email" class="form-control"  placeholder="Email" value="{{$setting['email']}}" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                        <label>Website</label>
                                    </td>
                                    <td>
                                        <input name="website" class="form-control"  placeholder="Email" value="{{$setting['website']}}" >
                                    </td>
                                    <td>
                                        <input type="file" accept="image/*" name="logo" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                    </td>
                                    <td colspan="2" >
                                        <button class="btn btn-primary" type="submit" ><i class="fa fa-save" ></i> Simpan</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </form>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2">
                    <form name="form_setting_invoice" method="POST" action="setting/system/update-setting-invoice" >
                        <table class="table no-border" >
                            <tbody>
                                <tr>
                                    <td class="col-sm-2" >
                                        <label>Catatan : </label>
                                    </td>
                                    <td>
                                        <input name="catatan_1" style="font-weight: bold;text-decoration: underline;" class="form-control" maxlength="100" value="{{$setting_invoice['catatan_1']}}" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                       
                                    </td>
                                    <td>
                                        <input name="catatan_2" class="form-control" maxlength="100" value="{{$setting_invoice['catatan_2']}}">
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                        
                                    </td>
                                    <td>
                                        <input name="catatan_3" class="form-control" maxlength="100" value="{{$setting_invoice['catatan_3']}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                        
                                    </td>
                                    <td>
                                        <input name="catatan_4" class="form-control" maxlength="100" value="{{$setting_invoice['catatan_4']}}" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                       
                                    </td>
                                    <td>
                                        <input name="catatan_5" class="form-control" maxlength="100" value="{{$setting_invoice['catatan_5']}}" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                       
                                    </td>
                                    <td>
                                        <input name="catatan_6" class="form-control" maxlength="100" value="{{$setting_invoice['catatan_6']}}" >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-sm-2" >
                                       
                                    </td>
                                    <td>
                                        <input name="catatan_7" class="form-control" maxlength="100" value="{{$setting_invoice['catatan_7']}}" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Kota (Kwitansi) :</label>
                                    </td>
                                    <td>
                                        <input type="text" name="kwitansi_kota" class="form-control" value="{{$setting_invoice['kwitansi_kota']}}" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                    </td>
                                    <td colspan="2" >
                                        <button class="btn btn-primary" ><i class="fa fa-save" ></i> Simpan</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form> 

                  </div><!-- /.tab-pane -->
                  {{-- <div class="tab-pane" id="tab_3">
                    <form name="form_kwitansi" method="POST" action="kwitansi/cetak" class="form-horizontal" target="_blank">
                        <div class="row" >
                            <div class="col-sm-6" >
                                <div class="form-group">
                                  <label class="col-sm-4 control-label">Nomor Urut Invoice Tiket</label>
                                  <div class="col-sm-2">
                                        <input type="text" name="invoice_tiket_counter" class="form-control input-clear"  autofocus required readonly value="{{$setting_invoice['inv_tiket_counter']}}" >
                                  </div>
                                  <div class="col-sm-2">
                                        <a class="btn btn-danger" id="btn-reset-tiket" ><i class="fa fa-refresh" ></i> Reset</a>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label">Nomor Urut Invoice Hotel</label>
                                  <div class="col-sm-2">
                                        <input type="text" name="invoice_hotel_counter" class="form-control input-clear"  autofocus required readonly value="{{$setting_invoice['inv_hotel_counter']}}">
                                  </div>
                                  <div class="col-sm-2">
                                        <a class="btn btn-danger" id="btn-reset-hotel" ><i class="fa fa-refresh" ></i> Reset</a>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label">Nomor Urut Invoice Lain</label>
                                  <div class="col-sm-2">
                                        <input type="text" name="invoice_lain_counter" class="form-control input-clear"  autofocus required readonly value="{{$setting_invoice['inv_lain_counter']}}" >
                                  </div>
                                  <div class="col-sm-2">
                                        <a class="btn btn-danger" id="btn-reset-lain" ><i class="fa fa-refresh" ></i> Reset</a>
                                  </div>
                                </div>
                            </div>
                            <div class="col-sm-6" >
                                <div class="form-group">
                                  <label class="col-sm-4 control-label">Prefix Invoice Tiket</label>
                                  <div class="col-sm-2">
                                        <input type="text" name="invoice_tiket_prefix" class="form-control input-clear"  autofocus required readonly value="{{$setting_invoice['inv_tiket_prefix']}}" >
                                  </div>
                                  <div class="col-sm-2">
                                        <a class="btn btn-primary" id="btn-save-prefix-tiket" ><i class="fa fa-save" ></i> Save</a>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label">Prefix Invoice Hotel</label>
                                  <div class="col-sm-2">
                                        <input type="text" name="invoice_hotel_prefix" class="form-control input-clear"  autofocus required readonly value="{{$setting_invoice['inv_hotel_prefix']}}">
                                  </div>
                                  <div class="col-sm-2">
                                        <a class="btn btn-primary" id="btn-save-prefix-hotel" ><i class="fa fa-save" ></i> Save</a>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label">Prefix Invoice Lain</label>
                                  <div class="col-sm-2">
                                        <input type="text" name="invoice_lain_prefix" class="form-control input-clear"  autofocus required readonly value="{{$setting_invoice['inv_lain_prefix']}}" >
                                  </div>
                                  <div class="col-sm-2">
                                        <a class="btn btn-primary" id="btn-save-prefix-lain" ><i class="fa fa-save" ></i> Save</a>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </form>

                  </div> --}}<!-- /.tab-pane -->
                  
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->

</section><!-- /.content -->

@stop

@section('scripts')
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/jqueryform/jquery.form.min.js" type="text/javascript"></script>

<script type="text/javascript">
(function ($) {

    //submit form data perusahaan
    $('form[name=form_data_perusahaan]').ajaxForm(function(){
        alert('Data perusahaan telah diperbaharui');
    });

    $('form[name=form_setting_invoice]').ajaxForm(function(){
        alert('Data pengaturan invoice telah diperbaharui');
    });


    // tampiklan logo
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-logo').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("input[name=logo]").change(function(){
        readURL(this);
    });

})(jQuery);
</script>
@append