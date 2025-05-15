<?php
// app/Http/Controllers/ResearcherController.php
namespace App\Http\Controllers;

use App\Models\Researcher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResearcherController extends Controller
{
    // List all researchers
    public function index()
    {
        return Researcher::with('experiments')->get();
    }

    // Store a new researcher
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:researchers,email',
            'institution' => 'nullable|string|max:255',
        ]);
        $researcher = Researcher::create($validated);
        return response()->json($researcher, 201);
    }

    // Show a single researcher
    public function show($id)
    {
        $researcher = Researcher::with('experiments')->findOrFail($id);
        return $researcher;
    }

    // Update a researcher
    public function update(Request $request, $id)
    {
        $researcher = Researcher::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('researchers')->ignore($researcher->id),
            ],
            'institution' => 'nullable|string|max:255',
        ]);
        $researcher->update($validated);
        return $researcher;
    }

    // Delete a researcher (only if no experiments)
    public function destroy($id)
    {
        $researcher = Researcher::withCount('experiments')->findOrFail($id);
        if ($researcher->experiments_count > 0) {
            return response()->json(['error' => 'Cannot delete researcher with associated experiments.'], 400);
        }
        $researcher->delete();
        return response()->json(['message' => 'Researcher deleted.']);
    }
}
