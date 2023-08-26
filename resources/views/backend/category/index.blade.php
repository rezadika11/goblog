@extends('layouts.main')
@section('title', 'Category')
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
                            <a href="{{ route('category.create') }}" class="btn btn-primary"><i
                                    class="fa-solid fa-square-plus"></i> Add
                                Category</a>
                        </div>
                        <div class="card-body">
                            <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->title }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>
                                                <a href="{{ route('category.edit', $category->id) }}"
                                                    class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i>
                                                    Edit</a>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#modalCategory{{ $category->id }}"
                                                    class="btn btn-danger"><i class="fa-solid fa-trash-can"></i>
                                                    Delete</button>
                                            </td>
                                            @include('backend.modal.delete-category')
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
