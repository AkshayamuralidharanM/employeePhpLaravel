@extends('layouts.app')

@section('content')

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