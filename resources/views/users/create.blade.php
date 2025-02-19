@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    {{ __('Register') }}
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <form method="POST" action="{{ route('users.confirm') }}" enctype="multipart/form-data"
                        style="width: 100%; max-width: 600px;">
                        @csrf
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="name" class="form-label me-3" style="width: 150px;">Name:</label>
                                <input type="text" name="name" id="name" class="form-control" value="">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="email" class="form-label me-3" style="width: 150px;">Email:</label>
                                <input type="email" name="email" id="email" class="form-control" autocomplete="off" writingsuggestions="on" value="">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="password" class="form-label me-3" style="width: 150px;">Password:</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="off" value="">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="password_confirmation" class="form-label me-3" style="width: 150px;">Confirm
                                    Password:</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    autocomplete="off" value="">
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="phone" class="form-label me-3" style="width: 150px;">Phone:</label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="dob" class="form-label me-3" style="width: 150px;">Date of Birth:</label>
                                <input type="date" name="dob" id="dob" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="address" class="form-label me-3" style="width: 150px;">Address:</label>
                                <textarea name="address" id="address" rows="1" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="type" class="form-label me-3" style="width: 150px;">Type:</label>
                                <select name="type" id="type" class="form-select">
                                    <option value="0">Admin</option>
                                    <option value="1">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center">
                                <label for="profile_picture" class="form-label me-3"
                                    style="width: 150px;">Profile:</label>
                                <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                                @error('profile_picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-center" style="gap:1rem;">
                            <button type="submit" class="btn btn-success">Register</button>
                            <button type="reset" class="btn btn-secondary">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
