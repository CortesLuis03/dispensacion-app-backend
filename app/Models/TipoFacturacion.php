<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoFacturacion extends Model
{
    protected $table = 'tipo_facturacion';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion'];
    public $timestamps = true;
    use HasFactory;
}
