@extends('layouts.main')
@section('title', 'Posts')
@push('css')
    <style>
        table.dataTable tbody td {
            vertical-align: top;
        }
    </style>
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
                            <a href="{{ route('posts.create') }}" class="btn btn-primary"><i
                                    class="fa-solid fa-square-plus"></i> Add
                                Posts</a>
                        </div>
                        <div class="card-body">
                            <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="50">No</th>
                                        <th width="300">Title</th>
                                        <th width="700">Excerpt</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->excerpt }}</td>
                                            <td>{{ $post->user->name }}</td>
                                            <td>
                                                @if ($post->status == 'publish')
                                                    <span class="badge bg-success">{{ $post->status }}</span>
                                                @else
                                                    <span class="badge bg-warning">{{ $post->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('posts.edit', $post->slug) }}" class="btn btn-success"><i
                                                        class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#modalCategory{{ $post->id }}"
                                                    class="btn btn-danger"><i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </td>
                                            {{-- @include('backend.modal.delete-category') --}}
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
@push('js')
    <script src="{{ asset('js/datatables.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            $("#datatables-reponsive").DataTable({
                responsive: true
            });
        });
    </script>
@endpush
