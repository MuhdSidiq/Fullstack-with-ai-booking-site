<?php

namespace App\Http\Controllers;

use App\Models\CampingSite;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the welcome page with camping sites.
     */
    public function index(): View
    {
        $transformSite = function ($site) {
            // Infer type from name (case-insensitive check)
            $name = strtolower($site->name);
            $type = 'tent'; // default
            if (str_contains($name, 'rv') || str_contains($name, 'rv park')) {
                $type = 'rv';
            } elseif (str_contains($name, 'glamping') || str_contains($name, 'safari') || str_contains($name, 'dome')) {
                $type = 'glamping';
            } elseif (str_contains($name, 'tent') || str_contains($name, 'solo')) {
                $type = 'tent';
            }

            // Default images based on type
            $images = [
                'tent' => 'https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?auto=format&fit=crop&q=80&w=800',
                'rv' => 'https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&q=80&w=800',
                'glamping' => 'https://images.unsplash.com/photo-1533167649158-6d508895b680?auto=format&fit=crop&q=80&w=800',
            ];

            return [
                'id' => $site->id,
                'name' => $site->name,
                'type' => $type,
                'price' => (float) $site->price,
                'rating' => 4.5 + (rand(0, 5) / 10), 
                'reviews' => rand(5, 50), 
                'image' => $images[$type] ?? $images['tent'],
                'description' => $site->location.($site->is_prime_location ? ' - Prime location with premium amenities.' : ' - Beautiful camping spot.'),
            ];
        };

        // Paginated campsites for display (9 per page)
        $paginatedSites = CampingSite::paginate(9);
        $campingSites = $paginatedSites->through($transformSite);

        // All campsites for JavaScript filtering
        $allCampingSites = CampingSite::all()->map($transformSite);

        return view('welcome', compact('campingSites', 'allCampingSites'));
    }
}
