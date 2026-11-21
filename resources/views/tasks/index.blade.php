@extends('layouts.app', ['active' => 'tasks'])

@section('title', 'Task List')

@section('content')
@php
    $names = [
        $today->copy()->subDay()->toDateString() => 'Yesterday',
        $today->toDateString() => 'Today',
        $today->copy()->addDay()->toDateString() => 'Tomorrow',
    ];
@endphp
<section class="hero hero--compact">
    <div class="wrap">
        <h1 class="headline-xl" data-reveal>All tasks.</h1>
        <p class="lede" data-reveal style="--delay: .08s">
            {{ $total }} {{ Str::plural('task', $total) }}, ordered by date.
        </p>
        <p class="hero-actions" data-reveal style="--delay: .16s">
            <a class="button" href="{{ route('tasks.create') }}">New Task</a>
        </p>
    </div>
</section>

<section class="section section--alt section--tight">
    <div class="wrap">
        @forelse ($days as $date => $tasks)
            @php $day = \Illuminate\Support\Carbon::parse($date); @endphp
            <div class="day{{ $date === $today->toDateString() ? ' day--today' : '' }}" data-reveal>
                <div class="day-head">
                    <h2 class="day-title">{{ $names[$date] ?? $day->format('l') }}</h2>
                    <p class="day-meta">{{ $day->format('F j, Y') }}, {{ $tasks->count() }} {{ Str::plural('task', $tasks->count()) }}</p>
                </div>
                <ul class="task-list">
                    @foreach ($tasks as $task)
                        @include('partials.task-row', ['task' => $task, 'manage' => true])
                    @endforeach
                </ul>
            </div>
        @empty
            <p class="empty" data-reveal>No tasks yet.</p>
        @endforelse
    </div>
</section>
@endsection
