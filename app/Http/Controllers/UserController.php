<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Models\ModelService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $modelService;

    protected $userService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
        $this->userService = $this->modelService->getService('UserService');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->all();

        return inertia('App/User/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('App/User/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->userService->create($request->all());

        to_route('app.users.index')->with('notification', [
            'type' => 'success',
            'message' => 'User created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('app.users.index')->with('notification', [
            'type' => 'success',
            'message' => 'User deleted successfully',
        ]);
    }
}
