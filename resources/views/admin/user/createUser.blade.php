<form action="{{ route('user.store') }}" class="user_create" method="POST" enctype="multipart/form-data">
    @csrf
    @method("POST")
    <div class="container">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" />
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Email:</label>
            <input type="text" name="email" class="form-control" />
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Password:</label>
            <input type="text" name="password" class="form-control" />
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Roles:</label>
            <select name="roles" id="roles" class="form-control">
                @foreach ($roles as $role)
                <option value="{{$role}}">{{$role}}</option>
                @endforeach
            </select>
        </div>
        
    </div>
    
    <div class="container">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<script type="text/javascript">
    $('.user_create').on('submit', function(e) {
        e.preventDefault();
        var action = $(this).attr('action');
        $.ajax({
            type: "post",
            url: action,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(this).serialize(),
            dataType: "json",
        }).done(function() {
            $('.create_form').hide();
            $('#btn_create').show();
            $('.content').show();
            $('.User_Datatables').DataTable().ajax.reload();
        });
    });
</script>
