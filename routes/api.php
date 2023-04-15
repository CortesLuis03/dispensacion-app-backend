<?php

use Illuminate\Support\Facades\Route;

Route::post('register', 'App\Http\Controllers\Api\AuthController@register');
Route::post('login', 'App\Http\Controllers\Api\AuthController@login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user-profile', 'App\Http\Controllers\Api\AuthController@userProfile');
    Route::post('logout', 'App\Http\Controllers\Api\AuthController@logout');

    Route::prefix('facturacion')->group(function () {

        Route::get('/getInfo', 'App\Http\Controllers\Facturacion\FacturaController@index');
        Route::get('/{id_factura}', 'App\Http\Controllers\Facturacion\FacturaController@show');
        Route::post('/save', 'App\Http\Controllers\Facturacion\FacturaController@store');
        Route::put('/{id_factura}', 'App\Http\Controllers\Facturacion\FacturaController@update');
        Route::delete('/{id_factura}', 'App\Http\Controllers\Facturacion\FacturaController@destroy');
    });

    Route::prefix('catalogos')->group(function () {
        Route::get('/getClientes', 'App\Http\Controllers\Catalogos\ClientesController@index');
        Route::post('/saveCliente', 'App\Http\Controllers\Catalogos\ClientesController@store');
        Route::get('/getProductos', 'App\Http\Controllers\Catalogos\ProductosController@index');
        Route::post('/saveProducto', 'App\Http\Controllers\Catalogos\ProductosController@store');
        Route::get('/getTipoFacturacion', 'App\Http\Controllers\Catalogos\TipoFacturacionController@index');
        Route::post('/saveTipoFacturacion', 'App\Http\Controllers\Catalogos\TipoFacturacionController@store');
    });
});
