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
        try {
            $researchers = Researcher::with('experiments')->get();
            return response()->json($researchers, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch researchers.'], 500);
        }
    }

    // Store a new researcher
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:researchers,email',
                'institution' => 'nullable|string|max:255',
            ]);
            $researcher = Researcher::create($validated);
            return response()->json($researcher, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create researcher.'], 500);
        }
    }

    // Show a single researcher
    public function show($id)
    {
        try {
            $researcher = Researcher::with('experiments')->findOrFail($id);
            return response()->json($researcher, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Researcher not found.'], 404);
        }
    }

    // Update a researcher
    public function update(Request $request, $id)
    {
        try {
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
            return response()->json($researcher, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update researcher.'], 500);
        }
    }

    // Delete a researcher (only if no experiments)
    public function destroy($id)
    {
        try {
            $researcher = Researcher::withCount('experiments')->findOrFail($id);
            if ($researcher->experiments_count > 0) {
                return response()->json(['error' => 'Cannot delete researcher with associated experiments.'], 400);
            }
            $researcher->delete();
            return response()->json(['message' => 'Researcher deleted.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete researcher.'], 500);
        }
    }
}
