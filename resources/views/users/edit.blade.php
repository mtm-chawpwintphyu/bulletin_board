@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-info text-white">
                {{ __('Edit Profile') }}
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-5 ms-3">
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name',  $user->name) }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-5 ms-3">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="type" class="col-md-4 col-form-label text-md-end">Type</label>
                            <div class="col-md-5 ms-3">
                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
                                    <option value="0" {{ old('type', $user->type) == 0 ? 'selected' : '' }}>Admin</option>
                                    <option value="1" {{ old('type', $user->type) == 1 ? 'selected' : '' }}>User</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>
                            <div class="col-md-5 ms-3">
                                <input type="text" name="phone" id="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="dob" class="col-md-4 col-form-label text-md-end">Date of Birth</label>
                            <div class="col-md-5 ms-3">
                                <input type="date" name="dob" id="dob"
                                    class="form-control @error('dob') is-invalid @enderror"
                                    value="{{ old('dob', $user->dob) }}">
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>
                            <div class="col-md-5 ms-3">
                                <input type="text" name="address" id="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address', $user->address) }}">
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="profile_picture" class="col-md-4 col-form-label text-md-end">Old Profile</label>
                            <div class="col-md-5 ms-3">
                                @if($user->profile)
                                    <img src="{{ asset('storage/' . $user->profile) }}" alt="Profile Picture" width="100">
                                @else
                                    <p>No profile picture uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="profile_picture" class="col-md-4 col-form-label text-md-end">New Profile</label>
                            <div class="col-md-5 ms-3">
                                <input type="file" name="profile_picture" id="profile_picture"
                                    class="form-control @error('profile_picture') is-invalid @enderror">
                                @error('profile_picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                        <button type="button" id="reset-btn" class="btn btn-secondary ms-2">Clear</button>
                        <a href="{{ route('users.password', ['id' => $user->id]) }}" class="ms-3 p-2 text-decoration-none">Change Password</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('reset-btn').addEventListener('click', function () {
            let form = this.closest('form');
            form.reset();
        });
    </script>
@endsection