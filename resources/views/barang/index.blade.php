@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-warning">Import Item Data</button>
                <a href="{{ url('/barang/export/excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>Export Item Data</a>
                <a href="{{ url('/barang/export/pdf') }}" class="btn btn-secondary"><i class="fa fa-file-pdf"></i> Export Item Data</a>
                <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-success">Add with Ajax</button>
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
                 <div class="col-md-12">
                     <div class="form-group row">
                         <label for="kategori_id" class="col-1 control-label col-form-label">Filter:</label>
                         <div class="col-3">
                             <select name="kategori_id" id="kategori_id" class="form-control" required>
                                 <option value="">- All -</option>
                                 @foreach ($kategori as $item)
                                     <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                 @endforeach
                             </select>
                             <small class="form-text text-muted">Item Category</small>
                         </div>
                     </div>
                 </div>
             </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Code</th>
                        <th>Category Name</th>
                        <th>Item Name</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

    @push('css')
    @endpush

    @push('js')
        <script>
            function modalAction(url = '') {
                $('#myModal').load(url, function () {
                    $('#myModal').modal('show');
                });
            }
            var dataBarang;
            $(document).ready(function () {
                dataBarang = $('#table_barang').DataTable({
                    serverSide: true,
                    ajax: {
                        "url": "{{ url('barang/list') }}",
                        "dataType": "json",
                        "type": "POST",
                        "data": function (d) {
                            d.kategori_id = $('#kategori_id').val();
                        }
                    },
                    columns: [
                        { 
                            data: "DT_RowIndex",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        }, {
                            data: "barang_kode",
                            className: "",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "kategori.kategori_nama",
                            className: "",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "barang_nama",
                            className: "",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "harga_beli",
                            className: "",
                            orderable: true,
                            searchable: false
                        }, {
                            data: "harga_jual",
                            className: "",
                            orderable: true,
                            searchable: false
                        }, {
                            data: "aksi",
                            className: "",
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
                $('#kategori_id').on('change', function () {
                    dataBarang.ajax.reload();
                });
            }); 
        </script>
    @endpush