<form action="{{route('user.update')}}" class="edit_user" method="POST" enctype="multipart/form-data">
    @csrf
    @method("POST")
    <div class="container">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Name:</label>
            <input type="hidden" name="id" value="{{$user->id}}"/>
            <input type="text" name="name" class="form-control" value="{{$user->name}}"/>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Email:</label>
            <input type="text" name="email" class="form-control" value="{{$user->email}}"/>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Roles:</label>
            @foreach ($userRole as $user)
            <select name="roles" id="roles" class="form-control" value="{{$user}}">
                <option value="{{$user}}">{{$user}}</option>
                @foreach ($roles as $role)
                @if (!($role==$user))
                <option value="{{$role}}">{{$role}}</option>
                @endif
                @endforeach
            </select>
            @endforeach
        </div>
    </div></br>
    <div class="container">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<script type="text/javascript">
    $('.edit_user').on('submit', function(e) {
        e.preventDefault();
        var action = $(this).attr('action');
        $.ajax({
            url: action,
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(this).serialize(),
            dataType: 'json',

        }).done(function() {
            $('#btn_create').show();
            $('.content').show();
            $('.User_Datatables').DataTable().ajax.reload();
            $('.edit_form').hide();

        });
    });
</script>
