<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // In a real app with database, we would save it:
        // Contact::create($validated);

        // For now, just return success
        return response()->json([
            'message' => 'Contact inquiry received successfully',
            'data' => $validated
        ], 200);
    }
}
