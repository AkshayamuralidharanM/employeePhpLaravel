<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
    }


    public function fetchstudent()
    {
        $employees = Employee::all();
        return response()->json([
            'employees'=> $employees,
        ]);

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:191',
            'address'=>'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors' => $validator->messages(),
            ]);
        }
        else
        {
            $employee = new Employee;
            $employee->name = $request->input('name');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            $employee->address = $request->input('address');
            $employee->save();

            return response()->json([
                'status'=>200,
                'message' => 'Added Successfully',
            ]);
        }
        
    }

    
    public function edit($id)
    {

      $employee = Employee::find($id);

      if($employee){
        return response()->json([
            'status' => 200,
            'employee'=>$employee,
        ]);
      }
      else{

        return response()->json([
            'status'=>404,
            'message' => 'EMployee Not Found',
        ]);
      }
        
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:191',
            'address'=>'required|max:191',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors' => $validator->messages(),
            ]);
        }
        else
        {
            $employee = Employee::find($id);

            if($employee){
                $employee->name = $request->input('name');
                $employee->email = $request->input('email');
                $employee->phone = $request->input('phone');
                $employee->address = $request->input('address');
                $employee->update();

                return response()->json([
                    'status'=>200,
                    'message' => 'Added Successfully',
                ]);

                return response()->json([
                    'status' => 200,
                    'employee'=>$employee,
                ]);
            }
            else{
                return response()->json([
                    'status'=>404,
                    'message' => 'Employee Not Found',
                ]);
                
            }
        }
        
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Employee deleted successfully',
        ]);
    }

}
