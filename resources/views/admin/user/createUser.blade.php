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
        <div class="permission">
            <div class="container">
                <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label">Permission:</label>
                    <br />
                    <label>
                        <div class="edit-permisison">
                        
                        </div>
                        </label>
                        <br/>
                </div>
             </div></br>
        </div>
    </div>
    
    <div class="container">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $('.permission').hide();  
        var data = $('#roles').val();
        var data1 = {roles : data};
        $.ajax({
            type: "post",
            url: "{{route('user.getpermission')}}",
            data : data1,
            dataType : 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var data = [];
                var length =(response.rolePermissions).length;
                var i;
                $.each(response.permission, function (key, value) { 
                            
                    if($.inArray(value['id'],response.rolePermissions)!== -1) 
                    {
                        data.push('<input type="checkbox" class="form-control-select" name="permission[]" value='+value['name']+' checked /> '+value['name']+'<br>');
                    }
                    else{
                        data.push('<input type="checkbox" class="form-control-select" name="permission[]" value='+value['name']+'  /> '+value['name']+'<br>');
                    }     
                    // data.push(element);
                });
                $('.permission').show();
                $('.edit-permisison').html(data);
            }
        });      
    });
    $('#roles').on("change", function () {
        var data = $(this).serialize();
        $.ajax({
            type: "post",
            url: "{{route('user.getpermission')}}",
            data : data,
            dataType : 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var data = [];
                var length =(response.rolePermissions).length;
                var i;
                $.each(response.permission, function (key, value) { 
                            
                    if($.inArray(value['id'],response.rolePermissions)!== -1) 
                    {
                        data.push('<input type="checkbox" class="form-control-select" name="permission[]" value='+value['name']+' checked /> '+value['name']+'<br>');
                    }
                    else{
                        data.push('<input type="checkbox" class="form-control-select" name="permission[]" value='+value['name']+'  /> '+value['name']+'<br>');
                    }     
                    // data.push(element);
                });
                $('.permission').show();
                $('.edit-permisison').html(data);
            }
        });
        
    });
    $('.user_create').on('submit', function(e) {
        e.preventDefault();
        var action = $(this).attr('action');
        console.log($(this).serialize());
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
