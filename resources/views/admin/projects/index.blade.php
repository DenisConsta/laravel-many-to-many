@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {!! session('success') !!}
        </div>
    @elseif (session('denied'))
        <div class="alert alert-danger" role="alert">
            {!! session('denied') !!}
        </div>
    @endif

    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col"> @sortablelink('id') </th>
                <th scope="col"> @sortablelink('name') </th>
                <th scope="col"> Technologies </th>
                <th scope="col"> @sortablelink('client_name')</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td> {{ $project->id }} </td>
                    <td> {{ $project->name }}
                        @if ($project->type?->name)
                            {{-- ! --}}
                            <form action="{{ route('admin.projects.index') }}" method="GET">
                                @csrf
                                <button type="submit" class=" border-0 badge text-bg-info text-decoration-none"
                                    value="{{ $project->type_id }}" name="type">
                                    {{ $project->type?->name }}
                                </button>
                            </form>

                            {{-- <a href=" {{ route('admin.projects.allOf', $project->type) }} "
                                class="badge text-bg-info text-decoration-none" name="tag"
                                value={{ $project->type_id }}>{{ $project->type?->name }}
                            </a> --}}
                        @endif
                    </td>
                    <td>
                        @forelse ($project->technologies as $tech)
                            {{-- <span class="badge text-bg-warning "> {{ $tech->name }} </span> --}}

                            {{-- ! --}}
                            <form action="{{ route('admin.projects.index') }}" method="GET">
                                @csrf
                                <button type="submit" class=" border-0 badge text-bg-info text-decoration-none"
                                    value="{{ $tech->id }}" name="technology">
                                    {{ $tech->name }}
                                </button>
                            </form>

                        @empty
                        @endforelse
                    </td>
                    <td> {{ $project->client_name }} </td>
                    <td>
                        <div class="btns">
                            <a href=" {{ route('admin.projects.show', $project) }} " title="show"
                                class="btn btn-primary"><i class="fa-regular fa-eye"></i></a>
                            <a href=" {{ route('admin.projects.edit', $project) }} " title="edit"
                                class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>

                            @include('admin.partials.form-delete', [
                                'route' => 'projects',
                                'message' => "Confermi l'eliminazione del progetto : <strong>$project->name</strong>",
                                'entity' => $project,
                            ])

                        </div>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center ">
        <div class="">
            <h6>
                Showing {{ $projects->firstItem() }} - {{ $projects->lastItem() }} / {{ $projects->total() }}
            </h6>
        </div>
        <div class="">
            {{ $projects->appends($_GET)->links() }}
        </div>
    </div>
@endsection
