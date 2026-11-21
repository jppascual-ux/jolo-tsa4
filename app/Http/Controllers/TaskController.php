<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Mail\TaskCompleted;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class TaskController extends Controller
{
    /**
     * Task List page (public): every active task, ordered by date.
     */
    public function index(): View
    {
        $tasks = Task::active()->ordered()->get();

        return view('tasks.index', [
            'today' => today(),
            'total' => $tasks->count(),
            // Grouped by date only for display; the query itself is unfiltered.
            'days' => $tasks->groupBy(fn (Task $task) => $task->task_date->toDateString()),
        ]);
    }

    /**
     * Create Task form.
     */
    public function create(): View
    {
        return view('tasks.form', [
            'task' => new Task(['task_date' => today(), 'status' => 'pending']),
        ]);
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')->with('status', 'Task added.');
    }

    /**
     * Edit Task form.
     */
    public function edit(Task $task): View
    {
        $this->ensureActive($task);

        return view('tasks.form', ['task' => $task]);
    }

    /**
     * Save changes. When the status changes to "done", email the team once.
     */
    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        $this->ensureActive($task);

        $wasDone = $task->isDone();

        $task->update($request->validated());

        $message = 'Task updated.';

        if (! $wasDone && $task->isDone()) {
            try {
                Mail::to(config('mail.task_notification_address'))->send(new TaskCompleted($task));
                $message = 'Task marked as done. A notification email was sent.';
            } catch (Throwable $e) {
                report($e);
                $message = 'Task marked as done, but the notification email could not be sent.';
            }
        }

        return redirect()->route('tasks.index')->with('status', $message);
    }

    /**
     * Soft delete: archive the task instead of removing the row.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->ensureActive($task);

        $task->archive();

        return redirect()->route('tasks.index')->with('status', 'Task archived.');
    }

    /**
     * Archived tasks cannot be edited or archived again.
     */
    private function ensureActive(Task $task): void
    {
        abort_if($task->is_archived, 404);
    }
}
