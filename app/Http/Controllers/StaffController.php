<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    /**
     * Display a listing of the staff.
     */
    public function index()
    {
        // Fetch staff records ordered by creation date in descending order
        $staff = Staff::orderBy('created_at', 'desc')->paginate(10); 
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff.
     */
    public function create()
{
    $staff = Staff::orderBy('created_at', 'desc')->get(); // Fetch all staff records, sorted by latest
    return view('staff.create', compact('staff'));
}

    /**
     * Store a newly created staff in the database.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:staff,email',
                'position' => 'required|string|max:255',
                'phone_number' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:500',
            ]);

            $staff = Staff::create($validatedData);

            return response()->json([
                'success' => true,
                'staff' => $staff,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing an existing staff.
     */
    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff in the database.
     */
    public function update(Request $request, Staff $staff)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:staff,email,' . $staff->id,
                'position' => 'required|string|max:255',
                'phone_number' => 'nullable|string|max:50',
                'address' => 'nullable|string|max:500',
            ]);

            $staff->update($validatedData);

            return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('staff.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified staff from the database.
     */
    public function destroy(Staff $staff)
    {
        try {
            $staff->delete();
            return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('staff.index')->with('error', $e->getMessage());
        }
    }
}
