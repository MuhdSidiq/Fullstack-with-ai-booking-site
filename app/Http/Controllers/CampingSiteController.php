<?php

namespace App\Http\Controllers;

use App\Models\CampingSite;
use Illuminate\Http\Request;

class CampingSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campingSites = CampingSite::all(); // Fetch all camping sites
        return view('camping-sites.index', compact('campingSites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('camping-sites.create'); // Return the create view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_prime_location' => 'nullable|boolean',
        ]);

        CampingSite::create($validated); // Create a new camping site

        return redirect()->route('camping-sites.index')->with('success', 'Camping site created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CampingSite $campingSite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampingSite $campingSite)
    {
        return view('camping-sites.edit', compact('campingSite')); // Return the edit view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CampingSite $campingSite)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_prime_location' => 'nullable|boolean',
        ]);

        $campingSite->update($validated); // Update the camping site

        return redirect()->route('camping-sites.index')->with('success', 'Camping site updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampingSite $campingSite)
    {
        $campingSite->delete(); // Delete the camping site

        return redirect()->route('camping-sites.index')->with('success', 'Camping site deleted successfully.');
    }
}
