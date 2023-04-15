<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id';
    protected $fillable = ['cedula', 'nombre', 'direccion', 'telefono', 'email', 'eps'];
    public $timestamps = true;
    use HasFactory;
}
