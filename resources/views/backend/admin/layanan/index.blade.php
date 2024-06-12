@extends('layouts.partials.join')

@push('css')
<link rel="stylesheet" href="{{ asset('asset/plugins/dataTables/datatables.css') }}">
@endpush

@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Layanan</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <a class="btn btn-sm btn-primary" href="{{ route('layanan.create') }}">
                                        Tambah Data</a>
                                </div>
                                <div class="card-body">
                                    <table class='table table-striped' id="table1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>URL</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('asset/plugins/dataTables/datatables.js') }}" defer></script>
    <script>
         $(document).ready(function() {
            $('#table1').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('datatables/admin/layanan') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama', name: 'nama' },
                    { data: 'url', name: 'url' },
                    { data: 'url', name: 'url', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
