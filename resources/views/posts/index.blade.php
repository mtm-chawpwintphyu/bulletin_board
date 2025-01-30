@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    {{ __('Post List') }}
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <!-- Search Form -->
                    <form action="{{ route('posts.index') }}" method="GET"
                        class="d-flex align-items-center py-3 justify-content-end" style="gap: 1rem;">
                        <label for="keyword" class="mr-10">Keyword: </label>
                        <input type="text" name="keyword" class="form-control mr-4 w-auto" placeholder="Search..."
                            value="{{ request()->input('keyword') }}">
                        <button type="submit" name="search" class="btn btn-success">Search</button>
                    </form>

                    <!-- Action Buttons (Create, Upload, Download) -->
                    <div class="d-flex align-items-center py-3 justify-content-end" style="gap: 1rem;">
                        <a href="{{ route('posts.create') }}" class="btn btn-primary" method="GET">Create</a>
                        <button type="button" class="btn btn-success">Upload</button>
                        <button type="button" class="btn btn-info">Download</button>
                    </div>

                    <!-- Post Table -->
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr class="table-success text-white">
                                <th>Post Title</th>
                                <th>Post Description</th>
                                <th>Posted User</th>
                                <th>Created At</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @forelse ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->description }}</td>
                                    <td>{{ $post->creator->name ?? 'Unknown' }}</td>
                                    <td>{{ $post->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                    <div class="d-flex justify-content-between">
                        <div>
                            Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }}
                            results
                        </div>
                        <div>
                            <nav>
                                <ul class="pagination">

                                    @if ($posts->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $posts->previousPageUrl() }}"
                                                rel="prev">Previous</a>
                                        </li>
                                    @endif

                                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                                        <li class="page-item {{ $posts->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($posts->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection