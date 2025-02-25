<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display the list of tasks.
     */
    public function index()
    {
        // Ensure tasks are loaded with their associated staff
        $tasks = Task::with('staff')->orderBy('transaction_date', 'desc')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $staff = Staff::all(); // Fetch all staff for the dropdown
        $tasks = Task::with('staff')->latest()->get(); // Fetch all tasks with staff, sorted by latest
        return view('tasks.create', compact('staff', 'tasks'));
    }

    /**
     * Store a newly created task in the database.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'transaction_date' => 'required|date',
            'description' => 'required|string|max:255',
            'status' => 'required|in:on process,done,cancelled',
            'remarks' => 'nullable|string|max:255',
        ]);

        // Create the task
        $task = Task::create($validated);

        // Return JSON response for AJAX with staff relationship loaded
        return response()->json([
            'success' => true,
            'task' => $task->load('staff'), // Ensure the staff relationship is included
        ]);
    }

    /**
     * Show the form for editing an existing task.
     */
    public function edit(Task $task)
    {
        $staff = Staff::all(); // Retrieve all staff for dropdown
        return view('tasks.edit', compact('task', 'staff'));
    }

    /**
     * Update an existing task in the database.
     */
    public function update(Request $request, Task $task)
{
    // Validate the request
    $validated = $request->validate([
        'staff_id' => 'required|exists:staff,id',
        'transaction_date' => 'required|date',
        'description' => 'required|string|max:255',
        'status' => 'required|in:on process,done,cancelled',
        'remarks' => 'nullable|string|max:255',
    ]);

    // Update the task
    $task->update($validated);

    // Check if request is AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully!',
            'task' => $task->load('staff') // Load the related staff details
        ]);
    }

    return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
}
    

    /**
     * Delete a task from the database (Only accessible by Admin).
     */
    public function destroy(Task $task)
    {
        // Get the authenticated user
        $user = Auth::user(); // Use Auth::user() instead of auth()->user()

        // Check if user is an admin
        if (!$user || $user->admin != 1) {
            return redirect()->route('tasks.index')->with('error', 'You are not authorized to delete this task.');
        }

        // Delete the task
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    public function updateStatus(Request $request, Task $task)
{
    $request->validate([
        'status' => 'required|in:on process,done,cancelled',
    ]);

    $task->update(['status' => $request->status]);

    return response()->json(['success' => true, 'message' => 'Task status updated successfully.']);
}
}
