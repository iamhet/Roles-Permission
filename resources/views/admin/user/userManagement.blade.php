@extends('layouts.app')

@section('maincontent')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Management</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Management</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                @if (Auth::check())
                @can('user-create')
                    
                <button type="button" class="btn btn-success " id="btn_create">
                    Create +
                </button>
                @endcan
                @endif
            </div>
        </div>
        <br>
        <div class="create_form"></div>
        <div class="edit_form"></div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table class="table text-center User_Datatables">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Item_Id</th>
                                            <th>Item_Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).on('click', '#btn_create', function() {
            $('#btn_create').hide();
            $('.content').hide();
            $('.create_form').show();
            $('.create_form').load('/user-form');
        });
        $(document).on('click', '#btn_edit', function() {
            let id = $(this).attr("data-id");
            $('#btn_create').hide();
            $('.content').hide();
            $('.edit_form').show();
            $('.edit_form').load('/edituser/' + id);
        });
        $(document).on("click", "#btn-delete", function() {
            var result = confirm("Are you sure for delete?");
            if (result) {
                let id = $(this).attr("data-id");
                $.ajax({
                    url: "{{ route('user.destroy') }}",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                    },
                    dataType: 'json'
                }).done(function() {
                    $('.User_Datatables').DataTable().ajax.reload();
                });

            }
        });
        $(document).ready(function() {

            $(function() {
                var table = $('.User_Datatables').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('user.loadData') }}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });
        });
    </script>
@endsection
