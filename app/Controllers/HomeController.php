<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Welcome page: only the tasks whose task_date is today.
     */
    public function index(): View
    {
        $today = today();

        $tasks = Task::dueOn($today)->orderBy('id')->get();

        return view('home', [
            'today' => $today,
            'tasks' => $tasks,
            'counts' => [
                'done' => $tasks->where('status', 'done')->count(),
                'in-progress' => $tasks->where('status', 'in-progress')->count(),
                'pending' => $tasks->where('status', 'pending')->count(),
            ],
        ]);
    }
}
