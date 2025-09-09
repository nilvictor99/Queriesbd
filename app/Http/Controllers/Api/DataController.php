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
            'reniecData' => Inertia::lazy(fn() => $reniecData),
            'dni' => Inertia::lazy(fn() => $dni),
        ]);
    }

    public function create()
    {
        return Inertia::render('Demo/Create');
    }

    public function store(Request $request)
    {
        $this->reniecService->storeData($request->all());

        return redirect()->back()->banner('Datos registrados');
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
