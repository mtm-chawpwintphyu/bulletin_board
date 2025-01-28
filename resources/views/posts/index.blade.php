@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    {{__('Post List') }}
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center py-3 justify-content-end">
                        <label for="keyword" class="mr-10">Keyword : </label>
                        <input type="text" name="keyword" class="form-control mr-2 w-auto" placeholder="Search...">
                        <button type="submit" name="search" class="btn btn-success mr-2">Search</button>
                        <button type="submit" name="create" class="btn btn-primary mr-2">Create</button>
                        <button type="submit" name="upload" class="btn btn-success mr-2">Upload</button>
                        <button type="submit" name="download" class="btn btn-info">Download</button>
                    </div>

                    <!-- Table inside card-body -->
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
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->description }}</td>
                                    <td>{{ $post->creator->name ?? 'Unknown' }}</td>
                                    <td>{{ $post->created_at->format('d M, Y') }}</td>
                                    <td colspan="2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit</a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination Links -->
                    <div>
                        {{ $posts->links('pagination::simple-default') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection