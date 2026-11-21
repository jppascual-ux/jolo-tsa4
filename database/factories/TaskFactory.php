<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'status' => fake()->randomElement(array_keys(Task::STATUSES)),
            'task_date' => today(),
            'is_archived' => false,
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function done(): static
    {
        return $this->state(['status' => 'done']);
    }

    public function archived(): static
    {
        return $this->state(['is_archived' => true]);
    }
}
