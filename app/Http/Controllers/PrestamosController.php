<?php

namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try {
            $sql = DB::select('CALL sp_mostrar_prestamos()');
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
         try {
        // Ejecutar directamente el procedimiento almacenado
        DB::select('CALL sp_solicitar_libro(?, ?, ?)', [
            $request->input('libro_id'),
            $request->input('usuario_id'),
            $request->input('fecha_prestamo'),
        ]);

        return response()->json(['message' => 'Préstamo realizado con éxito'], 201);
    } catch (\Exception $e) {
        // Manejo de errores
        return response()->json(['error' => 'Error al realizar el préstamo: ' . $e->getMessage()], 500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $datos = DB::select('CALL sp_buscar_prestamo_por_id(?)', [$id]);
        if (empty($datos)) {
            return response()->json(['error' => 'Prestamo no encontrada'], 404);
        }
        return response()->json($datos[0],); // Devuelve solo el primer elemento
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):JsonResponse
    {
        DB::select('CALL sp_eliminar_prestamo(?)', [$id]);
        return response()->json(['message' => 'Prestamo  eliminada con éxito']);
    }
}
