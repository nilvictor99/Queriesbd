<?php

namespace App\Http\Controllers\Api;

use App\Actions\ExternalServices\Reniec\GetReniecData;
use App\Http\Controllers\Controller;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
