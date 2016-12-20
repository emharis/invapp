<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
	public function index(){

		// $data = \DB::table('hotel')->orderBy('created_at','desc')->get();

		$setting['nama_perusahaan'] = \DB::table('appsetting')->whereName('nama_perusahaan')->first()->value;
		$setting['alamat'] = \DB::table('appsetting')->whereName('alamat')->first()->value;
		$setting['alamat_2'] = \DB::table('appsetting')->whereName('alamat_2')->first()->value;
		$setting['telepon'] = \DB::table('appsetting')->whereName('telp')->first()->value;
		// $setting['telepon_2'] = \DB::table('appsetting')->whereName('telp_2')->first()->value;
		$setting['fax'] = \DB::table('appsetting')->whereName('fax')->first()->value;
		$setting['email'] = \DB::table('appsetting')->whereName('email')->first()->value;
		$setting['website'] = \DB::table('appsetting')->whereName('website')->first()->value;
		$setting['logo'] = \DB::table('appsetting')->whereName('logo')->first()->value;

		$setting_invoice['catatan_1'] = \DB::table('appsetting')->whereName('inv_catatan_1')->first()->value;
		$setting_invoice['catatan_2'] = \DB::table('appsetting')->whereName('inv_catatan_2')->first()->value;
		$setting_invoice['catatan_3'] = \DB::table('appsetting')->whereName('inv_catatan_3')->first()->value;
		$setting_invoice['catatan_4'] = \DB::table('appsetting')->whereName('inv_catatan_4')->first()->value;
		$setting_invoice['catatan_5'] = \DB::table('appsetting')->whereName('inv_catatan_5')->first()->value;
		$setting_invoice['catatan_6'] = \DB::table('appsetting')->whereName('inv_catatan_6')->first()->value;
		$setting_invoice['catatan_7'] = \DB::table('appsetting')->whereName('inv_catatan_7')->first()->value;
		$setting_invoice['kwitansi_kota'] = \DB::table('appsetting')->whereName('kwitansi_kota')->first()->value;
		
		$setting_invoice['inv_tiket_counter'] = \DB::table('appsetting')->whereName('inv_tiket_counter')->first()->value;
		$setting_invoice['inv_hotel_counter'] = \DB::table('appsetting')->whereName('inv_hotel_counter')->first()->value;
		$setting_invoice['inv_lain_counter'] = \DB::table('appsetting')->whereName('inv_lain_counter')->first()->value;

		$setting_invoice['inv_tiket_prefix'] = \DB::table('appsetting')->whereName('inv_tiket_prefix')->first()->value;
		$setting_invoice['inv_hotel_prefix'] = \DB::table('appsetting')->whereName('inv_hotel_prefix')->first()->value;
		$setting_invoice['inv_lain_prefix'] = \DB::table('appsetting')->whereName('inv_lain_prefix')->first()->value;


		
		return view('setting.system.index',[
				'setting' => $setting,
				'setting_invoice' => $setting_invoice,
			]);
	}

	public function updateDataPerusahaan(Request $req){
		\DB::table('appsetting')->whereName('nama_perusahaan')->update(['value' => $req->nama_perusahaan]);
		\DB::table('appsetting')->whereName('alamat')->update(['value' => $req->alamat]);
		\DB::table('appsetting')->whereName('alamat_2')->update(['value' => $req->alamat_2]);
		\DB::table('appsetting')->whereName('telp')->update(['value' => $req->telepon]);
		// \DB::table('appsetting')->whereName('telp_2')->update(['value' => $req->telepon_2]);
		\DB::table('appsetting')->whereName('fax')->update(['value' => $req->fax]);
		\DB::table('appsetting')->whereName('email')->update(['value' => $req->email]);
		\DB::table('appsetting')->whereName('website')->update(['value' => $req->website]);

		if ($req->hasFile('logo')) {
	      $destinationPath = 'img'; // upload path
	      $extension = $req->logo->getClientOriginalExtension(); // getting image extension
	      $fileName = 'logo_perusahaan.' . $extension;//rand(11111,99999).'.'.$extension; // renameing image
	      $req->logo->move($destinationPath, $fileName); // uploading file to given path

	      // update database
			\DB::table('appsetting')->whereName('logo')->update(['value' => $fileName]);

	      // sending back with message
	      \Session::flash('success', 'Upload successfully'); 
	      // return Redirect::to('upload');
	    }
	}

	public function updateSettingInvoice(Request $req){
		\DB::table('appsetting')->whereName('inv_catatan_1')->update(['value' => $req->catatan_1]);
		\DB::table('appsetting')->whereName('inv_catatan_2')->update(['value' => $req->catatan_2]);
		\DB::table('appsetting')->whereName('inv_catatan_3')->update(['value' => $req->catatan_3]);
		\DB::table('appsetting')->whereName('inv_catatan_4')->update(['value' => $req->catatan_4]);
		\DB::table('appsetting')->whereName('inv_catatan_5')->update(['value' => $req->catatan_5]);
		\DB::table('appsetting')->whereName('inv_catatan_6')->update(['value' => $req->catatan_6]);
		\DB::table('appsetting')->whereName('inv_catatan_7')->update(['value' => $req->catatan_7]);
		\DB::table('appsetting')->whereName('kwitansi_kota')->update(['value' => $req->kwitansi_kota]);

		
	}

}
