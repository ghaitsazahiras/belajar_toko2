<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detailOrders extends Model
{
    protected $table = 'detail_orders';
    public $timestamps = false;

    protected $fillable = ['id_transaksi', 'id_produk', 'qty', 'subtotal'];
}
