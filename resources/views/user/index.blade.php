@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('user/import') }}')" class="btn btn-info">Import User</button>
                <a href="{{ url('user/export_excel') }}" class="btn btn-primary">Export User</a>
                {{-- <a href="{{ url('user/export_pdf') }}" class="btn btn-warning"><i class="fa fa-filepdf"></i> Export User (PDF)</a> --}}
                <button onclick="modalAction('{{ url('user/create_ajax') }}')" class="btn btn-success">Tambah Data
                    (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            <!-- untuk Filter data -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row text-sm mb-0">
                            <label for="filter_date" class="col-md-1 col-formlabel">Filter</label>
                            <div class="col-md-3">
                                <select name="filter_level" class="form-control formcontrol-sm filter_level">
                                    <option value="">- Semua -</option>
                                    @foreach ($level as $l)
                                        <option value="{{ $l->level_id }}">{{ $l->level_nama }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Level Pengguna</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table-user">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>LevelPengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var tableUser;
        $(document).ready(function() {
            tableUser = $('#table-user').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('user/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.filter_level = $('.filter_level').val();
                    }
                },
                columns: [{ // nomor urut dari laravel datatable addIndexColumn()
                    data: "user_id",
                    className: "text-center",
                    width: "5%",
                    orderable: true,
                    searchable: false
                }, {
                    data: "username",
                    className: "",
                    width: "15%",
                    // orderable: true, jika ingin kolom ini bisa diurutkan
                    orderable: true,
                    // searchable: true, jika ingin kolom ini bisa dicari
                    searchable: true
                }, {
                    data: "nama",
                    className: "",
                    width: "20%",
                    orderable: true,
                    searchable: true
                }, {
                    // mengambil data level hasil dari ORM berelasi
                    data: "level.level_nama",
                    className: "",
                    width: "10%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "aksi",
                    className: "text-center",
                    width: "20%",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#table-user_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { // enter key
                    tableUser.search(this.value).draw();
                }
            })
            $('.filter_level').change(function() {
                tableUser.draw();
            })
        });
    </script>
@endpush