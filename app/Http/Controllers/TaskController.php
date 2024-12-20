<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Staff;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display the list of tasks.
     */
    public function index()
    {
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

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'task' => $task->load('staff'), // Include staff relationship
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

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Delete a task from the database.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
