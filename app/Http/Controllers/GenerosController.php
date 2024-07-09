<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class GenerosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try {
            $sql = DB::select('CALL sp_MostrarGeneros()');
            return response()->json($sql);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):JsonResponse
    {

        DB::select('CALL sp_GuardarGenero( ?)', [

            $request->nombre,
        ]);

        return response()->json(['message' => 'Genero creado con éxito'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):JsonResponse
    {
        $datos = DB::select('CALL sp_BuscarGeneroPorId(?)', [$id]);
        if (empty($datos)) {
            return response()->json(['error' => 'Genero no encontrada'], 404);
        }
        return response()->json($datos[0],); // Devuelve solo el primer elemento
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):JsonResponse
    {
        try {
            DB::select('CALL sp_ActualizarGenero(?, ?)', [
                $id,
                $request->nombre,
            ]);

            return response()->json(['message' => 'Genero actualizada con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        DB::select('CALL sp_EliminarGenero(?)', [$id]);
        return response()->json(['message' => 'Genero  eliminada con éxito']);
    }
}
