<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulas extends Model
{   
    protected $table = 'formulas';
    protected $primaryKey = 'id';
    protected $fillable = ['cliente_id', 'tipo_facturacion_id', 'observacion', 'usuario_id'];
    public $timestamps = true;
    use HasFactory;

    function detalle(){
        return $this->hasMany(FactuLinea::class, 'factura_id', 'id');
    }

    function cliente(){
        return $this->hasOne(Clientes::class, 'id', 'cliente_id');
    }

    function tipofactura(){
        return $this->hasOne(TipoFacturacion::class, 'id', 'tipo_facturacion_id');
    }

    function usuario(){
        return $this->hasOne(User::class, 'id', 'usuario_id');
    }
}
