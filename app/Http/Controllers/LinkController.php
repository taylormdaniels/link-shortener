<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url'  => 'required|url',
            'slug' => ['nullable','string','min:3','max:32','regex:/^[a-z0-9-]+$/i'],
        ]);

        if ($request->filled('slug') && Link::where('slug', $request->slug)->exists()) {
            return response()->json(['error' => 'slug_taken'], 409);
        }

        $link = Link::create([
            'original_url' => $request->url,
            'slug'         => $request->slug ?: Str::random(6),
        ]);

        return response()->json([
            'short' => url($link->slug),
            'link'  => $link,
        ], 201);
    }

    /**
     * Redirect using link's code
     */

    public function redirect($slug)
    {
        $link = Link::where('slug', $slug)->firstOrFail();

        $link->clicks()->create([
            'ip'    => request()->ip(),
            'user_agent'    => substr(request()->userAgent(), 0, 512),
        ]);
        
        return redirect()->away($link->original_url);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
