@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {!! session('success') !!}
        </div>
    @endif

    <h1>Technologies</h1>

    <form action=" {{ route('admin.technologies.store') }} " method="POST">
        @csrf
        <div class="input-group mb-3 w-50">
            <input type="text" class="form-control" name="name" placeholder="New technology">
            <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i
                    class="fa-solid fa-circle-plus"></i></button>
        </div>
    </form>

    <table class="table table-dark w-50">
        <thead>
            <tr>
                <th scope="col">Technology</th>
                <th scope="col">Post Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($technologies as $tech)
                <tr>
                    <td class="d-flex gap-3">
                        <form action=" {{ route('admin.technologies.update', $tech) }} " method="POST">
                            @csrf

                            @method('PATCH')
                            <input class="border-0 bg-dark text-light" type="text" name="name"
                                value=" {{ $tech->name }} ">
                            <button type="submit" class="btn btn-warning text-light"><i
                                    class="fa-regular fa-pen-to-square"></i></button>
                        </form>

                        @include('admin.partials.form-delete', [
                            'route' => 'technologies',
                            'message' => "Confermi l'eliminazione della tecnologia : $tech->name",
                            'entity' => $tech,
                        ])

                    </td>
                    <td> {{ count($tech->projects) }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
