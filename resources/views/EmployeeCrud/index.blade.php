@extends('layouts.app')

@section('content')

<!-- Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="AddEmployeeForm" enctype="multipart/form-data" method="post">
        <div class="modal-body">
            <ul class="alert alert-warning d-none" id="saveform_errList"></ul>
            <div class="form-group mb-3">
                <label for="">Name</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="">Email</label>
                <input type="text" name="email" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="">Gender</label>
                <input type="text" name="gender" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="">Address</label>
                <input type="text" name="address" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="">DOB</label>
                <input type="text" class="form-control datepicker" name="dob" placeholder="Select a date">
            </div>
            <div class="form-group mb-3">
                <label for="">DOJ</label>
                <input type="text" class="form-control datepicker" name="doj" placeholder="Select a date">
            </div>

            <div class="form-group mb-3">
                <label for="">Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="">Department</label>
                <input type="text" name="department" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="">Designation</label>
                <input type="text" name="designation" class="form-control">
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>

    
      </form>
</div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Employee Portal
                        <a href="#" data-bs-toggle="modal" data-bs-target="#employeeModal" class="btn btn-primary btn-sm float-end">Add Employee</a>
                    </h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Image</th>
                                        <th>DOB</th>
                                        <th>DOJ</th>
                                        <th>Department</th>
                                        <th>Designation</th>
                                        <th>Edit</th>
                                        <th>Delete</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Ari</td>
                                        <td>Male</td>
                                        <td>abc@gmail.com</td>
                                        <td>12344</td>
                                        <td>abc</td>
                                        <td><img src="" width="50px" height="50px" alt="Image"></td>
                                        <td>1/1/23</td>
                                        <td>1/1/23</td>
                                        <td>IT</td>
                                        <td>Developer</td>
                                        <td><button type="button" value="" class="edit_btn btn btn-success btn-sm">Edit</button></td>
                                        <td><button type="button" value="" class="delete_btn btn btn-danger btn-sm">Delete</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
  $(document).ready(function ()
  {

    $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    fetchEmployee();
    function fetchEmployee(){
        
        $.ajax({
            type:"GET",
            url:"/fetch-employee",
            dataType:"json",
            success:function(response){
                $('tbody').html("");
                $.each(response.employee,function(key,item){
                        $('tbody').append('<tr>\
                            <td>'+item.id+'</td>\
                            <td>'+item.name+'</td>\
                            <td>'+item.gender+'</td>\
                            <td>'+item.email+'</td>\
                            <td>'+item.phone+'</td>\
                            <td>'+item.address+'</td>\
                            <td><img src="uploads/employee/'+item.image+'" width="50px" height="50px" alt="Image"></td>\
                            <td>'+item.dob+'</td>\
                            <td>'+item.doj+'</td>\
                            <td>'+item.department+'</td>\
                            <td>'+item.designation+'</td>\
                            <td><button type="button" value="'+item.id+'" class="edit_employee btn btn-primary btn-sm">Edit</button></td>\
                            <td><button type="button" value="'+item.id+'" class="delete_employee btn btn-danger btn-sm">Delete</button></td>\
                        </tr>')
                    });
            }
        });
    }

    $(document).on('submit','#AddEmployeeForm',function(e){
            
            e.preventDefault();

            let formData = new FormData($('#AddEmployeeForm')[0]);

            

            $.ajax({
                type:"POST",
                url:"/employeecrud",
                data:formData,
                contentType:false,
                processData:false,
                success:function(response){
                     //console.log(response)
                     if(response.status == 400)
                    {
                        $('#saveform_errList').html("");
                        $('#saveform_errList').removeClass('d-none')

                        $.each(response.errors,function(key,err_values){
                            $('#saveform_errList').append('<li>'+err_values+'</li>');
                        });
                    }
                    else if(response.status == 200)
                    {
                        $('#saveform_errList').html("");
                        $('#saveform_errList').addClass('d-none');
                        $('#AddEmployeeForm').find('input').val('');
                        $('#employeeModal').modal('hide');

                       alert(response.message)

                    }

                    fetchEmployee();
                }
            });

        });
  });
</script>

@endsection