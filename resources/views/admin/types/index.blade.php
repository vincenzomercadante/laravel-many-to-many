@extends('layouts.app')

@section('title', 'Types')

@section('content')
    <div class="container" id="types">
        @if (session('message-text'))
            <div class="alert {{ session('message-status') }} alert-dismissible fade show my-4" role="alert">
                {{ session('message-text') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1 class="my-3">Types</h1>

        <a href="{{ route('admin.types.create') }}" class="btn btn-primary my-3">Add a Type</a>

        <table class="table">
            <thead>
                <tr>
                    <th class="text-uppercase">id</th>
                    <th class="text-uppercase">label</th>
                    <th class="text-uppercase">color</th>
                    <th class="text-uppercase">badge</th>
                    <th class="text-uppercase">action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($types as $type)
                    <tr>
                        <td>{{ $type->id }}</td>
                        <td>{{ $type->label }}</td>
                        <td>{{ $type->color }}</td>
                        <td>{!! $type->getTypeLabel() !!}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('admin.types.show', $type) }}">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a class="btn btn-warning" href="{{ route('admin.types.edit', $type) }}">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-danger text-uppercase" data-bs-toggle="modal"
                                data-bs-target="#destroy-modal-{{ $type->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100%">No Types Founded</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection

@section('destroy-modal')

    @foreach ($types as $type)
        <!-- Modal -->
        <div class="modal fade" id="destroy-modal-{{ $type->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content" action="{{ route('admin.types.destroy', $type) }}" method="POST">
                    @csrf

                    @method('DELETE')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete {{ $type->label }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="fw-bold text-uppercase text-danger">attention:</span><br>
                        If you delete {{ $type->label }} every project which has this type will be deleted.<br>
                        You confirm this choice?
                        <input type="hidden" name="delete-choice" value="delete-projects">
                        @if ($type->projects->all())
                            You want to change the project type before that?

                            <br>

                            <label for="delete-choice" class="form-label fw-semibold">Delete Method</label>
                            <select name="delete-choice" id="delete-choice" class="form-select">
                                <option value="delete-projects">Delete Projects</option>

                                @foreach ($types as $related_type)
                                    @if ($related_type->id != $type->id)
                                        <option value="{{ $related_type->id }}">{{ $related_type->label }}</option>
                                    @endif
                                @endforeach
                        @endif
                        </select>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <div>

                            <input type="submit" value="Delete Type" class="btn btn-danger">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
