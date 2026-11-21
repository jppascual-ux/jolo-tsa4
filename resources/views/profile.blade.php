@extends('layouts.app', ['active' => 'profile'])

@section('title', 'Profile')

@section('content')
@if ($user === null)
    <section class="hero hero--compact">
        <div class="wrap">
            <h1 class="headline-xl">Profile.</h1>
            <p class="lede">No user record found. Run <code>php artisan migrate --seed</code> or import the SQL file.</p>
        </div>
    </section>
@else
    <section class="hero hero--compact">
        <div class="wrap">
            <div class="avatar" data-reveal aria-hidden="true">{{ $user->initials() }}</div>
            <h1 class="headline-xl headline-xl--name" data-reveal style="--delay: .08s">{{ $user->full_name }}</h1>
            <p class="lede" data-reveal style="--delay: .16s">&#64;{{ $user->username }}</p>
        </div>
    </section>

    <section class="section section--alt section--tight">
        <div class="wrap wrap--narrow">
            <h2 class="group-heading" data-reveal>Account</h2>
            <dl class="group" data-reveal>
                <div class="group-row"><dt>User ID</dt><dd>{{ $user->id }}</dd></div>
                <div class="group-row"><dt>Username</dt><dd>{{ $user->username }}</dd></div>
                <div class="group-row"><dt>Full name</dt><dd>{{ $user->full_name }}</dd></div>
                <div class="group-row"><dt>Email</dt><dd><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></dd></div>
                <div class="group-row"><dt>Member since</dt><dd>{{ $user->created_at?->format('F j, Y') }}</dd></div>
            </dl>
        </div>
    </section>
@endif
@endsection
