@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-warning text-white">
            {{ __('Confirm Post Creation') }}
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>
                <div class="col-md-4">
                    <input type="text" name="title" id="title" class="form-control" value="{{ $title }}" readonly>
                </div>
            </div>
            <div class="row mb-3">
                <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
                <div class="col-md-4">
                    <textarea name="description" id="description" class="form-control" readonly>{{ $description }}</textarea>
                </div>
            </div>

            <form action="{{ route('posts.storeFinal') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Confirm</button>
                <a href="{{ route('posts.create') }}" class="btn btn-danger">Cancel</a>
            </form>

        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('posts.index') }}" class="btn btn-primary">Back to Post List</a>
        </div>
    </div>
</div>
@endsection
