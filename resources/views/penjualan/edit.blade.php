@extends('layouts.app', [
    'title'     => 'Edit Nota',
    'header'    => 'Edit Nota',
    'breads'     => [               // breadcrumbs
        [
            'name'  => 'Home',
            'url'   => route('home'),
        ],
        [
            'name'  => 'Edit Nota',
            'url'   => 'active',
        ],
    ],
])

@section('pagetitle', 'Edit Nota')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Nota</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                @if($errors->any())
                    {{ implode('', $errors->all('<div>:message</div>')) }}
                @endif
                <form id="1stform">
                    <div>
                        @csrf
                        @method("PUT")
                        <div class="form-group row">
                            <label for="id_nota" class="col-sm-4 col-form-label">ID Nota</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="id_nota" value="{{ old('id_nota') ?? $penjualan->id_nota  }}" placeholder="" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanggal_transaksi" class="col-sm-4 col-form-label">Tanggal Transaksi</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" name="tanggal_transaksi" value="{{ old('tanggal_transaksi') ?? $penjualan->tanggal_transaksi  }}" placeholder="" required autofocus>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="pelanggan" class="col-sm-4 col-form-label">Pelanggan</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="kode_pelanggan" required>
                                    @if($pelanggans->count() > 0)
                                        @foreach ($pelanggans as $pelanggan)
                                            @if($pelanggan->id_pelanggan == $penjualan->kode_pelanggan || $pelanggan->id_pelanggan == old('kode_pelanggan'))
                                                <option selected value="{{ $pelanggan->id_pelanggan }}" >({{ $pelanggan->id_pelanggan }}) {{ $pelanggan->nama }}</option>
                                            @else
                                                <option value="{{ $pelanggan->id_pelanggan }}" >({{ $pelanggan->id_pelanggan }}) {{ $pelanggan->nama }}</option>
                                            @endif
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
                                @foreach ($penjualan->barang as $index => $item)
                                    <tr>
                                        <td>
                                            <select class="form-control" name="barang[{{$index}}][kode_barang]" required>
                                                @foreach ($barangs as $barang)
                                                    @if ($barang->kode == $item->kode)
                                                        <option selected data-harga="{{ $barang->harga }}" value="{{ $barang->kode }}" >({{ $barang->kode }}) {{ $barang->nama }}</option>
                                                    @else
                                                        <option data-harga="{{ $barang->harga }}" value="{{ $barang->kode }}" >({{ $barang->kode }}) {{ $barang->nama }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{$item->harga}}</td>
                                        <td><input type="number" name="barang[{{$index}}][quantity]" value="{{$item->pivot->quantity}}" required></td>
                                        <td>{{($item->harga * $item->pivot->quantity)}}</td>
                                        <td> @if ($index > 0)  <button class="decrease"><i class=" fa fa-minus"></i></button></td> @endif</td>
                                    </tr>
                                @endforeach
                                <tr id="summary">
                                    <td colspan="3"></td>
                                    <td id="subtotal">{{$penjualan->subtotal}}</td>
                                    <td><button id="add"><i class="fa fa-plus"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" form="1stform"  class="btn btn-primary" id="create">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('stylesheet')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="/js/amakura.js"></script>
<script>
    $( document ).ready(function() {

        $('#1stform').submit(function(e){
            e.preventDefault();
            var custroute = '{{ route('penjualan.update',':id') }}';
            custroute2 = custroute.replace(':id', '{{ $penjualan->id_nota }}');

            console.log(custroute2);

            crudAjax('1stform', custroute2, 'PUT', null, false, function(){
                toastr.success("CRUD done!");

                window.location.href = "{{ route('penjualan.index')}}";
            });
            
        });

        refreshDecreaseButton();
        var barangIndex = {{ $index+1 }};
        $("#add").click(function(e){
            e.preventDefault();
            var options = "";
            @foreach ($barangs as $barang)
                options += '<option value="{{ $barang->kode }}" >({{ $barang->kode }}) {{ $barang->nama }}</option>';
            @endforeach
            
            var newRow = $('<tr data-status="clone" data-index="'+barangIndex+'" ><td><select class="form-control" name="barang['+barangIndex+'][kode_barang]" required>'+options+'</select></td><td></td><td><input type="number" name="barang['+barangIndex+'][quantity]" required></td><td></td><td><button class="decrease" id="add"><i class=" fa fa-minus"></i></button></td></tr>');
            newRow.insertBefore($("#summary"));
            refreshDecreaseButton();

            barangIndex++;
            recalculate()
        });


    });

    function refreshDecreaseButton(){
        $('.decrease').on('click', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();

            });
    }

    function recalculate(){
        var trlength    = $('#complex-table tr').length;

        for (let index = 0; index < trlength-1; index++) {
            var trElement = $('#complex-table tr').eq(index);
            console.log(index);
        }
    }
</script>
@endpush