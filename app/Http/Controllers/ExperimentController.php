<?php
// app/Http/Controllers/ExperimentController.php
namespace App\Http\Controllers;

use App\Models\Experiment;
use App\Models\Researcher;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExperimentController extends Controller
{
    // List all experiments with researchers and equipment
    public function index()
    {
        try {
            $experiments = Experiment::with(['researchers', 'equipment'])->get();
            return response()->json($experiments, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch experiments.'], 500);
        }
    }

    // Store a new experiment
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'researcher_ids' => 'required|array|min:1',
                'researcher_ids.*' => 'exists:researchers,id',
                'equipment_ids' => 'required|array|min:1',
                'equipment_ids.*' => 'exists:equipment,id',
            ]);
            $experiment = DB::transaction(function () use ($validated) {
                $experiment = Experiment::create($validated);
                $experiment->researchers()->sync($validated['researcher_ids']);
                $experiment->equipment()->sync($validated['equipment_ids']);
                return $experiment->load(['researchers', 'equipment']);
            });
            return response()->json($experiment, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create experiment.'], 500);
        }
    }

    // Show a single experiment with researchers, equipment, and observations
    public function show($id)
    {
        try {
            $experiment = Experiment::with(['researchers', 'equipment', 'observations'])->findOrFail($id);
            return response()->json($experiment, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Experiment not found.'], 404);
        }
    }

    // Update an experiment
    public function update(Request $request, $id)
    {
        try {
            $experiment = Experiment::findOrFail($id);
            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'sometimes|required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'researcher_ids' => 'sometimes|array|min:1',
                'researcher_ids.*' => 'exists:researchers,id',
                'equipment_ids' => 'sometimes|array|min:1',
                'equipment_ids.*' => 'exists:equipment,id',
            ]);
            $experiment->update($validated);
            if (isset($validated['researcher_ids'])) {
                $experiment->researchers()->sync($validated['researcher_ids']);
            }
            if (isset($validated['equipment_ids'])) {
                $experiment->equipment()->sync($validated['equipment_ids']);
            }
            return response()->json($experiment->load(['researchers', 'equipment']), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update experiment.'], 500);
        }
    }

    // Delete an experiment
    public function destroy($id)
    {
        try {
            $experiment = Experiment::findOrFail($id);
            $experiment->delete();
            return response()->json(['message' => 'Experiment deleted.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete experiment.'], 500);
        }
    }
}
