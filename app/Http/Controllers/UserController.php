<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	public function index(){

		$users = \DB::table('users')->get();
		
		return view('setting.user.index',[
				'data' => $users
			]);
	}

	public function create(){
		return view('setting.user.create');
	}

	public function insert(Request $req){
		//register user
		\DB::table('users')->insert([
		   'username' => $req->username,
		   'name' => strtoupper($req->nama),
		   'email' => $req->username.'@invapp.app',
		   'password' => bcrypt($req->password),
		   'verified' => 1,
		]);

		return redirect('setting/user');
	}

	public function edit($id){
		$data = \DB::table('users')->find($id);
		return view('setting.user.edit',[
				'data' => $data
			]);
	}

	public function update(Request $req){
		//register user
		\DB::table('users')
			->where('id',$req->id)
			->update([
			   'username' => $req->username,
			   'name' => strtoupper($req->nama),
			   // 'email' => $req->username.'@invapp.app',
			   // 'password' => bcrypt($req->password),
			   // 'verified' => 1,
			]);

		// update password
		if($req->password != ""){
			\DB::table('users')
			->where('id',$req->id)
			->update([
			   'password' => bcrypt($req->password)
			   // 'name' => $req->nama,
			   // 'email' => $req->username.'@invapp.app',
			   // 'password' => bcrypt($req->password),
			   // 'verified' => 1,
			]);
		}

		return redirect('setting/user');
	}

	public function delete(Request $req){
		$dataid = json_decode($req->dataid);
		return \db::transaction(function()use($dataid){
			// delete dari database
			foreach($dataid as $dt){
				\DB::table('users')->delete($dt->id);
			}

			return redirect('setting/user');

		});
	}

}
