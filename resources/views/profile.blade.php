@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('Welcome, ') }}{{ Auth::user()->name }}</h1>
    <p>{{ __('This is your profile page.') }}</p>
    <!-- Add more profile information here -->
</div>
@endsection
