@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="container" id="projects">

        @if (session('message-text'))
            <div class="alert {{ session('message-status') }} alert-dismissible fade show" role="alert">
                {{ session('message-text') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1 class="my-3">Projects</h1>

        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">Add a Project</a>

        <div class="row row-cols-3 mt-4">

            {{-- project card generator --}}
            @foreach ($projects as $project)
                <div class="col">
                    <div class="card h-100">
                        {{-- project image --}}
                        <img src="" class="card-img-top border border-bottom-1 text-center"
                            alt="{{ $project->title }} image">
                        <div class="card-body">
                            {{-- project title --}}
                            <h5 class="card-title">{{ $project->title }}</h5>
                            {{-- project description --}}
                            <p class="card-text">{{ $project->get_description(60) }}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                {{-- link to the project detail --}}
                                <a href={{ route('admin.projects.show', $project) }}
                                    class="card-link">{{ $project->slug }}</a>
                            </li>
                            <li class="list-group-item">
                                {!! $project->type->getTypeLabel() !!}
                            </li>
                        </ul>
                        {{-- link for github --}}
                        <div class="card-body">
                            <a href="{{ $project->github_reference }}"
                                class="card-link">{{ $project->github_reference }}</a>
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <a class="btn btn-primary text-uppercase"
                                    href="{{ route('admin.projects.edit', $project) }}">modify project</a>

                                <button type="button" class="btn btn-danger text-uppercase" data-bs-toggle="modal"
                                    data-bs-target="#destroy-modal-{{ $project->id }}">
                                    delete project
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@section('destroy-modal')

    @foreach ($projects as $project)
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
    @endforeach
@endsection
