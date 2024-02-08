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
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ route('category.create') }}" class="btn btn-primary"><i
                                    class="fa-solid fa-square-plus"></i> Add
                                New</a>
                        </div>
                        <div class="card-body">
                            <table id="datatables" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('backend.modal.hapus')
        </div>
    </main>
@endsection
@push('js')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script>
        let table;

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $(function() {
            table = $('#datatables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('category.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'slug'
                    },
                    {
                        data: 'action',
                        searchable: false,
                        sortable: false
                    },
                ]
            });
        });

        function modalHapus(url) {
            $('#modal-form').modal('show');
            $('.modal-title').text('Delete Category ?')
            $('#confirmHapusData').on('click', function() {
                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    type: 'DELETE',
                    success: function(data) {
                        // Close the modal
                        $('#modal-form').modal('hide');
                        // Optionally, update the table to reflect the deleted data
                        table.ajax.reload(); // Reload the table
                        toastr.success('Successfully deleted category', 'Success');
                    },
                });
            });
        }
    </script>
@endpush
