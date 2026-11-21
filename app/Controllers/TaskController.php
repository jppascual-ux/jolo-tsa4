<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Task List page: every task, ordered by date.
     */
    public function index(): View
    {
        $tasks = Task::ordered()->get();

        return view('tasks.index', [
            'today' => today(),
            'total' => $tasks->count(),
            // Grouped by date only for display; the query itself is unfiltered.
            'days' => $tasks->groupBy(fn (Task $task) => $task->task_date->toDateString()),
        ]);
    }
}
