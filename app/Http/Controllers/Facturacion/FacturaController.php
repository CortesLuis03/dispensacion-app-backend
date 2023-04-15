<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\FactuLinea;
use App\Models\Formulas;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class FacturaController extends Controller
{
    public function index()
    {
        try {
            $facturas = Formulas::with('cliente', 'tipofactura', 'usuario', 'detalle', 'detalle.producto')->get();
            return response()->json($facturas, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|integer|exists:clientes,id',
            'tipo_facturacion_id' => 'required|integer|exists:tipo_facturacion,id',
            'usuario_id' => 'required|integer|exists:users,id',
            'observacion' => 'nullable|string|max:255',
            'detalle' => 'required|array|min:1',
            'detalle.*.producto_id' => 'required|integer|exists:productos,id',
            'detalle.*.cantidad' => 'required|integer|min:1',
            'detalle.*.precio' => 'required|numeric|min:0'
        ], [
            'cliente_id.required' => 'El campo cliente_id es requerido',
            'cliente_id.integer' => 'El campo cliente_id debe ser un número entero',
            'cliente_id.exists' => 'El campo cliente_id debe existir en la tabla de clientes',
            'tipo_facturacion_id.required' => 'El campo tipo_facturacion_id es requerido',
            'tipo_facturacion_id.integer' => 'El campo tipo_facturacion_id debe ser un número entero',
            'tipo_facturacion_id.exists' => 'El campo tipo_facturacion_id debe existir en la tabla de tipos_facturacion',
            'usuario_id.required' => 'El campo usuario_id es requerido',
            'usuario_id.integer' => 'El campo usuario_id debe ser un número entero',
            'usuario_id.exists' => 'El campo usuario_id debe existir en la tabla de usuarios',
            'observacion.string' => 'El campo observacion debe ser una cadena de caracteres',
            'observacion.max' => 'El campo observacion no debe exceder los 255 caracteres',
            'detalle.required' => 'El campo detalle es requerido',
            'detalle.array' => 'El campo detalle debe ser un array',
            'detalle.min' => 'El campo detalle debe contener al menos un elemento',
            'detalle.*.producto_id.required' => 'El campo producto_id es requerido en cada elemento de detalle',
            'detalle.*.producto_id.integer' => 'El campo producto_id debe ser un número entero en cada elemento de detalle',
            'detalle.*.producto_id.exists' => 'El campo producto_id debe existir en la tabla de productos en cada elemento de detalle',
            'detalle.*.cantidad.required' => 'El campo cantidad es requerido en cada elemento de detalle',
            'detalle.*.cantidad.integer' => 'El campo cantidad debe ser un número entero en cada elemento de detalle',
            'detalle.*.cantidad.min' => 'El campo cantidad debe ser mayor o igual a 1 en cada elemento de detalle',
            'detalle.*.precio.required' => 'El campo precio es requerido en cada elemento de detalle',
            'detalle.*.precio.numeric' => 'El campo precio debe ser un número en cada elemento de detalle',
            'detalle.*.precio.min' => 'El campo precio debe ser mayor o igual a 0 en cada elemento de detalle'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $formula = new Formulas();
        $formula->cliente_id = $request->cliente_id;
        $formula->tipo_facturacion_id = $request->tipo_facturacion_id;
        $formula->usuario_id = $request->usuario_id;
        $formula->observacion = $request->observacion;
        $formula->save();

        foreach (collect($request->detalle) as $value) {
            $detalle = new FactuLinea();
            $detalle->factura_id = $formula->id;
            $detalle->producto_id = $value['producto_id'];
            $detalle->cantidad = $value['cantidad'];
            $detalle->precio = $value['precio'];
            $detalle->save();
        }

        return response($formula, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        try {
            $formula = collect(Formulas::with('cliente', 'tipofactura', 'usuario', 'detalle')->where('id', $id)->get())->first();
            return response()->json($formula, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        try {
            $factulinea = FactuLinea::where('factura_id',$id)->delete();
            $formula = Formulas::where('id',$id)->delete();
            return response()->json(null, Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
