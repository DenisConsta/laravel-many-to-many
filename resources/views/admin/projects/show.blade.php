@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-8">
                <h1 class="display-3"> {{ $project->name }}f </h1>
                @if ($project->type?->name)
                    <span class="mb-3 badge text-bg-info">{{ $project->type?->name }}</span>
                @endif
                <h4> {{ $project->client_name }} </h4>
                <p> {!! $project->summary !!} </p>
            </div>

            <div class="col-4">
                <img src="{{ str_starts_with($project->cover_image, 'http')
                    ? $project->cover_image
                    : asset('storage/' . $project->cover_image) }}"
                    class="card-img-top" alt="{{ $project->name }}">
            </div>
        </div>
    </div>
@endsection
