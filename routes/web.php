<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $apiRoutes = [
        ['method' => 'GET',    'url' => '/api/experiments', 'desc' => 'List all experiments'],
        ['method' => 'POST',   'url' => '/api/experiments', 'desc' => 'Create a new experiment'],
        ['method' => 'GET',    'url' => '/api/experiments/{id}', 'desc' => 'Get experiment details'],
        ['method' => 'PUT',    'url' => '/api/experiments/{id}', 'desc' => 'Update an experiment'],
        ['method' => 'DELETE', 'url' => '/api/experiments/{id}', 'desc' => 'Delete an experiment'],
        ['method' => 'GET',    'url' => '/api/researchers', 'desc' => 'List all researchers'],
        ['method' => 'POST',   'url' => '/api/researchers', 'desc' => 'Create a new researcher'],
        ['method' => 'GET',    'url' => '/api/researchers/{id}', 'desc' => 'Get researcher details'],
        ['method' => 'PUT',    'url' => '/api/researchers/{id}', 'desc' => 'Update a researcher'],
        ['method' => 'DELETE', 'url' => '/api/researchers/{id}', 'desc' => 'Delete a researcher'],
        ['method' => 'GET',    'url' => '/api/equipment', 'desc' => 'List all equipment'],
        ['method' => 'POST',   'url' => '/api/equipment', 'desc' => 'Create new equipment'],
        ['method' => 'GET',    'url' => '/api/equipment/{id}', 'desc' => 'Get equipment details'],
        ['method' => 'PUT',    'url' => '/api/equipment/{id}', 'desc' => 'Update equipment'],
        ['method' => 'DELETE', 'url' => '/api/equipment/{id}', 'desc' => 'Delete equipment'],
        ['method' => 'GET',    'url' => '/api/experiments/{experiment}/observations', 'desc' => 'List all observations for an experiment'],
        ['method' => 'POST',   'url' => '/api/experiments/{experiment}/observations', 'desc' => 'Add a new observation'],
        ['method' => 'GET',    'url' => '/api/observations/{id}', 'desc' => 'Get a single observation'],
        ['method' => 'PUT',    'url' => '/api/observations/{id}', 'desc' => 'Update an observation'],
        ['method' => 'DELETE', 'url' => '/api/observations/{id}', 'desc' => 'Delete an observation'],
        ['method' => 'GET',    'url' => '/api/routes', 'desc' => 'List all API routes'],
    ];
    return response()->view('api-list', ['apiRoutes' => $apiRoutes]);
});

Route::get('/admin', function () {
    return view('admin');
});
