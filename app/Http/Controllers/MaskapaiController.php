<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MaskapaiController extends Controller
{
	public function index(){

		$data = \DB::table('maskapai')->orderBy('created_at','desc')->get();
		
		return view('master.maskapai.index',[
				'data' => $data
			]);
	}

	// create new maskapai
	public function create(){
		return view('master.maskapai.create');
	}

	// insert new maskapai
	public function insert(Request $req){
		\DB::table('maskapai')->insert([
				'nama' => $req->nama,
				'user_id' => \Auth::user()->id
			]);

		return redirect('master/maskapai');
	}

	// edit data maskapai
	public function edit($maskapai_id){
		$data = \DB::table('maskapai')->find($maskapai_id);

		return view('master.maskapai.edit',[
				'data'=>$data
			]);
	}

	// simpan edit 
	public function update(Request $req){
		\DB::table('maskapai')->whereId($req->maskapai_id)->update([
				'nama' => $req->nama
			]);

		return redirect('master/maskapai');
	}

	public function delete(Request $req){
		return \DB::transaction(function()use($req){
			$dataid = json_decode($req->dataid);
			foreach($dataid  as $dt){
				\DB::table('maskapai')->delete($dt->id);
			}

			return redirect('master/maskapai');
		});
	}

}
