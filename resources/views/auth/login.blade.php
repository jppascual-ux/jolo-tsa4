@extends('layouts.app', ['active' => 'login'])

@section('title', 'Log in')

@section('content')
<section class="hero hero--compact">
    <div class="wrap">
        <h1 class="headline-xl" data-reveal>Log in.</h1>
        <p class="lede" data-reveal style="--delay: .08s">Sign in to add, edit and archive tasks.</p>
    </div>
</section>

<section class="section section--alt section--tight">
    <div class="wrap wrap--narrow">
        <form class="form" action="{{ route('login') }}" method="post" novalidate data-reveal>
            @csrf

            <div class="field @error('email') field--error @enderror">
                <label class="field-label" for="email">Email</label>
                <input class="field-input" type="email" id="email" name="email"
                       value="{{ old('email') }}" autocomplete="username" autocapitalize="none" spellcheck="false"
                       @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
            </div>
            @error('email')
                <p class="field-message" id="email-error">{{ $message }}</p>
            @enderror

            <div class="field @error('password') field--error @enderror">
                <label class="field-label" for="password">Password</label>
                <input class="field-input" type="password" id="password" name="password"
                       autocomplete="current-password"
                       @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
            </div>
            @error('password')
                <p class="field-message" id="password-error">{{ $message }}</p>
            @enderror

            <label class="checkbox" for="remember">
                <input type="checkbox" id="remember" name="remember" @checked(old('remember'))>
                <span>Remember me</span>
            </label>

            <div class="form-actions">
                <button class="button button--block" type="submit">Log In</button>
            </div>
        </form>
    </div>
</section>
@endsection
