@extends('layouts.app')

@section('maincontent')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Role Management</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                            <li class="breadcrumb-item active">Role Management</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->

                <div class="form"></div>
                <div class="edit_form"></div>
                @if (Auth::check())
                @can('role-create')
                    
                <div class="create_btn">
                    <button type="button" id="btn_create" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        New Role
                    </button>
                </div>
                @endcan
                @endif
            </div>
        </div>
        <br>

        <div class="main_content">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table class="table text-center Role_Datatables">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
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
    </div>
        <!-- /.content -->
    </div>
@endsection

@section('js')
    <script type="text/javascript">
            $(document).on("click","#btn_create", function () {
                $('#btn_create').hide();
                $('.main_content').hide();
                $('.form').show();
                $('.form').load('/role-form');
            });
            $(document).on('click','#btn_edit', function () {
                let id = $(this).attr("data-id");
                $('#btn_create').hide();
                $('.main_content').hide();
                $('.edit_form').show();
                $('.edit_form').load('/editrole/' + id);
            });
            $(document).on("click","#btn-delete", function () {
                var result = confirm("Are you sure for delete?");
                if (result) {
                    let id = $(this).attr("data-id");
                    $.ajax({
                        url: "{{ route('role.destroy') }}",
                        type: "post",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: id,
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('.Role_Datatables').DataTable().ajax.reload();
                        }
                    })

                }
            });
        $(document).ready(function() {
            $(function() {
                var table = $('.Role_Datatables').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('role.loadData') }}",
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
