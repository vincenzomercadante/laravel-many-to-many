@extends('layouts.app')

@section('title', 'Technologies')

@section('content')
    <div class="container" id="technology">
        @if (session('message-text'))
            <div class="alert {{ session('message-status') }} alert-dismissible fade show my-4" role="alert">
                {{ session('message-text') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1 class="my-3">Technologies</h1>

        <a href="{{ route('admin.technologies.create') }}" class="btn btn-primary my-3">Add a Technology</a>

        <table class="table">
            <thead>
                <tr>
                    <th class="text-uppercase">id</th>
                    <th class="text-uppercase">label</th>
                    <th class="text-uppercase">color</th>
                    <th class="text-uppercase">badge</th>
                    <th class="text-uppercase">actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($technologies as $technology)
                    <tr>
                        <td>{{ $technology->id }}</td>
                        <td>{{ $technology->label }}</td>
                        <td>{{ $technology->color }}</td>
                        <td>{!! $technology->getTechnologyLabel() !!}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.technologies.show', $technology) }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a class="btn btn-warning" href="{{ route('admin.technologies.edit', $technology) }}">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-danger text-uppercase" data-bs-toggle="modal"
                                data-bs-target="#destroy-modal-{{ $technology->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%">No Technologies Founded</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection

@section('destroy-modal')

    @foreach ($technologies as $technology)
        <!-- Modal -->
        <div class="modal fade" id="destroy-modal-{{ $technology->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete "{{ $technology->label }}"</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want delete "{{ $technology->label }}" technology?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('admin.technologies.destroy', $technology) }}" method="POST">
                            @csrf

                            @method('DELETE')

                            <input type="submit" value="Delete Technology" class="btn btn-danger">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
