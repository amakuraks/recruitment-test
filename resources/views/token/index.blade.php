@extends('layouts.app', [
    'title'     => 'App Token',
    'header'    => 'App Token',
    'breads'     => [               // breadcrumbs
        [
            'name'  => 'Home',
            'url'   => route('home'),
        ],
        [
            'name'  => 'App Token',
            'url'   => 'active',
        ],
    ],
])

@section('pagetitle', 'App Token')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tokens</h3>
            </div>

            <div class="card-body">
                <table id="1sttable" class="table table-bordered table-hover dt-responsive text-sm">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Created</th>
                            <th>Last Accessed</th>
                            <th width="10%">Action</th>
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
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-new" id="create">Create new token</button>
                </div>
            </div>
            <div id="1sttableoverlay" class="overlay dark">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>


            <div class="modal fade modal-autoclear" id="modal-new">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Input new token</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="1stform" method="POST"  action="{{ route('token.store') }}">
                                <div>
                                    @csrf
                                    <div class="form-group row">
                                        <label for="label" class="col-sm-3 col-form-label">Label</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="label" placeholder="" value="" required autofocus>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="1stform">Create</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection

@push('stylesheet')
    <link rel="stylesheet" href="{{ config('sweetalert.animatecss') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            color:black;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="/js/amakura.js"></script>
    <script>
        $( document ).ready(function(){
            $('.select2').select2();

            $("#1stform").submit(function(e){
                e.preventDefault();
                crudAjax(
                    "1stform",
                    "{{ route('token.store') }}",
                    "POST",
                    "modal-new",
                    true,
                    function(data){
                        console.log(data);
                        $('#modal-new').modal('hide');
                        toastr.success("New token created!");
                        $("#1stform")[0].reset();
                        reload1stTable();

                        Swal.fire({
                            title: 'Please copy the token below because it will be only shown once!',
                            text: data.token,
                            confirmButtonText: 'Close',
                            }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.close();
                            }
                        });
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
                        toastr.success("Changes were successfully saved!");
                        reload1stTable();
                    }
                );
            });


            $('#formdestroy').submit(function(e){
                e.preventDefault();
                console.log($(this).attr('action'));
                crudAjax(
                    "formdestroy",
                    $(this).attr('action'),
                    "DELETE",
                    null,
                    false,
                    function(){
                        toastr.success("Token deleted!");
                        reload1stTable();
                    }
                );
            });

            reload1stTable();

            $(document).on('click', 'button.destroy',function(e){
                e.preventDefault()
                if(confirm("This action will delete the token. Proceed?")){
                    var action = $(this).data("action");
                    $('#formdestroy').attr("action", action);
                    $('#formdestroy').submit();
                }
            });
        });

        function reload1stTable(){
            reloadTable(
                '1sttable',
                '{{ route('token.table.index') }}',
                '',
                '{{ route('token.destroy', ':id') }}',
            );
        }
    </script>
@endpush
