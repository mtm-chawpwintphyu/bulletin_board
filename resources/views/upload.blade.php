@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h2>{{ __('Upload CSV File') }}</h2>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @error('file')
                    <div class="alert alert-danger text-danger">{{ $message }}</div>
                @enderror

                <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">{{ __('CSV File') }} *</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">{{ __('Upload') }}</button>
                        <button type="reset" class="btn btn-secondary ms-2">{{ __('Clear') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection