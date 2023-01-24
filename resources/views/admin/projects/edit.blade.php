@extends('layouts.app')

@section('content')
    <div class="bg-dark py-5">
        <div class="container text-light">

            <form action=" {{ route('admin.projects.update', $project) }} " method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ? name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">name</label>
                    <input type="text" name="name"
                        class="form-control bg-dark text-light @error('name')
                    is-invalid  @enderror"
                        id="name" placeholder="inserire il nome del progetto"
                        value=" {{ old('name', $project->name) }} ">
                    <div class="invalid-feedback">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- ? cover_image --}}
                <div class="mb-3">
                    <label for="cover_image" class="form-label">Image</label>
                    <input type="file" name="cover_image" onchange="showImage(event)"
                        class="form-control bg-dark text-light @error('cover_image')
                    is-invalid  @enderror"
                        id="cover_image" placeholder="inserire l'url dell'immagine"
                        value=" {{ old('cover_image', $project->cover_image) }} ">
                    <div class="invalid-feedback">
                        @error('cover_image')
                            {{ $message }}
                        @enderror
                    </div>
                    <div>
                        {{-- <img width="300" id="preview_image" src=" {{ asset('storage/' . $project['cover_image']) }} "
                            alt=""> --}}

                        <img width="300" class="my-3" id="preview_image"
                            src="{{ str_starts_with($project->cover_image, 'https:')
                                ? $project->cover_image
                                : asset('storage/' . $project->cover_image) }}"
                            alt="{{ $project->name }}">
                    </div>
                </div>

                {{-- ? client_name --}}
                <div class="mb-3">
                    <label for="client_name" class="form-label">client_name</label>
                    <input type="text" name="client_name"
                        class="form-control bg-dark text-light @error('client_name')
                    is-invalid  @enderror"
                        id="client_name" placeholder="inserire il client_name "
                        value=" {{ old('client_name', $project->client_name) }} ">
                    <div class="invalid-feedback">
                        @error('client_name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                {{-- ? types --}}
                <div class="mb-3">
                    <label for="types" class="form-label">Type</label>
                    <select name="type_id" class="form-select bg-dark text-light" aria-label="Default select example">
                        <option value="">Selezionare una tipologia</option>
                        @foreach ($types as $type)
                            <option @if ($type?->id == $project->type?->id) selected @endif value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ? summary --}}
                <div class="mb-3 text-dark">
                    <label for="summary" class="form-label">summary</label>

                    <textarea name="summary" id="text" rows="10"
                        class=" @error('summary')
                    is-invalid  @enderror">{{ old('summary', $project->summary) }}</textarea>

                    {{-- <input type="text" name="summary"
                        class="form-control bg-dark text-light @error('summary')
                    is-invalid  @enderror"
                        id="summary" placeholder="inserire il summary " value=" {{ old('summary', $project->summary) }} "> --}}

                    <div class="invalid-feedback">
                        @error('summary')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Update</button>

            </form>

        </div>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#text'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            })
            .catch(error => {
                console.error(error);
            });

        function showImage(event) {
            const tagImage = document.getElementById('preview_image');
            tagImage.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
