@extends('layouts.main')
@section('title', 'Edit Category')
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
                            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">@yield('title')</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('category.update', $data->id) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <div class="mb-3 row">
                                    <label class="col-form-label col-sm-2 text-sm-end">Title</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="title"
                                            class="form-control @error('title')
                                            is-invalid
                                        @enderror"
                                            placeholder="Title" id="title" value="{{ old('title', $data->title) }}">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label class="col-form-label col-sm-2 text-sm-end">Slug</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="slug"
                                            class="form-control @error('slug')
                                            is-invalid
                                        @enderror"
                                            placeholder="Slug" id="slug" value="{{ old('slug', $data->slug) }}"
                                            readonly>
                                    </div>
                                    @error('slug')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-sm-10 ms-sm-auto">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                            Save</button>
                                        <a href="{{ route('category.index') }}" class="btn btn-secondary">Back <i
                                                class="fas fa-arrow-right"></i></a>
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
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#title")
                .keyup(function() {
                    let slug = $(this).val();
                    slug = slug.replace(/\s+/g, '-').toLowerCase()
                    $('#slug').val(slug)
                })
        });
    </script>
@endpush
