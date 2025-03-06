@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        {{ __('User List') }}
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="GET" action="{{ route('users.index') }}" class="mb-4">
                            <div class="row align-items-center mt-3">
                                <div class="col-md-3 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <label for="name" class="form-label me-2 text-center" style="flex: 1;">Name:</label>
                                        <input type="text" name="name" id="name" value="{{ request()->get('name') }}"
                                            class="form-control" style="flex: 2;">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <label for="email" class="form-label me-2 text-center"
                                            style="flex: 1;">Email:</label>
                                        <input type="text" name="email" id="email" value="{{ request()->get('email') }}"
                                            class="form-control" style="flex: 2;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <label for="from_date" class="form-label me-2 text-center"
                                            style="flex: 1;">From:</label>
                                        <input type="date" name="from_date" id="from_date"
                                            value="{{ request()->get('from_date') }}" class="form-control" style="flex: 2;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <label for="to_date" class="form-label me-2 text-center"
                                            style="flex: 1;">To:</label>
                                        <input type="date" name="to_date" id="to_date"
                                            value="{{ request()->get('to_date') }}" class="form-control" style="flex: 2;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr class="table-success text-black">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created User</th>
                                        <th>Type</th>
                                        <th>Phone</th>
                                        <th>Date of Birth</th>
                                        <th>Address</th>
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $index }}</td>
                                            <td>
                                                <a href="javascript:void(0);" class="post-title text-decoration-none"
                                                    data-bs-toggle="modal" data-bs-target="#userDetailsModal"
                                                    data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                                    data-user-email="{{ $user->email }}" data-user-phone="{{ $user->phone }}"
                                                    data-user-dob="{{ $user->dob }}" data-user-address="{{ $user->address }}"
                                                    data-user-type="{{ $user->type == 0 ? 'Admin' : 'User' }}"
                                                    data-user-created-at="{{ $user->created_at->format('d M, Y') }}"
                                                    data-user-updated-at="{{ $user->updated_at->format('d M, Y') }}"
                                                    data-user-created-user="{{ $user->created_user_name ?? 'Unknown' }}"
                                                    data-user-updated-user-id="{{ $user->updated_user_id }}"
                                                    data-user-profile="{{ $user->profile ? asset('storage/' . $user->profile) : null }}">
                                                    {{ $user->name }}
                                                </a>
                                            </td>

                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_user_name ?? 'Unknown' }}</td>
                                            <td>
                                                @if ($user->type == 0)
                                                    Admin
                                                @else
                                                    User
                                                @endif
                                            </td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ \Carbon\Carbon::parse($user->dob)->format('d M, Y') }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ $user->created_at->format('d M, Y') }}</td>
                                            <td>{{ $user->updated_at->format('d M, Y') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm delete-button"
                                                    data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                                    data-user-email="{{ $user->email }}" data-user-phone="{{ $user->phone }}"
                                                    data-user-dob="{{ $user->dob }}" data-user-address="{{ $user->address }}"
                                                    data-user-type="{{ $user->type == 0 ? 'Admin' : 'User' }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}
                                results
                            </div>
                            <div>
                                <nav>
                                    <ul class="pagination">
                                        @if ($users->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->previousPageUrl() }}"
                                                    rel="prev">Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                            <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach

                                        @if ($users->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->nextPageUrl() }}" rel="next">Next</a>
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

    <!--Details Modal -->
    <div class="modal" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-3 shadow-lg">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="userDetailsModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4"><strong>ID:</strong></div>
                        <div class="col-8"><span id="modalUserId" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Name:</strong></div>
                        <div class="col-8"><span id="modalUserName" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Email:</strong></div>
                        <div class="col-8"><span id="modalUserEmail" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Phone:</strong></div>
                        <div class="col-8"><span id="modalUserPhone" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Date of Birth:</strong></div>
                        <div class="col-8"><span id="modalUserDob" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Address:</strong></div>
                        <div class="col-8"><span id="modalUserAddress" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Type:</strong></div>
                        <div class="col-8"><span id="modalUserType" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Created Date:</strong></div>
                        <div class="col-8"><span id="modalUserCreatedAt" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Created User:</strong></div>
                        <div class="col-8"><span id="modalUserCreatedUser" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Updated Date:</strong></div>
                        <div class="col-8"><span id="modalUserUpdatedAt" class="text-danger"></span></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4"><strong>Updated User:</strong></div>
                        <div class="col-8"><span id="modalUserUpdatedUser" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Profile:</strong></div>
                        <div class="col-8">
                            <span id="modalUserProfile"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="confirmationText">Are you sure you want to delete this user?</p>
                    <div class="row mb-3">
                        <div class="col-4"><strong>ID:</strong></div>
                        <div class="col-8"><span id="deleteUserId" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Name:</strong></div>
                        <div class="col-8"><span id="deleteUserName" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Email:</strong></div>
                        <div class="col-8"><span id="deleteUserEmail" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Phone:</strong></div>
                        <div class="col-8"><span id="deleteUserPhone" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Date of Birth:</strong></div>
                        <div class="col-8"><span id="deleteUserDob" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Address:</strong></div>
                        <div class="col-8"><span id="deleteUserAddress" class="text-danger"></span></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4"><strong>Type:</strong></div>
                        <div class="col-8"><span id="deleteUserType" class="text-danger"></span></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form id="deleteUserForm" action="" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="currentUserId" value="{{ auth()->id() }}">
                        <button type="submit" id="deleteButton" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection