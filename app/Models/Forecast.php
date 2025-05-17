<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $table = 'tabel_forecast';
    protected $fillable = ['tanggal', 'forecast', 'lower_confidence', 'upper_confidence'];
    public $timestamps = false;
}
