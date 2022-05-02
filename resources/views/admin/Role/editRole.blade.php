<form action="{{route('role.update')}}" class="edit_role" method="POST" enctype="multipart/form-data">
    @csrf
    @method("POST")
    <div class="container">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Name:</label>
            <input type="text" name="name" value="{{ $role->name }}" />
            <input type="hidden" name="id" id="id" value="{{ $role->id }}" />
        </div>
    </div>
    <div class="container">
        Update all Users's permission who use this role <input type="checkbox" name="change" class="form-control-select" value="true"/>
    </div><br><br>
    <div class="container">
        <div class="form-group">
            <label for="exampleInputEmail1" class="form-label">Permission:</label>
            <br />
            @foreach ($permission as $value)
                <label>
                    @if (in_array($value->id, $rolePermissions))
                        <input type="checkbox" name="{{ 'permission[]' }}" value="{{ $value->id }}" checked />
                        {{ $value->name }}
                    @endif
                    @if (!in_array($value->id, $rolePermissions))
                        <input type="checkbox" name="{{ 'permission[]' }}" value="{{ $value->id }}" />
                        {{ $value->name }}
                    @endif
                </label>
                <br />
            @endforeach
        </div>
    </div></br>
    <div class="container">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<script type="text/javascript">
    $('.edit_role').on('submit', function(e) {
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
            $('.main_content').show();
            $('.Purchase_Datatable').DataTable().ajax.reload();
            $('.edit_form').hide();

        });
    });
</script>
