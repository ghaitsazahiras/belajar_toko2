<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $table = 'officer';
    public $timestamps = false;

    protected $fillable = ['nama_petugas', 'username', 'password', 'level'];
}
