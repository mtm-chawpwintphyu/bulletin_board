@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-info text-white">
                {{ __('Profile Details') }}
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 p-2">
                        <div class="text-md-end mr-5">
                            @if($user->profile)
                                <img src="{{ asset('storage/' . $user->profile) }}" alt="Profile Picture" width="150">
                            @else
                                <p>No profile picture uploaded</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row mb-3">
                            <label for="name" class="col-md-2 col-form-label">Name</label>
                            <div class="col-md-5 p-2">
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-5 p-2">
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="phone" class="col-md-2 col-form-label">Phone</label>
                            <div class="col-md-5 p-2">
                                <p>{{ $user->phone }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dob" class="col-md-2 col-form-label ">Date of Birth</label>
                            <div class="col-md-5 p-2">
                                <p>{{ $user->dob }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-md-2 col-form-label ">Address</label>
                            <div class="col-md-5 p-2">
                                <p>{{ $user->address }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="type" class="col-md-2 col-form-label ">User Type</label>
                            <div class="col-md-5 p-2">
                                <p>{{ $user->type == 0 ? 'Admin' : 'User' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection