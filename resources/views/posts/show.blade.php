@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-info text-white">
            {{ $post->title }}
        </div>
        <div class="card-body">
            <p>{{ $post->description }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Post List</a>
        </div>
    </div>
</div>
@endsection
