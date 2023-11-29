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

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4> Employee
                    <a href="#" data-bs-toggle="modal" data-bs-target="#AddEmployeeModal" class="btn btn-primary float-end btn-sm">Add students</a>
                </h4>
            </div>
            <div class="card-body">

            </div>
        </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function () {
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
                    console.log(response)
                }
            });
        });
    });
</script>

@endsection