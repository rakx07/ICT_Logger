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
        // Fetch tasks ordered by the latest update first, then by creation date
        $tasks = Task::with('staff')
                    ->orderByRaw('GREATEST(updated_at, created_at) DESC') // Sort by the latest of updated_at or created_at
                    ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $staff = Staff::all(); // Fetch all staff for the dropdown
        return view('tasks.create', compact('staff'));
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
            'task' => $task->load('staff'),
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

        // Update the task and force `updated_at` timestamp to be refreshed
        $task->update(array_merge($validated, ['updated_at' => now()]));

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully!',
                'task' => $task->load('staff')
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
        $user = Auth::user();

        // Check if user is an admin
        if (!$user || $user->admin != 1) {
            return redirect()->route('tasks.index')->with('error', 'You are not authorized to delete this task.');
        }

        // Delete the task
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    /**
     * Update only the status of a task.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:on process,done,cancelled',
        ]);

        // Update status and force `updated_at` timestamp refresh
        $task->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully.',
        ]);
    }
}
