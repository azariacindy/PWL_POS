@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('level/create') }}">Add New Level</a>
                <button onclick="modalAction('{{ url('level/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Add with Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <h5><i class="icon fas fa-check"></i>Successfully!</h5>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i>Error!</h5>
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- All -</option>
                                @foreach ($level as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">User Level</small>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Level Code</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" databackdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

        @push('css')
        @endpush

        @push('js')
            <script>
                function modalAction(url = ''){
                    $('#myModal').load(url,function(){
                    $('#myModal').modal('show');
                    });
                }

                var dataLevel;
                $(document).ready(function() {
                    var dataLevel = $('#table_level').DataTable({
                        serverSide: true, // jika ingin menggunakan server side processing
                        ajax: {
                            url: "{{ url('level/list') }}",
                            dataType: "json",
                            type: "POST",
                            data: function(d) {
                                d.level_id = $('#level_id').val();
                            }
                        },
                        columns: [{
                                data: "DT_RowIndex",
                                className: "text-center",
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: "level_kode",
                                className: "",
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: "level_nama",
                                className: "",
                                orderable: true,
                                searchable: true
                            },
                            {
                                data: "aksi",
                                className: "",
                                orderable: false,
                                searchable: false
                            }
                        ]
                    });

                    $('#level_id').change(function() {
                        dataLevel.ajax.reload();
                    });
                });
            </script>
        @endpush