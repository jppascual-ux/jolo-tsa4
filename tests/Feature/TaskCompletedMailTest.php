<?php

namespace Tests\Feature;

use App\Mail\TaskCompleted;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

/**
 * The TaskCompleted email is sent when a task's status changes to done,
 * and only then.
 */
class TaskCompletedMailTest extends TestCase
{
    use RefreshDatabase;

    private function updateTask(Task $task, array $changes)
    {
        return $this->actingAs(User::factory()->create())->put("/tasks/{$task->id}", array_merge([
            'title' => $task->title,
            'task_date' => $task->task_date->toDateString(),
            'status' => $task->status,
        ], $changes));
    }

    public function test_marking_a_pending_task_as_done_sends_the_email(): void
    {
        Mail::fake();
        config(['mail.task_notification_address' => 'team@example.com']);
        $task = Task::factory()->pending()->create();

        $this->updateTask($task, ['status' => 'done'])->assertRedirect('/tasks');

        Mail::assertSent(TaskCompleted::class, 1);
        Mail::assertSent(TaskCompleted::class, fn (TaskCompleted $mail) => $mail->hasTo('team@example.com') && $mail->task->is($task));
    }

    public function test_updating_a_task_that_is_already_done_does_not_resend(): void
    {
        Mail::fake();
        $task = Task::factory()->done()->create();

        $this->updateTask($task, ['title' => 'Renamed but still done'])->assertRedirect('/tasks');

        Mail::assertNothingSent();
    }

    public function test_other_status_changes_do_not_send_the_email(): void
    {
        Mail::fake();
        $task = Task::factory()->pending()->create();

        $this->updateTask($task, ['status' => 'in-progress']);

        Mail::assertNothingSent();
    }

    public function test_the_email_shows_the_task(): void
    {
        $task = Task::factory()->done()->create(['title' => 'Ship the release']);

        $mail = new TaskCompleted($task);

        $mail->assertHasSubject('Task completed: Ship the release');
        $mail->assertSeeInHtml('Ship the release');
    }
}
