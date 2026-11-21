<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_seeder_creates_the_required_records(): void
    {
        $this->assertSame(1, User::count());
        $this->assertGreaterThanOrEqual(8, Task::count());
        $this->assertGreaterThanOrEqual(3, Task::distinct()->count('task_date'));
        $this->assertTrue(Task::dueOn(today())->exists());
    }

    public function test_welcome_page_shows_only_todays_tasks(): void
    {
        $response = $this->get('/')->assertOk();

        foreach (Task::all() as $task) {
            $task->task_date->isToday()
                ? $response->assertSee($task->title)
                : $response->assertDontSee($task->title);
        }
    }

    public function test_task_list_shows_every_task_ordered_by_date(): void
    {
        $titles = Task::orderBy('task_date')->orderBy('id')->pluck('title')->all();

        $this->get('/tasks')->assertOk()->assertSeeInOrder($titles);
    }

    public function test_archived_tasks_are_hidden_from_both_lists(): void
    {
        $task = Task::dueOn(today())->first();
        $task->archive();

        $this->get('/')->assertOk()->assertDontSee($task->title);
        $this->get('/tasks')->assertOk()->assertDontSee($task->title);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'is_archived' => true]);
    }

    public function test_profile_page_shows_the_user(): void
    {
        $this->get('/profile')->assertOk()->assertSee('Juan Dela Cruz')->assertSee('jdelacruz');
    }

    public function test_about_page_identifies_the_developer(): void
    {
        $this->get('/about')->assertOk()->assertSee(config('developer.name'));
    }
}
