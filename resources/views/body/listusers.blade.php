@include('main/header')


<div class="modal" id="UserEditModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTitleUsername"></h5>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="width: 100%; max-width: 100%; display: none;" id="AlertMessage">
                </div>
                <form method="POST" id="UserEditForm" class="pt-3">
                    <div class="form-outline mb-4">
                        <label class="form-label" for="Username">Username</label>
                        <input type="hidden" name="UserID" id="UserID">
                        <input type="text" name="Username" id="Username" class="form-control">
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="Email">Email address</label>
                        <input type="email" name="email" id="Email" class="form-control">
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="GameName">Minecraft Username</label>
                        <input type="text" name="GameName" id="GameName" class="form-control">
                    </div>
                    <div class="form-outline mb-4" id="PasswordField">
                        <label class="form-label" for="Password">Password</label>
                        <input type="password" name="Password" id="Password" class="form-control">
                    </div>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="UserStatus">Status</label>
                        <select name="UserStatus" id="UserStatus" class="form-select">
                            <option value="0">Disabled</option>
                            <option value="1">Active</option>
                            @if ($Session["Authority"] >= 2)
                            <option value="2">Admin</option>
                            @endif
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" onclick="AddOrCreateUser()" id="UserSaveButton"></button>
                <button class="btn btn-danger" id="UserCloseButton" type="button"
                    onclick="$('#UserEditModal').modal('hide');"><i class="fa fa-xmark"></i> Close</button>
            </div>
        </div>
    </div>
</div>


<!-- BODY -->
<main class="col-md-9 ms-sm-auto col-lg-10 col-xxl-11 px-md-4 p-4">

    <div class="row g-3">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header  bg-dark text-light h1 text-center">Users</div>
                <div class="card-body bg-dark text-light table-responsive">
                    <button class="btn-success btn" onclick="CreateUser(this)"><i class="fa fa-user-plus"></i> Add
                        User</button>
                    <br>
                    <br>
                    <table id="UserTable" class="table table-striped table-hover table-dark fluid w-100">
                        <thead>
                            <tr>
                                <th>
                                    Game Name
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Death counts
                                </th>
                                <th>
                                    <div class="float-right">
                                        Actions
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Users as $User)
                            <tr class="">
                                <td>{{$User->GameName}}</td>
                                <td>{{$User->name}}</td>
                                <td>{{$User->email}}</td>
                                <td>0</td>
                                <td>
                                    <div class="float-right">
                                        <button type="button" onclick="EditUser('{{$User->id}}', this)"
                                            class="btn btn-sm btn-warning"><i data-feather="edit"></i></button>
                                        @if($Session["UserID"] != $User->id )
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="if(confirm('Are you sure you want to delete this user?')){DeleteUser({{$User->id}})}"><i
                                                data-feather="trash"></i></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>
<!-- BODY -->


<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#UserTable').DataTable();
    });
    
    function EditUser(id,e)
    {
        $.get('/users/'+id).done( function(result)
        {
            $("#AlertMessage").css("display", "none");
            $("#Username").val(result.name);
            $("#Email").val(result.email);
            $("#GameName").val(result.GameName);
            $("#UserStatus").val(result.Authority).change();
            $("#UserSaveButton").html(`<i class="fa fa-save"></i> Save User`);
            $("#ModalTitleUsername").text(`Editting "${result.name}"`);
            $("#UserID").val(id);
            $("#PasswordField").css("display", "none");
            $("#PasswordField").val("");
            $("#UserEditModal").modal("show");
        });
    }
     
    function DeleteUser(id)
    {
        $.ajax({
            method: "DELETE",
            url: "{{ route('User.Delete')}}",
            data: { UserID: id},
            success: function(result){
                location.reload();
            }
        });
    }

    function CreateUser(e)
    {
        $("#AlertMessage").css("display", "none");
        $("#Username").val("");
        $("#Email").val("");
        $("#GameName").val("");
        $("#UserStatus").val(0).change();
        $("#UserSaveButton").html(`<i class="fa fa-plus"></i> Create User`);
        $("#ModalTitleUsername").text(`Add new user`);
        $("#UserID").val(0);
        $("#PasswordField").css("display", "block");
        $("#PasswordField").val("");
        $("#UserEditModal").modal("show");
    }

    function AddOrCreateUser()
    {
        $("#UserSaveButton").prop("disabled", true);
        $("#UserCloseButton").prop("disabled", true);
        $("#Username").prop("disabled", true);
        $("#Email").prop("disabled", true);
        $("#GameName").prop("disabled", true);
        $("#UserStatus").prop("disabled", true);
            $.post("{{ route('User.AddOrCreate') }}", {
                data: {
                    UserID: $("#UserID").val(),
                    name: $("#Username").val(),
                    email: $("#Email").val(),
                    GameName: $("#GameName").val(),
                    Authority:  $("#UserStatus").val(),
                    Password: $("#Password").val()
                }
            }).done(function(result){
                $("#AlertMessage").removeClass("alert-success alert-danger").addClass("alert-success");
                $("#AlertMessage").css("display", "block");
                $("#AlertMessage").text(result.Message);
                setTimeout(function () {
                    location.reload();
                }, 1500);


            }).fail(function(){
                $("#AlertMessage").removeClass("alert-success alert-danger").addClass("alert-danger");
                $("#AlertMessage").css("display", "block");
                $("#AlertMessage").text("Something went wrong, please try again later!");
                $("#UserSaveButton").prop("disabled", false);
                $("#UserCloseButton").prop("disabled", false);
                $("#Username").prop("disabled", false);
                $("#Email").prop("disabled", false);
                $("#GameName").prop("disabled", false);
                $("#UserStatus").prop("disabled", false);
            });

    }
</script>

@include('main/footer')