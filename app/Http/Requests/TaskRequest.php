<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validation for the Create Task and Edit Task forms.
 * (Surrounding spaces are already trimmed by Laravel's TrimStrings middleware.)
 */
class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Access is controlled by the auth middleware on the routes.
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'task_date' => ['required', 'date_format:Y-m-d'],
            'status' => ['required', Rule::in(array_keys(Task::STATUSES))],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Enter a title for the task.',
            'title.max' => 'Keep the title under 150 characters.',
            'task_date.required' => 'Choose a date for the task.',
            'task_date.date_format' => 'Enter a valid date.',
            'status.required' => 'Choose a status.',
            'status.in' => 'Choose a valid status.',
        ];
    }
}
