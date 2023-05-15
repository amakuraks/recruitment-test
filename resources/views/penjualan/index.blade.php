@extends('layouts.app', [
    'title'     => 'Penjualan',
    'header'    => 'Penjualan',
    'breads'     => [               // breadcrumbs
        [
            'name'  => 'Home',
            'url'   => route('home'),
        ],
        [
            'name'  => 'Penjualan',
            'url'   => 'active',
        ],
    ],
])

@section('pagetitle', 'Penjualan')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Nota</h3>

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
                            <th>ID Nota</th>
                            <th>Tanggal Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Subtotal</th>
                            <th>Created At</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="1sttablebody">
                        @foreach ($penjualans as $penjualan)
                            <tr>
                                <td>{{ $penjualan->id_nota }}</td>
                                <td>{{ $penjualan->tanggal_transaksi }}</td>
                                <td>{{ $penjualan->pelanggan->nama }}</td>
                                <td>{{ $penjualan->subtotal }}</td>
                                <td>{{ $penjualan->created_at }}</td>
                                <td>{{ $penjualan->updated_at }}</td>
                                <td>
                                    <a href="{{ route('penjualan.edit', $penjualan->id_nota) }}" ><button type="button" class="btn btn-warning edit"><i class="fas fa-edit"></i></button></a>
                                    <a href="javascript:;"><button type="button" data-action="{{ route('penjualan.destroy', $penjualan->id_nota) }}"  class="btn btn-danger destroy"><i class="fas fa-trash"></i></button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <form style="display: hidden" id="formdestroy" method="POST">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    <a href="{{ route('penjualan.create') }}">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-new" id="create">Input Nota</button>
                    </a>
                </div>
            </div>
            {{-- <div id="1sttableoverlay" class="overlay dark">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div> --}}

            {{-- <div class="modal fade modal-autoclear" id="modal-new">
                <div class="modal-lg modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Input Nota</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
    
                        <div class="modal-body">
                            <form id="1stform" method="POST" action="{{ route('penjualan.store') }}">
                                <div>
                                    @csrf
                                    <div class="form-group row">
                                        <label for="id_nota" class="col-sm-4 col-form-label">ID Nota</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="id_nota" value="" placeholder="" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tanggal_transaksi" class="col-sm-4 col-form-label">Tanggal Transaksi</label>
                                        <div class="col-sm-6">
                                            <input type="datetime-local" class="form-control" name="tanggal_transaksi" value="" placeholder="" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="pelanggan" class="col-sm-4 col-form-label">Pelanggan</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="pelanggan" required>
                                                @if($pelanggans->count() > 0)
                                                    @foreach ($pelanggans as $pelanggan)
                                                        <option value="{{ $pelanggan->id_pelanggan }}" >({{ $pelanggan->id_pelanggan }}) {{ $pelanggan->nama }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled selected >Tidak ada pelanggan</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <table id="complex-table-new" class="table table-bordered table-hover dt-responsive">
                                        <thead>
                                            <th>Nama barang</th>
                                            <th>Harga satuan</th>
                                            <th width="5%">Qty</th>
                                            <th>Subtotal</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                            <h4 class="modal-title">Edit Nota</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
    
                        <div class="modal-body">
                            <form id="2ndform" action="">
                                <div>
                                    @csrf
                                    <div class="form-group row">
                                        <label for="id_nota" class="col-sm-4 col-form-label">ID Nota</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="id_nota" value="" placeholder="" required disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="pelanggan" class="col-sm-4 col-form-label">Pelanggan</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" name="pelanggan" required>
                                                @if($pelanggans->count() > 0)
                                                    @foreach ($pelanggans as $pelanggan)
                                                        <option value="{{ $pelanggan->id_pelanggan }}" >({{ $pelanggan->id_pelanggan }}) {{ $pelanggan->nama }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled selected >Tidak ada pelanggan</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="barang" class="col-sm-4 col-form-label">Barang</label>
                                        <div class="col-sm-6">
                                            <div class="barang-container">
                                                <div class="barang-item">
                                                    <select class="form-control" name="barang[][kode_barang]" required>
                                                        @if($barangs->count() > 0)
                                                            @foreach ($barangs as $barang)
                                                                <option value="{{ $barang->kode }}" >({{ $barang->kode }}) {{ $barang->nama }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="" disabled selected >Tidak ada barang</option>
                                                        @endif
                                                    </select>
                                                    <input type="number" class="form-control" name="barang[][quantity]" placeholder="Quantity" required>
                                                </div>
                                            </div>
                                            <button type="button" id="add-barang">Add Barang</button>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="tanggal_transaksi" class="col-sm-4 col-form-label">Tanggal Transaksi</label>
                                        <div class="col-sm-6">
                                            <input type="datetime-local" class="form-control" name="tanggal_transaksi" value="" placeholder="" required>
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
            </div> --}}
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
        // $( document ).ready(function(){

        //     // $('#formdestroy').submit(function(e){
        //     //     e.preventDefault();
        //     //     crudAjax(
        //     //         "formdestroy",
        //     //         $(this).attr('action'),
        //     //         "DELETE",
        //     //         null,
        //     //         false,
        //     //         function(){
        //     //             toastr.success("Data Nota dihapus!");
        //     //             reload1stTable();
        //     //         }
        //     //     );
        //     // });

        //     // reload1stTable();

        //     // $(document).on('click', 'button.edit',function(e){
        //     //     e.preventDefault();
        //     //     $.ajax({
        //     //         type    : 'GET',
        //     //         url     : $(this).data('action'),
        //     //         success : function(data){
        //     //             // Change action route in form
        //     //             var custroute = '{{route('penjualan.update',':id')}}';
        //     //             custroute = custroute.replace(':id', data.data['id']);
        //     //             $('#2ndform').attr('action', custroute);

        //     //             // Fill form with existing data
        //     //             $('#2ndform').attr('action', $(this).data('action'));
        //     //             $.each(data.data, function(key, value){
        //     //                 $('#modal-edit').find('[name='+key+']').val(value);
        //     //             });

        //     //             // Show modal
        //     //             $('#modal-edit').modal('show')
        //     //         },
        //     //         error : function(){
        //     //             alert('Failed fetching selected record. Please refer to the log or contact support.');
        //     //         }
        //     //     });
        //     // });

            $(document).on('click', 'button.destroy',function(e){
                e.preventDefault()
                if(confirm("Nota akan dihapus. Lanjutkan?")){
                    var action = $(this).data("action");
                    $('#formdestroy').attr("action", action);
                    $('#formdestroy').submit();
                }
            });
        // });

        // function reload1stTable(){
        //     reloadTable(
        //         '1sttable',
        //         '{{ route('penjualan.table.index') }}',
        //         '{{ route('penjualan.edit', ':id') }}',
        //         '{{ route('penjualan.destroy', ':id') }}',
        //     );
        // }
    </script>
@endpush
