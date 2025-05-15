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
        try {
            $observations = Observation::where('experiment_id', $experimentId)->get();
            return response()->json($observations, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch observations.'], 500);
        }
    }

    // Store a new observation for a specific experiment or direct POST
    public function store(Request $request, $experimentId = null)
    {
        try {
            $validated = $request->validate([
                'experiment_id' => 'sometimes|exists:experiments,id',
                'observation_date' => 'required|date',
                'data' => 'required|string',
                'notes' => 'nullable|string',
            ]);
            if ($experimentId) {
                $validated['experiment_id'] = $experimentId;
            }
            if (!isset($validated['experiment_id'])) {
                return response()->json(['error' => 'experiment_id is required'], 422);
            }
            $observation = Observation::create($validated);
            return response()->json($observation, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create observation.'], 500);
        }
    }

    // Show a single observation
    public function show($id)
    {
        try {
            $observation = Observation::findOrFail($id);
            return response()->json($observation, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Observation not found.'], 404);
        }
    }

    // Update an observation
    public function update(Request $request, $id)
    {
        try {
            $observation = Observation::findOrFail($id);
            $validated = $request->validate([
                'observation_date' => 'sometimes|required|date',
                'data' => 'sometimes|required|string',
                'notes' => 'nullable|string',
            ]);
            $observation->update($validated);
            return response()->json($observation, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update observation.'], 500);
        }
    }

    // Delete an observation
    public function destroy($id)
    {
        try {
            $observation = Observation::findOrFail($id);
            $observation->delete();
            return response()->json(['message' => 'Observation deleted.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete observation.'], 500);
        }
    }
}
