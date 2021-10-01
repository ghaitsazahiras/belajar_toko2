<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller{

    public function show(){
        return Customers::all();
    }

    public function detail($id){
        if(Customers::where('id_pelanggan', $id)->exists()){
            $data = DB::table('customers')
            ->where('customers.id_pelanggan', '=', $id)
            ->get();
            return Response()->json($data);
        }
        else{
            return Response()->json(['message' => 'Tidak Ditemukan']);
        }
    }

    public function store(Request $request){
        $validator=Validator::make($request->all(),
        ['nama' => 'required',
        'alamat' => 'required',
        'telp' => 'required',
        'username' => 'required',
        'password' => 'required']); 
        
        if($validator->fails()){ 
            return Response()->json($validator->errors());
        }

        $simpan = Customers::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat, 
            'telp' => $request->telp,
            'username' => $request->username, 
            'password' => Hash::make($request->password)]);
            
        if($simpan){
            return Response()->json(['status' => 1]);
        }else {
            return Response()->json(['status' => 0]);
        } 
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        ['nama' => 'required',
        'alamat' => 'required',
        'telp' => 'required',
        'username' => 'required',
        'password' => 'required']);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $ubah = Customers::where('id_pelanggan', $id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat, 
            'telp' => $request->telp,
            'username' => $request->username, 
            'password' => Hash::make($request->password)]);
            
            if($ubah) {
                return Response()->json(['status' => 1]);
            }else{
                return Response()->json(['status' => 0]);
            }
    }

    public function destroy($id){
        $hapus = Customers::where('id_pelanggan', $id)->delete(); 
        if($hapus) { 
            return Response()->json(['status' => 1]);
        }else { 
            return Response()->json(['status' => 0]); 
        }
    }
}
