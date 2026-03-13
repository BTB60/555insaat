<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Worker;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::with(['site', 'createdBy', 'workers'])
            ->latest()
            ->paginate(20);
        
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        $sites = Site::active()->get();
        $workers = Worker::with('user')->active()->get();
        
        return view('admin.tasks.create', compact('sites', 'workers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'site_id' => 'nullable|exists:sites,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'workers' => 'nullable|array',
            'workers.*' => 'exists:workers,id',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'site_id' => $validated['site_id'] ?? null,
            'created_by' => auth()->id(),
            'priority' => $validated['priority'],
            'status' => 'pending',
            'start_date' => $validated['start_date'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
        ]);

        // Assign workers
        if (!empty($validated['workers'])) {
            foreach ($validated['workers'] as $workerId) {
                $task->assignments()->create([
                    'worker_id' => $workerId,
                    'assigned_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tapşırıq uğurla yaradıldı.');
    }

    public function show(Task $task): View
    {
        $task->load(['site', 'createdBy', 'workers.user', 'assignments.assignedBy']);
        
        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        $sites = Site::active()->get();
        $workers = Worker::with('user')->active()->get();
        $assignedWorkerIds = $task->workers->pluck('id')->toArray();
        
        return view('admin.tasks.edit', compact('task', 'sites', 'workers', 'assignedWorkerIds'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'site_id' => 'nullable|exists:sites,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'workers' => 'nullable|array',
            'workers.*' => 'exists:workers,id',
        ]);

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'site_id' => $validated['site_id'] ?? null,
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'start_date' => $validated['start_date'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'completed_date' => $validated['status'] === 'completed' ? now() : null,
        ]);

        // Sync workers
        if (isset($validated['workers'])) {
            $task->assignments()->delete();
            foreach ($validated['workers'] as $workerId) {
                $task->assignments()->create([
                    'worker_id' => $workerId,
                    'assigned_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tapşırıq yeniləndi.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Tapşırıq silindi.');
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
        ]);

        $task->update([
            'status' => $validated['status'],
            'completed_date' => $validated['status'] === 'completed' ? now() : $task->completed_date,
        ]);

        return redirect()->back()
            ->with('success', 'Tapşırıq statusu yeniləndi.');
    }
}
