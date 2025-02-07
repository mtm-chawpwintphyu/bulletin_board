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
                    <form action="{{ route('posts.index') }}" method="GET"
                        class="d-flex align-items-center py-3 justify-content-end" style="gap: 1rem;">
                        <label for="keyword" class="mr-10">Keyword: </label>
                        <input type="text" name="keyword" class="form-control mr-4 w-auto" placeholder="Search..."
                            value="{{ request()->input('keyword') }}">
                        <button type="submit" name="search" class="btn btn-success">Search</button>
                    </form>

                    <div class="d-flex align-items-center py-3 justify-content-end" style="gap: 1rem;">
                        <a href="{{ route('posts.create') }}" class="btn btn-primary" method="GET">Create</a>
                        <button type="button" class="btn btn-success">Upload</button>
                        <button type="button" class="btn btn-info">Download</button>
                    </div>

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
                                    <td>
                                        <a href="javascript:void(0);" class="post-title text-decoration-none" data-post-id="{{ $post->id }}"
                                            data-post-title="{{ $post->title }}"
                                            data-post-description="{{ $post->description }}"
                                            data-post-status="{{ $post->status }}"
                                            data-post-created-by="{{ $post->creator->name ?? 'Unknown' }}"
                                            data-post-created-at="{{ $post->created_at->format('d M, Y') }}"
                                            data-post-updated-by="{{ $post->updater->name ?? 'Unknown' }}"
                                            data-post-updated-at="{{ $post->updated_at->format('d M, Y') }}">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td>{{ $post->description }}</td>
                                    <td>{{ $post->creator->name ?? 'Unknown' }}</td>
                                    <td>{{ $post->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-post-id="{{ $post->id }}"
                                            data-post-title="{{ $post->title }}"
                                            data-post-description="{{ $post->description }}"
                                            data-post-status="{{ $post->status }}" writingsuggestions="on">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No data availabel in this table.</td>
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

<!-- delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="lead">Are you sure to delete the post?</p>
                <div class="row mb-3">
                    <div class="col-4"><strong>ID:</strong></div>
                    <div class="col-8"><span id="postId" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Title:</strong></div>
                    <div class="col-8"><span id="postTitle" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Description:</strong></div>
                    <div class="col-8"><span id="postDescription" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Status:</strong></div>
                    <div class="col-8"><span id="postStatus" class="text-danger"></span></div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Post Details Modal -->
<div class="modal fade" id="postDetailsModal" tabindex="-1" aria-labelledby="postDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="postDetailsModalLabel">Post Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-4"><strong>ID:</strong></div>
                    <div class="col-8"><span id="modalPostId" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Title:</strong></div>
                    <div class="col-8"><span id="modalPostTitle" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Description:</strong></div>
                    <div class="col-8"><span id="modalPostDescription" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Status:</strong></div>
                    <div class="col-8"><span id="modalPostStatus" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Created By:</strong></div>
                    <div class="col-8"><span id="modalPostCreatedBy" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Created At:</strong></div>
                    <div class="col-8"><span id="modalPostCreatedAt" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Updated By:</strong></div>
                    <div class="col-8"><span id="modalPostUpdatedBy" class="text-danger"></span></div>
                </div>
                <div class="row mb-3">
                    <div class="col-4"><strong>Updated At:</strong></div>
                    <div class="col-8"><span id="modalPostUpdatedAt" class="text-danger"></span></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection