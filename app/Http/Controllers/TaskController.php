<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Staff;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('staff')->orderBy('transaction_date', 'desc')->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $staff = Staff::all(); // Retrieve all users as staff
        return view('tasks.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'transaction_date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required|in:on process,done,cancelled',
            'remarks' => 'nullable|string',
        ]);

        Task::create($validated);
        return redirect()->route('tasks.index')->with('success', 'Task logged successfully!');
    }

    public function edit(Task $task)
    {
        $staff = Staff::all();
        return view('tasks.edit', compact('task', 'staff'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'transaction_date' => 'required|date',
            'description' => 'required|string',
            'status' => 'required|in:on process,done,cancelled',
            'remarks' => 'nullable|string',
        ]);

        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}
