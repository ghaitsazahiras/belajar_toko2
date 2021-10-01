<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\DetailOrders;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailOrdersController extends Controller{

    public function show(){
        $data = DB::table('detail_orders')
            ->join('order', 'detail_orders.id_transaksi', '=' , 'order.id_transaksi')
            ->join('product', 'detail_orders.id_produk', '=' , 'product.id_produk')
            ->select('order.id_transaksi', 'order.tgl_transaksi', 'order.id_pelanggan', 'product.id_produk', 'product.nama_produk', 'detail_orders.qty', 'detail_orders.subtotal')
            ->get();
        return Response()->json($data);
    }

    public function detail($id){
        if(detailOrders::where('id_detail_transaksi', $id)->exists()){
            $data_order = DB::table('detail_orders')
            ->join('order', 'detail_orders.id_transaksi', '=' , 'order.id_transaksi')
            ->join('product', 'detail_orders.id_produk', '=' , 'product.id_produk')
            ->select('order.id_transaksi', 'order.tgl_transaksi', 'order.id_pelanggan', 'product.id_produk', 'product.nama_produk', 'detail_orders.qty', 'detail_orders.subtotal')
            ->where('detail_orders.id_detail_transaksi', '=', $id)
            ->get();
            return Response()->json($data_order);
        }else{
            return Response()->json(['message' => 'Tidak Ditemukan']);
        }
    }

    public function store(Request $request){
        $validator=Validator::make($request->all(),
        ['id_transaksi' => 'required',
        'id_produk' => 'required',
        'qty' => 'required']); 
        
        if($validator->fails()){ 
            return Response()->json($validator->errors());
        }

        $id_produk = $request->id_produk;
        $qty = $request->qty;
        $harga = DB::table('product')->where('id_produk', $id_produk)->value('harga');
        $subtotal = $harga * $qty;

        $simpan = detailOrders::create([
            'id_transaksi' => $request->id_transaksi,
            'id_produk' => $id_produk, 
            'qty' => $qty,
            'subtotal' => $subtotal]);
            
        if($simpan){
            return Response()->json(['status' => 1]);
        }else {
            return Response()->json(['status' => 0]);
        } 
    }

    public function update($id, Request $request){
        $validator=Validator::make($request->all(),
        ['id_transaksi' => 'required',
        'id_produk' => 'required',
        'qty' => 'required']);
        
        if($validator->fails()) {
            return Response()->json($validator->errors());
        }
        
        $id_produk = $request->id_produk;
        $qty = $request->qty;
        $harga = DB::table('product')->where('id_produk', $id_produk)->value('harga');
        $subtotal = $harga * $qty;

        $ubah = detailOrders::where('id_detail_transaksi', $id)->update([
            'id_transaksi' => $request->id_transaksi,
            'id_produk' => $id_produk, 
            'qty' => $qty,
            'subtotal' => $subtotal]);
            
            if($ubah) {
                return Response()->json(['status' => 1]);
            }else{
                return Response()->json(['status' => 0]);
            }
    }

    public function destroy($id){
        $hapus = detailOrders::where('id_detail_transaksi', $id)->delete(); 
        if($hapus) { 
            return Response()->json(['status' => 1]);
        }else { 
            return Response()->json(['status' => 0]); 
        }
    }
}