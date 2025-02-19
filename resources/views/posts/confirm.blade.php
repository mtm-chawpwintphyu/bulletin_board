@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-info text-white">
            {{ __('Confirm Post') }}
        </div>
        <div class="card-body">
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>
                    <div class="col-md-4">
                        <input type="text" name="title" id="title" class="form-control" value="{{ $title }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
                    <div class="col-md-4">
                        <textarea name="description" id="description" class="form-control"
                            readonly>{{ $description }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-success me-2">Confirm Post</button>
                    <a href="{{ route('create', ['title' => $title, 'description' => $description]) }}"
                        class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection