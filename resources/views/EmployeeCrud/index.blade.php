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
  $(document).ready(function () {

    $(document).on('submit','#AddEmployeeForm',function(e){
            
            e.preventDefault();

            let formData = new FormData($('#AddEmployeeForm')[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                }
            });

        });
  });
</script>

@endsection