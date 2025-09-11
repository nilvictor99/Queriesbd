<?php

namespace App\Http\Controllers\Api;

use App\Actions\ExternalServices\Reniec\GetReniecData;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReniecDataRequest;
use App\Services\Models\ReniecDataService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DataController extends Controller
{
    protected $reniecService;

    public function __construct(ReniecDataService $reniecService)
    {
        $this->reniecService = $reniecService;
    }

    public function index(Request $request)
    {
        $dni = $request->input('dni');
        $reniecData = null;

        if ($dni) {
            $reniecData = GetReniecData::run($dni);
        }

        return Inertia::render('ReniecData/Consult', [
            'reniecData' => Inertia::lazy(fn () => $reniecData),
            'dni' => Inertia::lazy(fn () => $dni),
        ]);
    }

    public function create()
    {
        return Inertia::render('Demo/Create');
    }

    public function store(ReniecDataRequest $request)
    {
        $this->reniecService->storeData($request->validated());

        return redirect()->back()->with('message', 'Datos registrados correctamente');
    }

    public function getData(Request $request)
    {
        $dni = $request->input('dni');

        if (! $dni) {
            return response()->json([
                'success' => false,
                'message' => 'El parámetro dni es obligatorio',
            ], 400);
        }

        try {
            $reniecData = GetReniecData::run($dni);

            return response()->json([
                'success' => true,
                'data' => $reniecData,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos de RENIEC',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function storeData(ReniecDataRequest $request)
    {
        try {
            $validated = $request->validated();

            $result = $this->reniecService->storeData($validated);

            return response()->json([
                'success' => true,
                'message' => 'Datos registrados correctamente',
                'data' => $result,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
