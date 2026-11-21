@extends('layouts.app', ['active' => 'tasks'])

@section('title', $task->exists ? 'Edit Task' : 'New Task')

@section('content')
@php
    $status = old('status', $task->status ?? 'pending');
@endphp
<section class="hero hero--compact">
    <div class="wrap">
        <h1 class="headline-xl" data-reveal>{{ $task->exists ? 'Edit task.' : 'New task.' }}</h1>
        <p class="lede" data-reveal style="--delay: .08s">
            {{ $task->exists ? 'Update the details and save your changes.' : 'Give it a title and a date.' }}
        </p>
    </div>
</section>

<section class="section section--alt section--tight">
    <div class="wrap wrap--narrow">
        <form class="form" method="post" novalidate data-reveal
              action="{{ $task->exists ? route('tasks.update', $task) : route('tasks.store') }}">
            @csrf
            @if ($task->exists)
                @method('PUT')
            @endif

            <div class="field @error('title') field--error @enderror">
                <label class="field-label" for="title">Title</label>
                <input class="field-input" type="text" id="title" name="title" maxlength="150"
                       value="{{ old('title', $task->title) }}" autocomplete="off"
                       @error('title') aria-invalid="true" aria-describedby="title-error" @enderror>
            </div>
            @error('title')
                <p class="field-message" id="title-error">{{ $message }}</p>
            @enderror

            <div class="field @error('task_date') field--error @enderror">
                <label class="field-label" for="task_date">Date</label>
                <input class="field-input" type="date" id="task_date" name="task_date"
                       value="{{ old('task_date', $task->task_date?->toDateString()) }}"
                       @error('task_date') aria-invalid="true" aria-describedby="task_date-error" @enderror>
            </div>
            @error('task_date')
                <p class="field-message" id="task_date-error">{{ $message }}</p>
            @enderror

            <div class="field field--select @error('status') field--error @enderror">
                <label class="field-label" for="status">Status</label>
                <select class="field-input" id="status" name="status"
                        @error('status') aria-invalid="true" aria-describedby="status-error" @enderror>
                    @foreach (\App\Models\Task::STATUSES as $value => $label)
                        <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            @error('status')
                <p class="field-message" id="status-error">{{ $message }}</p>
            @enderror

            <div class="form-actions">
                <button class="button button--block" type="submit">{{ $task->exists ? 'Save Changes' : 'Add Task' }}</button>
                <a class="form-cancel" href="{{ route('tasks.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</section>
@endsection
