@extends('layouts.app')

@section('title', 'Type {{ $type->label }}')

@section('content')

    <div class="container">
        <div class="d-flex gap-3 align-items-center">
            <h1 class="my-3">{{ $type->label }}</h1>
            {!! $type->getTypeLabel() !!}
        </div>
        <h2 class="mb-3">Reltated Projects</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Github Link</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->slug }}</td>
                        <td><a href="{{ $project->github_reference }}">{{ $project->github_reference }}</a></td>
                        <td>{{ $project->get_description(60) }}</td>
                        <td>
                            <a href="{{ route('admin.projects.show', $projects) }}" class="btn btn-primary"><i
                                    class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.projects.edit', $projects) }}" class="btn btn-warning">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-danger text-uppercase" data-bs-toggle="modal"
                                data-bs-target="#destroy-modal-{{ $project->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%">No Project Founded</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                        Do you want delete "{{ $project->title }}" project?
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
