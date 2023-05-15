@extends('layouts.app', [
    'title'     => 'Penjualan Baru',
    'header'    => 'Penjualan Baru',
    'breads'     => [               // breadcrumbs
        [
            'name'  => 'Home',
            'url'   => route('home'),
        ],
        [
            'name'  => 'Penjualan Baru',
            'url'   => 'active',
        ],
    ],
])

@section('pagetitle', 'Penjualan Baru')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Input Nota</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">
                <form id="1stform" method="POST" action="{{ route('penjualan.store') }}">
                    <div>
                        @if($errors->any())
                            {{ implode('', $errors->all('<div>:message</div>')) }}
                        @endif
                        @csrf
                        <div class="form-group row">
                            <label for="id_nota" class="col-sm-4 col-form-label">ID Nota</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="id_nota" value="{{old('id_nota')}}" placeholder="" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tanggal_transaksi" class="col-sm-4 col-form-label">Tanggal Transaksi</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" name="tanggal_transaksi" value="{{old('tanggal_transaksi')}}" placeholder="" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="pelanggan" class="col-sm-4 col-form-label">Pelanggan</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="kode_pelanggan" required>
                                    @if($pelanggans->count() > 0)
                                        @foreach ($pelanggans as $pelanggan)
                                            @if($pelanggan->id_pelanggan == old('id_pelanggan'))
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
                        
                        <table  class="table table-bordered table-hover dt-responsive">
                            <thead>
                                <th>Nama barang</th>
                                <th>Harga satuan</th>
                                <th width="5%">Qty</th>
                                <th>Subtotal</th>
                                <th width="1%"></th>
                            </thead>
                            <tbody id="complex-table">
                                <tr id="template">
                                    <td>
                                        <select class="form-control flexinput" name="barang[0][kode_barang]" required>
                                            @foreach ($barangs as $barang)
                                                <option data-harga="{{ $barang->harga }}" value="{{ $barang->kode }}" >({{ $barang->kode }}) {{ $barang->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td name="barang[0][harga]"></td>
                                    <td>
                                        <input type="number" class="flexinput" name="barang[0][quantity]" value="1" required>
                                    </td>
                                    <td name="barang[0][subtotal]"></td>
                                    <td></td>
                                </tr>
                                <tr id="summary">
                                    <td colspan="3"></td>
                                    <td id="subtotal"></td>
                                    <td><button id="add"><i class="fa fa-plus"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" form="1stform" class="btn btn-primary" data-toggle="modal" data-target="#modal-new" id="create">Input Nota</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
<script src="/js/amakura.js"></script>
<script>
    $( document ).ready(function() {
        $('#1stform').submit(function(e){
                e.preventDefault();
                crudAjax('1stform', '{{ route('penjualan.store') }}', 'POST', null, false, function(){
                    window.location.href = "{{ route('penjualan.index')}}";
                });
                
            });

        var barangIndex = 1;
        $("#add").click(function(e){
            e.preventDefault();
            var options = "";
            @foreach ($barangs as $index => $barang)
                @if($index > 0)
                    options += '<option data-harga="{{ $barang->harga }}"  value="{{ $barang->kode }}" >({{ $barang->kode }}) {{ $barang->nama }}</option>';
                @else
                    options += '<option selected data-harga="{{ $barang->harga }}"  value="{{ $barang->kode }}" >({{ $barang->kode }}) {{ $barang->nama }}</option>';
                @endif
            @endforeach
            
            var newRow = $('<tr data-status="clone" data-index="'+barangIndex+'" ><td><select class="form-control flexinput" name="barang['+barangIndex+'][kode_barang]" required>'+options+'</select></td><td name="barang['+barangIndex+'][harga]"></td><td><input class="flexinput" type="number" name="barang['+barangIndex+'][quantity]" value="1" required></td><td name="barang['+barangIndex+'][subtotal]"></td><td><button class="decrease" id="add"><i class=" fa fa-minus"></i></button></td></tr>');
            newRow.insertBefore($("#summary"));
            $('.decrease').on('click', function(e) {
                e.preventDefault();
                $(this).closest('tr').remove();
                // recalculate();
            })

            // $('.flexinput').on("change", function(e){
            //     recalculate();
            // });

            // $('input[type="number"]').on('input', function() {
            //     var minValue = 1;
            //     var currentValue = parseInt($(this).val(), 10);
                
            //     if (isNaN(currentValue) || currentValue < minValue) {
            //         $(this).val(minValue);
            //     }
            // });

            barangIndex++;
            // recalculate();
        });

        // $('.flexinput').change(function(e){
        //     recalculate();
        // });

        // $('input[type="number"]').on('input', function() {
        //     var minValue = 1;
        //     var currentValue = parseInt($(this).val(), 10);
            
        //     if (isNaN(currentValue) || currentValue < minValue) {
        //         $(this).val(minValue);
        //     }
        // });

        // $('.decrease').click(function(e) {
        //         e.preventDefault();
        //         $(this).closest('tr').remove();
        //         recalculate();
        // });
        // recalculate();
    });

    // function recalculate(){
    //     var trlength    = $('#complex-table tr').length;
    //     var finalsubtotal = 0;
    //     for (let index = 0; index < trlength-1; index++) {
    //         var harga   = $('select[name="barang['+index+'][kode_barang]"]').find(":selected").data('harga');
    //         var tdharga = $('td[name="barang['+index+'][harga]"]').html(harga);

    //         var quantity = $('input[name="barang['+index+'][quantity]"]').val();
    //         var tdsubtotal = $('td[name="barang['+index+'][subtotal]"]').html(harga*quantity);

    //         finalsubtotal += (harga*quantity);
    //     }

    //     $("#subtotal").html(finalsubtotal);
    // }
</script>
@endpush