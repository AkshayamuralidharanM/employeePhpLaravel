@extends('layouts.app')

@section('content')

<!-- Modal -->
<div class="modal fade" id="AddEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul id="saveform_errList">

        </ul>
        <div class="form-group mb-3">
            <label for="">Name</label>
            <input type="text" class="name form-control">
        </div>

        <div class="form-group mb-3">
            <label for="">Email</label>
            <input type="text" class="email form-control">
        </div>

        <div class="form-group mb-3">
            <label for="">Phone</label>
            <input type="text" class="phone form-control">
        </div>

        <div class="form-group mb-3">
            <label for="">Address</label>
            <input type="text" class="address form-control">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_employee">Save</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="EditEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit & Update Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul id="updateform_errList">
        <input type="hidden" id="edit_emp_id">
        </ul>
        <div class="form-group mb-3">
            <label for="">Name</label>
            <input type="text" id="edit_name" class="name form-control">
        </div>

        <div class="form-group mb-3">
            <label for="">Email</label>
            <input type="text" id="edit_email"  class="email form-control">
        </div>

        <div class="form-group mb-3">
            <label for="">Phone</label>
            <input type="text" id="edit_phone"  class="phone form-control">
        </div>

        <div class="form-group mb-3">
            <label for="">Address</label>
            <input type="text" id="edit_address"  class="address form-control">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="UpdateBtn" class="btn btn-primary update_employee">Update</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="DeleteEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> Delete Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <input type="hidden" class="" id="delete_emp_id">
       <h4>Are you sure ? want to delete this data ? </h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="UpdateBtn" class="btn btn-danger delete_employee_btn">Delete</button>
      </div>
    </div>
  </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">

        <div id="success_message" class="mb-3">
                
        </div>
        
        <div class="card">
          
            <div class="card-header">
                <h4> Employee
                    <a href="#" data-bs-toggle="modal" data-bs-target="#AddEmployeeModal" class="btn btn-primary float-end btn-sm">Add students</a>
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function () {

        function handleSuccess(message) {
            $('#success_message').removeClass().addClass('alert alert-success').text(message).fadeIn(500);

            setTimeout(function() {
                $('#success_message').fadeOut(500);
            }, 3000); 
        }

        function handleError(message) {
            $('#success_message').removeClass().addClass('alert alert-danger').text(message).fadeIn(500);

            setTimeout(function() {
                $('#success_message').fadeOut(500);
            }, 3000); 
        }

        fetchstudent();
        function fetchstudent()
        {
            $.ajax({
                type:"GET",
                url:"/fetch-students",
                dataType:"json",
                success:function(response){
                    console.log(response.employees)
                    $('tbody').html("")
                    $.each(response.employees,function(key,item){
                        $('tbody').append('<tr>\
                            <td>'+item.id+'</td>\
                            <td>'+item.name+'</td>\
                            <td>'+item.email+'</td>\
                            <td>'+item.phone+'</td>\
                            <td>'+item.address+'</td>\
                            <td><button type="button" value="'+item.id+'" class="edit_employee btn btn-primary btn-sm">Edit</button></td>\
                            <td><button type="button" value="'+item.id+'" class="delete_employee btn btn-danger btn-sm">Delete</button></td>\
                        </tr>')
                    });
                }
            });
        }

        $(document).on('click','.edit_employee',function(e){
            
            e.preventDefault();
            var emp_id = $(this).val();

            $('#EditEmployeeModal').modal('show');

            $.ajax({
                type:"GET",
                url:"/edit-employee/"+emp_id,
                success:function(response){
                    if(response.status == 404)
                    {
                        //$('#success_message').html("");
                        //$('#success_message').addClass('alert alert-danger')
                        //$('#success_message').text(response.message);
                        handleError(response.message);
                    } else {
                        $("#edit_name").val(response.employee.name);
                        $("#edit_email").val(response.employee.email);
                        $("#edit_phone").val(response.employee.phone);
                        $("#edit_address").val(response.employee.address);
                        $("#edit_emp_id").val(emp_id);
                        $("#UpdateBtn").val(emp_id);
                       
                    }
                }
            });

        });

        $(document).on('click','.add_employee',function(e){
            
            e.preventDefault();

            var data = {

                'name':$('.name').val(),
                'email':$('.email').val(),
                'phone':$('.phone').val(),
                'address':$('.address').val(),


            }

            //console.log(data)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:"POST",
                url:"/employees",
                data:data,
                dataType:"json",
                success:function(response){
                    //console.log(response)
                    if(response.status == 400)
                    {
                        $('#saveform_errList').html("");
                        $('#saveform_errList').addClass('alert alert-danger')

                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                    }
                    else
                    {
                        $('#saveform_errList').html("");
                        //$('#success_message').addClass('alert alert-success')
                        //$('#success_message').text(response.message)
                        handleSuccess(response.message)
                        $('#AddEmployeeModal').modal('hide');
                        $('#AddEmployeeModal').find('input').val("");
                        fetchstudent();
                    }
                }
            });
        });

        $(document).on('click','.update_employee',function(e){
            
            e.preventDefault();
            $(this).text("Updating")

            var emp_id = $('#UpdateBtn').val();
            console.log(emp_id)

            var data = {
                'name' : $('#edit_name').val(),
                'email' : $('#edit_email').val(),
                'phone' : $('#edit_phone').val(),
                'address' : $('#edit_address').val(),
            }
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:"PUT",
                url:"/update-employee/"+emp_id,
                data:data,
                dataType:"json",
                success:function(response){
                    if(response.status == 400){
                        $('#updateform_errList').html("");
                        $('#updateform_errList').addClass('alert alert-danger')

                        $.each(response.errors,function(key,err_values){
                            $('#updateform_errList').append('<li>'+err_values+'</li>');
                        });
                        $('#EditEmployeeModal').modal('hide');
                        $('.update_employee').text("Update")
                    }
                    else if(response.status == 404){
                        $('#updateform_errList').html("");
                        //$('#success_message').addClass('alert alert-success')
                        //$('#success_message').text(response.message)
                        handleError(response.message);
                        $('#EditEmployeeModal').modal('hide');
                        $('.update_employee').text("Update")
                    }
                    else{
                        $('#updateform_errList').html("");
                        //$('#success_message').html("");

                        //$('#success_message').addClass('alert alert-success')
                        //$('#success_message').text(response.message)
                        handleSuccess(response.message);
                        $('#EditEmployeeModal').modal('hide');
                        $('.update_employee').text("Update")

                        fetchstudent();
                    }
                }
            });
        });

        $(document).on('click','.delete_employee',function(e){
            
            e.preventDefault();
            var emp_id = $(this).val();
            $('#delete_emp_id').val(emp_id);
            $('#DeleteEmployeeModal').modal('show');

        });

        $(document).on('click','.delete_employee_btn',function(e){
            
            e.preventDefault();
            $(this).text('Deleting')
            var emp_id = $('#delete_emp_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({

                type:"DELETE",
                url:"/delete-employee/"+emp_id,

                success:function(response){

                    //$('#success_message').addClass('alert alert-success')
                    //$('#success_message').text(response.message);
                    handleSuccess(response.message)

                    $('.delete_employee_btn').text('Delete');
                    $('#DeleteEmployeeModal').modal('hide');

                    fetchstudent();
                }
            });
           

        });
    });
</script>

@endsection