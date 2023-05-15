@extends('layouts.app', [
    'title'     => 'User Management',
    'header'    => 'User Management',
    'breads'     => [               // breadcrumbs
        [
            'name'  => 'Home',
            'url'   => route('home'),
        ],
        [
            'name'  => 'User Management',
            'url'   => 'active',
        ],
    ],
])

@section('pagetitle', 'User Management')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User List</h3>

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
                            <th>Name</th>
                            <th>Email</th>
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
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-new" id="create">Create new user</button>
                </div>
            </div>
            <div id="1sttableoverlay" class="overlay dark">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>

            <div class="modal fade modal-autoclear" id="modal-new">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create new user</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
    
                        <div class="modal-body">
                            <form id="1stform" action="">
                                <div>
                                    @csrf
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label">Full Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="name" value="" placeholder="" required autofocus>
                                        </div>
                                    </div>
        
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-4 col-form-label">Email address</label>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" name="email" value="" placeholder="" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-sm-4 col-form-label">Password</label>
                                        <div class="col-sm-5">
                                            <input type="password" class="form-control" name="password" placeholder="" required>
                                        </div>
                                    </div>
        
                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-sm-4 col-form-label">Confirm Password</label>
                                        <div class="col-sm-5">
                                            <input type="password" class="form-control" name="password_confirmation" placeholder="" required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
    
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="1stform">Submit User</button>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="modal fade modal-autoclear" id="modal-edit">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit User detail</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
    
                        <div class="modal-body">
                            <form id="2ndform" action="">
                                <div>
                                    @csrf
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-4 col-form-label">Full Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="name" value="" placeholder="" required autofocus>
                                        </div>
                                    </div>
        
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-4 col-form-label">Email address</label>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" name="email" value="" placeholder="" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-sm-4 col-form-label">Password</label>
                                        <div class="col-sm-5">
                                            <input type="password" class="form-control" name="password" placeholder="" disabled>
                                        </div>
                                    </div>
        
                                    <div class="form-group row">
                                        <label for="password_confirmation" class="col-sm-4 col-form-label">Confirm Password</label>
                                        <div class="col-sm-5">
                                            <input type="password" class="form-control" name="password_confirmation" placeholder="" disabled>
                                        </div>
                                    </div>
    
                                </div>
                            </form>
                        </div>
    
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" form="2ndform">Submit changes</button>
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
                    "{{ route('users.store') }}",
                    "POST",
                    "modal-new",
                    true,
                    function(){
                        $('#modal-new').modal('hide');
                        toastr.success("User created!");
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
                        toastr.success("User deleted!");
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
                        var custroute = '{{route('users.update',':id')}}';
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
                if(confirm("This action will delete the user. Proceed?")){
                    var action = $(this).data("action");
                    $('#formdestroy').attr("action", action);
                    $('#formdestroy').submit();
                }
            });
        });

        function reload1stTable(){
            reloadTable(
                '1sttable',
                '{{ route('users.table.index') }}',
                '{{ route('users.edit', ':id') }}',
                '{{ route('users.destroy', ':id') }}',
            );
        }
    </script>
@endpush
