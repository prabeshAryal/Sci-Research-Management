<?php
// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExperimentController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ObservationController;
use App\Http\Controllers\ApiRoutesController;
use App\Http\Controllers\AllObservationsController;

Route::middleware('api')->group(function () {
    // Documentation route - lists all available API routes
    Route::get('/', [ApiRoutesController::class, 'index']);
    // Route to list all API routes yep
    Route::get('routes', function () {
        $routes = collect(\Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'methods' => $route->methods(),
                'name' => $route->getName(),
                'action' => $route->getActionName(),
            ];
        })->filter(function ($route) {
            // Only show API routes (skip web and fallback)
            return str_starts_with($route['uri'], 'api/') || !str_contains($route['uri'], '/');
        })->values();
        return response()->json($routes);
    });

    Route::apiResource('experiments', ExperimentController::class);
    Route::apiResource('researchers', ResearcherController::class);
    Route::apiResource('equipment', EquipmentController::class);
    Route::get('experiments/{experiment}/observations', [ObservationController::class, 'index']);
    Route::post('experiments/{experiment}/observations', [ObservationController::class, 'store']);
    Route::get('observations/{observation}', [ObservationController::class, 'show']);
    Route::put('observations/{observation}', [ObservationController::class, 'update']);
    Route::patch('observations/{observation}', [ObservationController::class, 'update']);
    Route::delete('observations/{observation}', [ObservationController::class, 'destroy']);
    Route::get('observations', [AllObservationsController::class, 'index']); // New route for listing all observations
    Route::post('observations', [ObservationController::class, 'store']); // Add POST /api/observations for creating a new observation
});

// Fallback route for undefined API endpoints
Route::fallback(function () {
    return response()->json([
        'message' => 'API route not found.'
    ], 404);
});
