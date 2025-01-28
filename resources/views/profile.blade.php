{{-- resources/views/profile.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Profile</h1>

    {{-- You can display user-specific details here, for example: --}}
    <p>Name: {{ auth()->user()->name }}</p>
    <p>Email: {{ auth()->user()->email }}</p>

    {{-- Add other user profile information here --}}
</div>
@endsection