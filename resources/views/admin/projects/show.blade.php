@extends('layouts.app')

@section('title', $project->title)

@section('content')

    <div id="project-details" class="container mt-4">

        @if (session('message-text'))
            <div class="alert {{ session('message-status') }} alert-dismissible fade show mb-2" role="alert">
                {{ session('message-text') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <h1>
            {{ $project->title }}
        </h1>

        <div class="d-flex gap-4 mt-4">
            <figure>
                <img src="" alt="{{ $project->title }} image">
            </figure>

            <div>
                <h2><span
                        class="fw-semibold text-capitalize mb-2 fs-4 d-inline-block me-2">Title:</span>{{ $project->title }}
                </h2>
                <h3><span class="fw-semibold text-capitalize mb-2 fs-4 d-inline-block">description:
                    </span><br>{{ $project->description }}</h3>
                <a href="{{ $project->github_reference }}">See on GitHub!</a>

                <div class="d-flex gap-3 mt-3">
                    <a href="{{ route('admin.projects.edit', $project) }}"
                        class="btn btn-primary me-3 text-uppercase">Modify project!</a>
                    <button type="button" class="btn btn-danger text-uppercase" data-bs-toggle="modal"
                        data-bs-target="#destroy-modal-{{ $project->id }}">
                        delete project
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('destroy-modal')

    <!-- Modal -->
    <div class="modal fade" id="destroy-modal-{{ $project->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want delete {{ $project->title }} project?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
                        @csrf

                        @method('DELETE')

                        <input type="submit" value="Delete Project" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
