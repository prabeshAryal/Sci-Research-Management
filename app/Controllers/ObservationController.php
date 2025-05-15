<?php
// app/Http/Controllers/ObservationController.php
namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;

class ObservationController extends Controller
{
    // List all observations for a specific experiment
    public function index($experimentId)
    {
        return Observation::where('experiment_id', $experimentId)->get();
    }

    // Store a new observation for a specific experiment
    public function store(Request $request, $experimentId)
    {
        $validated = $request->validate([
            'observation_date' => 'required|date',
            'data' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        $validated['experiment_id'] = $experimentId;
        $observation = Observation::create($validated);
        return response()->json($observation, 201);
    }

    // Show a single observation
    public function show($id)
    {
        return Observation::findOrFail($id);
    }

    // Update an observation
    public function update(Request $request, $id)
    {
        $observation = Observation::findOrFail($id);
        $validated = $request->validate([
            'observation_date' => 'sometimes|required|date',
            'data' => 'sometimes|required|string',
            'notes' => 'nullable|string',
        ]);
        $observation->update($validated);
        return $observation;
    }

    // Delete an observation
    public function destroy($id)
    {
        $observation = Observation::findOrFail($id);
        $observation->delete();
        return response()->json(['message' => 'Observation deleted.']);
    }
}
