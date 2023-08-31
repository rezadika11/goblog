@extends('layouts.main')
@section('title', 'Create Posts')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3> @yield('title')</h3>
                </div>

                <div class="col-auto ms-auto text-end mt-n1">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @include('sweetalert::alert')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">@yield('title')</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('posts.update', $post->slug) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 row">
                                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="title"
                                            class="form-control @error('title')
                                            is-invalid
                                        @enderror"
                                            value="{{ old('title', $post->title) }}">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="mb-3 row">
                                    <label for="image" class="col-sm-2 col-form-label">Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="image"
                                            class="form-control @error('image')
                                            is-invalid
                                        @enderror"
                                            value="{{ old('image') }}">
                                        @error('image')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="image" class="col-sm-2 col-form-label">Content</label>
                                    <div class="col-sm-10">
                                        <textarea name="body" id="body"
                                            class="form-control @error('body')
                                            is-invalid
                                        @enderror">{{ old('body', $post->body) }}</textarea>
                                        @error('body')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="mb-3 row">
                                    <label for="excerpt" class="col-sm-2 col-form-label">Excerpt</label>
                                    <div class="col-sm-10">
                                        <textarea name="excerpt" rows="4"
                                            class="form-control @error('excerpt')
                                            is-invalid
                                        @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                                        @error('excerpt')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="meta_description" class="col-sm-2 col-form-label">Meta Description</label>
                                    <div class="col-sm-10">
                                        <textarea name="meta_description" rows="4" class="form-control">{{ old('meta_description', $post->meta_description) }}</textarea>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="category" class="col-sm-2 col-form-label">Category</label>
                                    <div class="col-sm-10">
                                        <select
                                            class="select2-multiple form-control @error('category')
                                            is-invalid
                                        @enderror"
                                            name="category[]" multiple="multiple">
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ old('category', $cat->id, $categories) ? 'selected' : '' }}>
                                                    {{ $cat->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="tag" class="col-sm-2 col-form-label">tag</label>
                                    <div class="col-sm-10">
                                        <select
                                            class="select2-multiple form-control @error('tag')
                                            is-invalid
                                        @enderror"
                                            name="tag[]" multiple="multiple">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}"
                                                    {{ old('tag', $tag->id, $tagMulti) ? 'selected' : '' }}>
                                                    {{ $tag->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tag')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="validationFormCheck2"
                                                name="status" value="publish"
                                                {{ $post->status == 'publish' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="validationFormCheck2">Publish</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input type="radio" class="form-check-input" id="validationFormCheck3"
                                                name="status" value="private"
                                                {{ $post->status == 'private' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="validationFormCheck3">Private</label>
                                        </div>
                                        @error('status')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-10 ms-sm-auto">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="{{ route('category.index') }}" class="btn btn-secondary">Back</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#body').summernote({
                height: 500,
            });
            $('.select2-multiple').select2({
                theme: "bootstrap-5",
            });
        });
    </script>
@endpush
