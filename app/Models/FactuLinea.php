<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactuLinea extends Model
{
    protected $table = 'factulinea';
    protected $primaryKey = 'id';
    protected $fillable = ['factura_id', 'producto_id', 'cantidad', 'precio'];
    public $timestamps = true;
    use HasFactory;

    function producto(){
        return $this->hasOne(Productos::class, 'id', 'producto_id');
    }
}
