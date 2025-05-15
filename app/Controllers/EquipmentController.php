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
        return Equipment::with('experiments')->get();
    }

    // Store new equipment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'serial_number' => 'required|string|max:255|unique:equipment,serial_number',
        ]);
        $equipment = Equipment::create($validated);
        return response()->json($equipment, 201);
    }

    // Show a single equipment
    public function show($id)
    {
        $equipment = Equipment::with('experiments')->findOrFail($id);
        return $equipment;
    }

    // Update equipment
    public function update(Request $request, $id)
    {
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
        return $equipment;
    }

    // Delete equipment (only if no experiments)
    public function destroy($id)
    {
        $equipment = Equipment::withCount('experiments')->findOrFail($id);
        if ($equipment->experiments_count > 0) {
            return response()->json(['error' => 'Cannot delete equipment with associated experiments.'], 400);
        }
        $equipment->delete();
        return response()->json(['message' => 'Equipment deleted.']);
    }
}
