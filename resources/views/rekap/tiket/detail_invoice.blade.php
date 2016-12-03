
<div class="row"  >
	@foreach($data_pemesanan as $dp)
		{{-- <div class="col-sm-8 col-md-8 col-lg-8 " > --}}
			<div class="box box-primary center-block" style="width:800px;">
				<div class="box-header with-border">
				  <h3 class="box-title">DATA PEMESANAN</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				<form class="form-horizontal">
				  <div class="box-body">
				    <div class="form-group">
				      <label class="col-sm-2 control-label">KODE PEMESANAN</label>
				      <div class="col-sm-10">
				        <input type="text" class="form-control" value="{{$dp->kode_pemesanan}}">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="col-sm-2 control-label">MASKAPAI</label>
				      <div class="col-sm-10">
				        <input type="text" class="form-control" value="{{$dp->maskapai}}">
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="col-sm-2 control-label">RUTE</label>
				      <div class="col-sm-10">
				        <div class="input-group" >
				        	<input class="form-control" value="{{$dp->pulang}}">
				        	<input class="form-control" value="{{$dp->pergi}}">
				        </div>
				      </div>
				    </div>
				    <div class="form-group">
				      <label class="col-sm-2 control-label">PENUMPANG</label>
				      <div class="col-sm-10">
				        
				      </div>
				    </div>
				  </div><!-- /.box-body -->
				  
				</form>
			</div>
		{{-- </div> --}}
	

	{{-- <div class="col-sm-10 col-md-10 col-lg-10" >
		<table class="table table-bordered table-condensed table-left" >
			<tbody>
				<tr>
					<td>
						<label>Kode Pemesanan</label>
					</td>
					<td colspan="2" >
						{{$dp->kode_pemesanan}}
					</td>
				</tr>
				<tr>
					<td>
						<label>Maskapai</label>
					</td>
					<td colspan="2" >
						{{$dp->maskapai}}
					</td>
				</tr>
				<tr>
					<td>
						<label>Rute</label>
					</td>
					<td>
						{{$dp->pergi}}
					</td>
					<td>
						{{$dp->pulang}}
					</td>
				</tr>
				<tr>
					<td colspan="3" >
						<label>Penumpang</label>
					</td>
				</tr>
				<tr>
					<td colspan="3" >
						<table class="table " >
							<tbody>
								@foreach($dp->data_penumpang as $dpg)
									<tr>
										<td>{{$dpg->titel}}</td>
										<td>{{$dpg->nama}}</td>
										<td>{{$dpg->nomor_tiket}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td  >
						<label>Harga</label>
					</td>
					<td colspan="2">
						<label class="uang">{{$dp->harga}}</label>
					</td>
				</tr>
			</tbody>
		</table>
	</div> --}}
	@endforeach
</div>



