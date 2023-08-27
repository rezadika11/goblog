@extends('layouts.main')
@section('title', 'Tags')
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
                            <a href="{{ route('tags.create') }}" class="btn btn-primary"><i
                                    class="fa-solid fa-square-plus"></i> Add
                                Tags</a>
                        </div>
                        <div class="card-body">
                            <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $tag)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tag->title }}</td>
                                            <td>
                                                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-success"><i
                                                        class="fa-solid fa-pen-to-square"></i>
                                                    Edit</a>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#modalTags{{ $tag->id }}" class="btn btn-danger"><i
                                                        class="fa-solid fa-trash-can"></i>
                                                    Delete</button>
                                            </td>
                                            @include('backend.modal.delete-tags')
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
