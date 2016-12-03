<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HotelController extends Controller
{
	public function index(){

		$data = \DB::table('hotel')->orderBy('created_at','desc')->get();
		
		return view('master.hotel.index',[
				'data' => $data
			]);
	}

	// create new hotel
	public function create(){
		return view('master.hotel.create');
	}

	// insert new hotel
	public function insert(Request $req){
		\DB::table('hotel')->insert([
				'nama' => $req->nama,
				'user_id' => \Auth::user()->id
			]);

		return redirect('master/hotel');
	}

	// edit data hotel
	public function edit($hotel_id){
		$data = \DB::table('hotel')->find($hotel_id);

		return view('master.hotel.edit',[
				'data'=>$data
			]);
	}

	// simpan edit 
	public function update(Request $req){
		\DB::table('hotel')->whereId($req->hotel_id)->update([
				'nama' => $req->nama
			]);

		return redirect('master/hotel');
	}

	public function delete(Request $req){
		return \DB::transaction(function()use($req){
			$dataid = json_decode($req->dataid);
			foreach($dataid  as $dt){
				\DB::table('hotel')->delete($dt->id);
			}

			return redirect('master/hotel');
		});
	}

}
