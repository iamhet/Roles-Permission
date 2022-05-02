<form action="{{ route('role.store') }}" class="role_create" method="POST" enctype="multipart/form-data">
    @csrf
    @method("POST")
    <div class="container">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" />
        </div>
    </div>
    <div class="container">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Permission:</label>
            <br />
            @foreach ($permission as $value)
                <input type="checkbox" name="{{ 'permission[]' }}" value="{{ $value->id }}"/> {{ $value->name }}
                <br />
            @endforeach
        </div>
    </div>
    <div class="container">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script type="text/javascript">
    $('.role_create').on('submit', function(e) {
        e.preventDefault();
        var action = $(this).attr('action');
        console.log($(this).serialize());
        // $.ajax({
        //     type: "post",
        //     url: "{{ route('role.store') }}",
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     data: $(this).serialize(),
        //     dataType: "json",
        // }).done(function() {
        //     $('#btn_create').show();
        //     $('.main_content').show();
        //     $('.Role_Datatables').DataTable().ajax.reload();
        //     $('.form').hide();
        // });
    });
</script>
