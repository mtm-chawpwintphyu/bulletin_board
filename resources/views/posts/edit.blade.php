@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    {{ __('Edit Post') }}
                </div>
                <div class="card-body">
                    <!-- Edit Post Form -->
                    <form action="{{ route('posts.update', $post->id) }}" method="POST">
                        @csrf
                        @method('PUT') 

                        <!-- Title Field -->
                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>
                            <div class="col-md-6">
                                <input type="text" id="title" name="title" class="form-control"
                                    value="{{ old('title', $post->title) }}" required>
                            </div>
                        </div>

                        <!-- Description Field -->
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
                            <div class="col-md-6">
                                <textarea id="description" name="description" class="form-control" rows="5"
                                    required>{{ old('description', $post->description) }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-end">Status</label>
                            <div class="col-md-6">
                                <input type="checkbox" class="form-check-input" name="status" id="status" {{ old('status', $post->status ? 'checked' : '') }}>
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Edit</button>
                                <button type="reset" class="btn btn-secondary">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection