{{-- One task row, shared by the Welcome page and the Task List page.
     Pass 'manage' => true to show Edit / Archive (logged-in users only). --}}
<li class="task task--{{ $task->status }}">
    <span class="task-check" aria-hidden="true"></span>
    <div class="task-body">
        <p class="task-title">{{ $task->title }}</p>
        <p class="task-status">{{ $task->statusLabel() }}</p>
    </div>
    @if (($manage ?? false) && auth()->check())
        <div class="task-actions">
            <a class="task-action" href="{{ route('tasks.edit', $task) }}">Edit</a>
            <form action="{{ route('tasks.destroy', $task) }}" method="post"
                  data-confirm="Archive &ldquo;{{ $task->title }}&rdquo;? It will be hidden from every list.">
                @csrf
                @method('DELETE')
                <button class="task-action task-action--danger" type="submit">Archive</button>
            </form>
        </div>
    @endif
</li>
