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
        $staff = Staff::paginate(10); // Use paginate() to enable pagination
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created staff in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'position' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        Staff::create($request->all());

        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'position' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        $staff->update($request->all());

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified staff from the database.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}
