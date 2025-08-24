<?php

namespace App\Http\Middleware\Cpanel;

use App\Services\Utils\Storage\StorageForCpanelService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StorageHability
{
    protected $storageService;

    public function __construct(StorageForCpanelService $Service)
    {
        $this->storageService = $Service;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $this->storageService->copyDirectory();

        return $response;
    }
}
