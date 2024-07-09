<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibrosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResponse
    {
        try {
            $libros = DB::select('CALL sp_mostrar_libros()');
            return response()->json($libros);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            DB::select('CALL sp_guardar_libro(?, ?, ?, ?, ?, ?)', [
                $request->titulo,
                $request->autor_id,
                $request->imagen,
                $request->genero_id,
                $request->descripcion,
                $request->estado,
            ]);

            return response()->json(['message' => 'Libro creado con éxito'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $libro = DB::select('CALL sp_buscar_libro_por_id(?)', [$id]);
            if (empty($libro)) {
                return response()->json(['error' => 'Libro no encontrado'], 404);
            }
            return response()->json($libro[0]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            DB::select('CALL sp_actualizar_libro(?, ?, ?, ?, ?, ?, ?)', [
                $id,
                $request->titulo,
                $request->autor_id,
                $request->imagen,
                $request->genero_id,
                $request->descripcion,
                $request->estado,
            ]);

            return response()->json(['message' => 'Libro actualizado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            DB::select('CALL sp_eliminar_libro(?)', [$id]);
            return response()->json(['message' => 'Libro eliminado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}