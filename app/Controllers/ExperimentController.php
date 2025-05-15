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
        return Experiment::with(['researchers', 'equipment'])->get();
    }

    // Store a new experiment
    public function store(Request $request)
    {
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
        return DB::transaction(function () use ($validated) {
            $experiment = Experiment::create($validated);
            $experiment->researchers()->sync($validated['researcher_ids']);
            $experiment->equipment()->sync($validated['equipment_ids']);
            return response()->json($experiment->load(['researchers', 'equipment']), 201);
        });
    }

    // Show a single experiment with researchers, equipment, and observations
    public function show($id)
    {
        $experiment = Experiment::with(['researchers', 'equipment', 'observations'])->findOrFail($id);
        return $experiment;
    }

    // Update an experiment
    public function update(Request $request, $id)
    {
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
        return DB::transaction(function () use ($experiment, $validated) {
            $experiment->update($validated);
            if (isset($validated['researcher_ids'])) {
                $experiment->researchers()->sync($validated['researcher_ids']);
            }
            if (isset($validated['equipment_ids'])) {
                $experiment->equipment()->sync($validated['equipment_ids']);
            }
            return $experiment->load(['researchers', 'equipment']);
        });
    }

    // Delete an experiment
    public function destroy($id)
    {
        $experiment = Experiment::findOrFail($id);
        $experiment->delete();
        return response()->json(['message' => 'Experiment deleted.']);
    }
}
