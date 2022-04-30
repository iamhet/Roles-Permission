@extends('layouts.app')

@section('maincontent')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Module 2</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                            <li class="breadcrumb-item active">Module2</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <button type="button" class="btn btn-success " id="btn_create">
                    Create +
                </button>
            </div>
        </div>
        <br>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table class="table text-center Module2_Datatables">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
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
        $(document).ready(function() {
            $(function() {
                var table = $('.Module2_Datatables').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('module2.loadData') }}",
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
                            data: 'firstName',
                            name: 'firstName'
                        },
                        {
                            data: 'lastName',
                            name: 'lastName'
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
