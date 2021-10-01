<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller{

    public function show(){
        $data = DB::table('order')
            ->join('customers', 'order.id_pelanggan', '=' , 'customers.id_pelanggan')
            ->join('officer', 'order.id_petugas', '=' , 'officer.id_petugas')
            ->select('order.id_transaksi', 'order.tgl_transaksi', 'customers.id_pelanggan', 'officer.id_petugas')
            ->get();
        return Response()->json($data);
    }

    public function detail($id){
        if(Order::where('id_transaksi', $id)->exists()){
            $data_order = DB::table('order')
            ->join('customers', 'order.id_pelanggan', '=' , 'customers.id_pelanggan')
            ->join('officer', 'order.id_petugas', '=' , 'officer.id_petugas')
            ->select('order.id_transaksi', 'order.tgl_transaksi', 'customers.id_pelanggan', 'officer.id_petugas')
            ->where('order.id_transaksi', '=', $id)
            ->get();
            return Response()->json($data_order);
        }else{
            return Response()->json(['message' => 'Tidak Ditemukan']);
        }
    }

    public function store(Request $request){
        $validator=Validator::make($request->all(),
        ['id_pelanggan' => 'required',
        'id_petugas' => 'required']); 
        
        if($validator->fails()){ 
            return Response()->json($validator->errors());
        }

        $simpan = Order::create([
            'id_pelanggan' => $request->id_pelanggan,
            'id_petugas' => $request->id_petugas, 
            'tgl_transaksi' => date("Y-m-d")]);
            
        if($simpan){
            return Response()->json(['status' => 1]);
        }else {
            return Response()->json(['status' => 0]);
        } 
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        ['id_pelanggan' => 'required',
        'id_petugas' => 'required']);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $ubah = Order::where('id_transaksi', $id)->update([
            'id_pelanggan' => $request->id_pelanggan,
            'id_petugas' => $request->id_petugas, 
            'tgl_transaksi' => date("Y-m-d")]);
            
            if($ubah) {
                return Response()->json(['status' => 1]);
            }else{
                return Response()->json(['status' => 0]);
            }
    }

    public function destroy($id){
        $hapus = Order::where('id_transaksi', $id)->delete(); 
        if($hapus) { 
            return Response()->json(['status' => 1]);
        }else { 
            return Response()->json(['status' => 0]); 
        }
    }
}