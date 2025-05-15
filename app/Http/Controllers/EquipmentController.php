<?php
// app/Http/Controllers/EquipmentController.php
namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    // List all equipment
    public function index()
    {
        try {
            $equipment = Equipment::with('experiments')->get();
            return response()->json($equipment, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch equipment.'], 500);
        }
    }

    // Store new equipment
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'manufacturer' => 'nullable|string|max:255',
                'serial_number' => 'required|string|max:255|unique:equipment,serial_number',
            ]);
            $equipment = Equipment::create($validated);
            return response()->json($equipment, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create equipment.'], 500);
        }
    }

    // Show a single equipment
    public function show($id)
    {
        try {
            $equipment = Equipment::with('experiments')->findOrFail($id);
            return response()->json($equipment, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Equipment not found.'], 404);
        }
    }

    // Update equipment
    public function update(Request $request, $id)
    {
        try {
            $equipment = Equipment::findOrFail($id);
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'manufacturer' => 'nullable|string|max:255',
                'serial_number' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('equipment')->ignore($equipment->id),
                ],
            ]);
            $equipment->update($validated);
            return response()->json($equipment, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update equipment.'], 500);
        }
    }

    // Delete equipment (only if no experiments)
    public function destroy($id)
    {
        try {
            $equipment = Equipment::withCount('experiments')->findOrFail($id);
            if ($equipment->experiments_count > 0) {
                return response()->json(['error' => 'Cannot delete equipment with associated experiments.'], 400);
            }
            $equipment->delete();
            return response()->json(['message' => 'Equipment deleted.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete equipment.'], 500);
        }
    }
}
