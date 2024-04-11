@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')

    <div class="container">
        <h1 class="my-3">Edit a Project</h1>

        <form action="{{ route('admin.projects.update', $project) }}" method="POST" class="row gy-4"
            enctype="multipart/form-data">
            @csrf

            @method('PATCH')

            <div class="col-4">
                <label for="title" class="form-label mb-2">Project's Title</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                    placeholder="Project's Title" value="{{ old('title', $project->title) }}">
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-4">
                <label for="type_id" class="form-label mb-2">Project's Type</label>
                <select name="type_id" id="type_id" class="form-select">
                    <option selected class="d-none">Select a project type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" @if (old('type_id', $type->id) == $type->id) selected @endif>
                            {{ $type->label }}
                        </option>
                    @endforeach
                </select>
                @error('type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- image input file col --}}
            <div class="col-4">
                <label for="image" class="form-label">Project Image:</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            {{-- technologies checkbox col --}}
            <div class="col-12 ">
                <label for="" class="form-label mb-2">Project's Technologies:</label>

                <div class="@error('technologies') is-invalid @enderror d-flex align-items-center justify-content-between">
                    @foreach ($technologies as $technology)
                        <div>
                            <input type="checkbox" name="technologies[]" id="check-{{ $technology->id }}"
                                value="{{ $technology->id }}" class="form-check-input"
                                @if (old('technologies') == $technology->id || in_array($technology->id, $project->getTechArray())) checked @endif>
                            <label for="check-{{ $technology->id }}"
                                class="form-check-label">{{ $technology->label }}</label>
                        </div>
                    @endforeach
                </div>
                @error('technologies')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="github_reference" class="form-label mb-2">Github Link</label>
                <input type="url" name="github_reference" id="github_reference"
                    class="form-control @error('github_reference') is-invalid @enderror" placeholder="Project's Github Link"
                    value="{{ old('github_reference', $project->github_reference) }}">
                @error('github_reference')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="description" class="form-label mb-2">Project's Description</label>
                <textarea name="description" id="description" cols="30" rows="10"
                    class="form-control @error('description') is-invalid @enderror" placeholder="Project's Description">{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12 d-flex gap-2">
                <input type="submit" value="Save" class="btn btn-success">
                <input type="reset" value="Clear" class="btn btn-warning">

            </div>
        </form>

        @if ($project->image)
            <div class="image-preview my-5">
                <h2>Image Preview</h2>
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $project->image) }}" alt="" class="img-fluid">
                    <div class="delete-preview" id="delete-preview">
                        X
                    </div>
                </div>

                <form action="{{ route('admin.projects.delete-image', $project) }}" method="POST" class="d-none"
                    id="delete-form">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @endif
    </div>

@endsection

@section('js')
    <script>
        const deleteButton = document.getElementById('delete-preview')
        const deleteForm = document.getElementById('delete-form')

        deleteButton.addEventListener('click', () => {
            deleteForm.submit();
        })
    </script>

@endsection
