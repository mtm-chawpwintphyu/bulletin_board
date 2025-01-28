@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="mb-4">Posts</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach ($posts as $post)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ Str::limit($post->content, 100) }}</p> <!-- Show a brief excerpt -->
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>

</div>
@endsection