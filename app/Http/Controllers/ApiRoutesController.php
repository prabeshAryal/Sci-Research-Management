<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

class ApiRoutesController extends Controller
{
    public function index()
    {
        $routes = collect(Route::getRoutes())
            ->map(function ($route) {
                return [
                    'uri' => $route->uri(),
                    'methods' => $route->methods(),
                    'name' => $route->getName(),
                ];
            })
            ->filter(function ($route) {
                return str_starts_with($route['uri'], 'api/');
            })
            ->values();

        return response()->json([
            'total_routes' => $routes->count(),
            'routes' => $routes
        ]);
    }
}
