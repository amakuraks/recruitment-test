@extends('layouts.app', [
    'title'     => 'Manajemen Barang',
    'header'    => 'Manajemen Barang',
    'breads'     => [               // breadcrumbs
        [
            'name'  => 'Home',
            'url'   => route('home'),
        ],
        [
            'name'  => 'Manajemen Barang',
            'url'   => 'active',
        ],
    ],
])

@section('pagetitle', 'Manajemen Barang')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Barang</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button> --}}
                </div>
            </div>

            <div class="card-body">
                <table id="1sttable" class="table table-bordered table-hover dt-responsive">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Name</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Created At</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="1sttablebody">
                    </tbody>
                </table>
                <form style="display: hidden" id="formdestroy" method="POST">
                    @csrf
                </form>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-new" id="create">Input Barang</button>
                </div>
            </div>
            <div id="1sttableoverlay" class="overlay dark">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>

            <div class="modal fade modal-autoclear" id="modal-new">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Input Barang</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
    
                        <div class="modal-body">
                            <form id="1stform" action="">
                                <div>
                                    @csrf
                                    <div class="form-group row">
                                        <label for="kode" class="col-sm-4 col-form-label">Kode Barang</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="kode" value="" placeholder="" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="nama" value="" placeholder="" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="kategori" class="col-sm-4 col-form-label">Kategori</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="kategori" value="" placeholder="" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="harga" class="col-sm-4 col-form-label">Harga</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="harga" value="" placeholder="" required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
    
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="1stform">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="modal fade modal-autoclear" id="modal-edit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Barang</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
    
                        <div class="modal-body">
                            <form id="2ndform" action="">
                                <div>
                                    @csrf
                                    <div class="form-group row">
                                        <label for="kode" class="col-sm-4 col-form-label">Kode Barang</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="kode" value="" placeholder="" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="nama" value="" placeholder="" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="kategori" class="col-sm-4 col-form-label">Kategori</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="kategori" value="" placeholder="" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="harga" class="col-sm-4 col-form-label">Harga</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="harga" value="" placeholder="" required>
                                        </div>
                                    </div>
    
                                </div>
                            </form>
                        </div>
    
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="2ndform">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('stylesheet')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="/js/amakura.js"></script>
    <script>
        $( document ).ready(function(){
            $("#1stform").submit(function(e){
                e.preventDefault();
                crudAjax(
                    "1stform",
                    "{{ route('barang.store') }}",
                    "POST",
                    "modal-new",
                    true,
                    function(){
                        $('#modal-new').modal('hide');
                        toastr.success("Barang telah dibuat!");
                        $("#1stform")[0].reset();
                        reload1stTable();
                    }
                );
            });

            $('#2ndform').submit(function(e){
                e.preventDefault();
                crudAjax(
                    "2ndform",
                    $(this).attr('action'),
                    "PUT",
                    "modal-edit",
                    true,
                    function(){
                        $('#modal-edit').modal('hide');
                        toastr.success("Perubahan telah disimpan!");
                        reload1stTable();
                    }
                );
            });

            $('#formdestroy').submit(function(e){
                e.preventDefault();
                crudAjax(
                    "formdestroy",
                    $(this).attr('action'),
                    "DELETE",
                    null,
                    false,
                    function(){
                        toastr.success("Barang dihapus!");
                        reload1stTable();
                    }
                );
            });

            reload1stTable();

            $(document).on('click', 'button.edit',function(e){
                e.preventDefault();
                $.ajax({
                    type    : 'GET',
                    url     : $(this).data('action'),
                    success : function(data){
                        // Change action route in form
                        var custroute = '{{route('barang.update',':id')}}';
                        custroute = custroute.replace(':id', data.data['id']);
                        $('#2ndform').attr('action', custroute);

                        // Fill form with existing data
                        $('#2ndform').attr('action', $(this).data('action'));
                        $.each(data.data, function(key, value){
                            $('#modal-edit').find('[name='+key+']').val(value);
                        });

                        // Show modal
                        $('#modal-edit').modal('show')
                    },
                    error : function(){
                        alert('Failed fetching selected record. Please refer to the log or contact support.');
                    }
                });
            });

            $(document).on('click', 'button.destroy',function(e){
                e.preventDefault()
                if(confirm("Data barang akan dihapus. Lanjutkan?")){
                    var action = $(this).data("action");
                    $('#formdestroy').attr("action", action);
                    $('#formdestroy').submit();
                }
            });
        });

        function reload1stTable(){
            reloadTable(
                '1sttable',
                '{{ route('barang.table.index') }}',
                '{{ route('barang.edit', ':id') }}',
                '{{ route('barang.destroy', ':id') }}',
            );
        }
    </script>
@endpush
