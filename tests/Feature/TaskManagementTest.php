<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Access control and CRUD for tasks.
 */
class TaskManagementTest extends TestCase
{
    use RefreshDatabase;

    private function validData(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Review TSA4 checklist',
            'task_date' => today()->toDateString(),
            'status' => 'pending',
        ], $overrides);
    }

    // ---------------------------------------------------------- logged out

    public function test_public_pages_are_viewable_by_guests(): void
    {
        foreach (['/', '/tasks', '/profile', '/about', '/login'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_guests_are_redirected_to_login_for_every_management_action(): void
    {
        $task = Task::factory()->create();

        $this->get('/tasks/create')->assertRedirect('/login');
        $this->post('/tasks', $this->validData())->assertRedirect('/login');
        $this->get("/tasks/{$task->id}/edit")->assertRedirect('/login');
        $this->put("/tasks/{$task->id}", $this->validData())->assertRedirect('/login');
        $this->delete("/tasks/{$task->id}")->assertRedirect('/login');

        $this->assertDatabaseCount('tasks', 1);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'is_archived' => false]);
    }

    // ----------------------------------------------------------- logged in

    public function test_logged_in_user_can_create_a_task(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/tasks', $this->validData())
            ->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', ['title' => 'Review TSA4 checklist', 'is_archived' => false]);
    }

    public function test_create_rejects_missing_and_bad_input(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/tasks', ['title' => '   ', 'task_date' => '', 'status' => 'hacked'])
            ->assertSessionHasErrors(['title', 'task_date', 'status']);

        $this->actingAs(User::factory()->create())
            ->post('/tasks', $this->validData(['task_date' => '2026-13-45', 'title' => str_repeat('x', 151)]))
            ->assertSessionHasErrors(['task_date', 'title']);

        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_logged_in_user_can_edit_and_update_a_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->pending()->create(['title' => 'Old title']);

        $this->actingAs($user)->get("/tasks/{$task->id}/edit")->assertOk()->assertSee('Old title');

        $this->actingAs($user)
            ->put("/tasks/{$task->id}", $this->validData(['title' => 'New title', 'status' => 'in-progress']))
            ->assertRedirect('/tasks');

        $this->assertSame('New title', $task->fresh()->title);
        $this->assertSame('in-progress', $task->fresh()->status);
    }

    public function test_update_rejects_bad_input(): void
    {
        $task = Task::factory()->create(['title' => 'Keep me']);

        $this->actingAs(User::factory()->create())
            ->put("/tasks/{$task->id}", ['title' => '', 'task_date' => 'tomorrow', 'status' => ''])
            ->assertSessionHasErrors(['title', 'task_date', 'status']);

        $this->assertSame('Keep me', $task->fresh()->title);
    }

    public function test_delete_archives_the_task_instead_of_removing_it(): void
    {
        $task = Task::factory()->create();

        $this->actingAs(User::factory()->create())
            ->delete("/tasks/{$task->id}")
            ->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'is_archived' => true]);
        $this->get('/tasks')->assertDontSee($task->title);
    }

    public function test_archived_tasks_cannot_be_edited(): void
    {
        $task = Task::factory()->archived()->create();

        $this->actingAs(User::factory()->create())
            ->get("/tasks/{$task->id}/edit")
            ->assertNotFound();
    }
}
