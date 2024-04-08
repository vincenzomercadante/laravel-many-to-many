@extends('layouts.app')

@section('title', 'Create Type')

@section('content')
    <div class="container">
        <h1 class="my-3">Create a new Type</h1>

        <form action="{{ route('admin.types.store') }}" method="POST" class="row gy-3">

            @csrf

            <div class="col-2">
                <label for="color" class="form-label">Badge Color:</label>
                <input type="color" name="color" id="color" class="form-control @error('color') is-invalid @enderror"
                    value="{{ old('color') }}" required>
                @error('color')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-10">
                <label for="label" class="form-label">Type Label:</label>
                <input type="text" name="label" id="label"
                    class="form-control @error('label') is-invalid @enderror" value="{{ old('label') }}"
                    placeholder="Type Label" required>
                @error('label')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </div>

        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
