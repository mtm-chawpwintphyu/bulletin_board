@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header text-white bg-success">
                <h2>Change Password</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.updatePassword', $user->id) }}">
                    @csrf
                    <input type="hidden" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        value="{{ old('password', $user->password) }}">

                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="current_password" class="col-md-4 col-form-label text-md-end">Current
                                Password <sup class="text-danger">*</sup></label>
                            <div class="col-md-5 ms-3">
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" autocomplete="off">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="new_password" class="col-md-4 col-form-label text-md-end">New Password<sup
                                    class="text-danger">*</sup></label>
                            <div class="col-md-5 ms-3">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password" autocomplete="new-password">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="d-flex align-items-center">
                            <label for="confirm_password" class="col-md-4 col-form-label text-md-end">Confirm New
                                Password<sup class="text-danger">*</sup></label>
                            <div class="col-md-5 ms-3">
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                                    id="confirm_password" name="confirm_password" autocomplete="off">
                                @error('confirm_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary d-flex justify-content-center align-items-center mx-auto">
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection