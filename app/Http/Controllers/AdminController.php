<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DeletedDealerRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // List all Dealers (B2B)
    public function index()
    {
        $dealers = User::where('role', 'b2b')->get();
        return response()->json($dealers);
    }

    // Approve a Dealer
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return response()->json(['message' => 'Dealer approved successfully.', 'user' => $user]);
    }

    // Secure Delete Dealer
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string',
            'admin_id' => 'required', // Should ideally come from auth(), but passing for now if needed, or use auth()->id()
        ]);

        $admin = User::findOrFail($request->admin_id); // In real app, use auth()->user()

        // Verify Admin Password
        if (!Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid password. Deletion cancelled.'], 403);
        }

        $dealer = User::findOrFail($id);

        // CREATE AUDIT RECORD
        DeletedDealerRecord::create([
            'admin_id' => $admin->id,
            'admin_name' => $admin->name,
            'dealer_info' => $dealer->toArray(),
            'deleted_at' => now()
        ]);

        // DELETE USER
        $dealer->delete();

        return response()->json(['message' => 'Dealer deleted successfully. Record saved.']);
    }

    // Get Deleted Records
    public function records()
    {
        $records = DeletedDealerRecord::orderBy('created_at', 'desc')->get();
        return response()->json($records);
    }
}
