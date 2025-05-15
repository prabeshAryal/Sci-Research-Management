<?php
// app/Http/Controllers/AllObservationsController.php
namespace App\Http\Controllers;

use App\Models\Observation;

class AllObservationsController extends Controller
{
    public function index()
    {
        return Observation::all();
    }
}
