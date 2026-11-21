<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * 10 tasks across 4 dates. Dates are relative to the day the seeder runs,
     * so today always has tasks no matter when the project is installed.
     */
    public function run(): void
    {
        $tasks = [
            // [title, status, days from today]
            ['Draft weekly content calendar', 'done', -1],
            ['Review partner brief for the October campaign', 'done', -1],
            ['Back up the shared project drive', 'pending', -1],
            ['Stand-up meeting with the web team', 'done', 0],
            ['Fix broken links on the landing page', 'in-progress', 0],
            ['Update brand colors in the style guide', 'pending', 0],
            ['Send status report to the project lead', 'pending', 0],
            ['Prepare client presentation slides', 'pending', 1],
            ['Test the contact form on mobile browsers', 'pending', 1],
            ['Deploy the September release to hosting', 'pending', 3],
        ];

        foreach ($tasks as [$title, $status, $offset]) {
            Task::create([
                'title' => $title,
                'status' => $status,
                'task_date' => today()->addDays($offset),
            ]);
        }
    }
}
