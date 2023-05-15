@extends('layouts.app', [
    'title'     => 'Activity Log',
    'header'    => 'Activity Log',
    'breads'     => [               // breadcrumbs
        [
            'name'  => 'Home',
            'url'   => route('home'),
        ],
        [
            'name'  => 'Activity Log',
            'url'   => 'active',
        ],
    ],
])

@section('pagetitle', 'Log Activity')

@section('content')
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Log List</h3>

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
                            <th>Type</th>
                            <th>Controller</th>
                            <th>Function</th>
                            <th>Result</th>
                            <th>Message</th>
                            <th>User</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{$log->type}}</td>
                                <td>{{$log->controller}}</td>
                                <td>{{$log->function}}</td>

                                @if($log->result)
                                <td>Success</td>
                                @else
                                <td>Failed</td>
                                @endif
                                <td>{{$log->message}}</td>
                                @if ($log->User)
                                <td>{{$log->User->name}} ({{$log->User->id}})</td>
                                @else
                                <td>SYSTEM</td>
                                @endif
                                <td>{{$log->created_at}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <div class="card-footer">
                <div class="float-right">
                    <button class="btn btn-primary" id="create">Create new user</button>
                </div>
            </div> --}}
        </div>
    </section>
@endsection

@push('stylesheet')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap4.min.css">
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap4.min.js"></script>
    <script>
        $("#create").click(function(){
            window.location.href = "{{route('users.create')}}";
        })
    </script>

    <script>
        $( document ).ready(function(){
            $('#1sttable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order": [[6, 'desc']],
            });
        });
    </script>
@endpush
