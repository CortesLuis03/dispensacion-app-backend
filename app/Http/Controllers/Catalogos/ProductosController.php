<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductosController extends Controller
{
    public function index()
    {
        try {
            $productos = Productos::where('estado', 'activo')->get();
            return response()->json($productos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'precio' => 'required',
            'lote' => 'required',
            'vencimiento' => 'required',
            'estado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $producto = new Productos();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->lote = $request->lote;
        $producto->vencimiento = $request->vencimiento;
        $producto->estado = $request->estado;
        $producto->save();

        return response($producto, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
