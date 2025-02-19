@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-info text-white">
                {{ __('Confirm Registration') }}
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                        <div class="col-md-4">
                            <input type="text" name="name" id="name" class="form-control" value="{{ $name }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                        <div class="col-md-4">
                            <input type="text" name="email" id="email" class="form-control" value="{{ $email }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                        <div class="col-md-4">
                            <input type="password" name="password" id="password" class="form-control" value="********"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">Confirm
                            Password</label>
                        <div class="col-md-4">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" value="********" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>
                        <div class="col-md-4">
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $phone }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="dob" class="col-md-4 col-form-label text-md-end">Date of Birth</label>
                        <div class="col-md-4">
                            <input type="text" name="dob" id="dob" class="form-control" value="{{ $dob }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>
                        <div class="col-md-4">
                            <input type="text" name="address" id="address" class="form-control" value="{{ $address }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="type" class="col-md-4 col-form-label text-md-end">Type</label>
                        <div class="col-md-4">
                            <input type="text" name="type" id="type" class="form-control"
                                value="{{ $type == 0 ? 'Admin' : 'User' }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="profile_picture" class="col-md-4 col-form-label text-md-end">Profile Picture</label>
                        <div class="col-md-4">
                            @if($profile_picture)
                                <img src="{{ asset('storage/' . $profile_picture) }}" alt="Profile Picture" width="100">
                                <input type="hidden" name="profile_picture" value="{{ $profile_picture }}">
                            @else
                                <p>No profile picture uploaded</p>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-center" style="gap:1rem;">
                        <button type="submit" class="btn btn-success">Confirm</button>
                        <a href="{{ route('users.create') }}" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection