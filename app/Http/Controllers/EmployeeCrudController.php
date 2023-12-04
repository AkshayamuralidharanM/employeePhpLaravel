<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployeeCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeCrudController extends Controller
{
    public function index()
    {
        return view('EmployeeCrud.index');
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:191',
            'address'=>'required|max:191',
            'image'=>'required|image|mimes:jpeg,png,jpg|max:2048',
        ]); 

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors' => $validator->messages(),
            ]);
        }
        else
        {
            $employee = new EmployeeCrud;
            $employee->name = $request->input('name');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            $employee->address = $request->input('address');

            $employee->gender = $request->input('gender');
            $employee->dob = $request->input('dob');
            $employee->department = $request->input('department');
            $employee->designation = $request->input('designation');
            $employee->doj = $request->input('doj');

            if($request->hasFile('image'))
            {
                $file = $request->file('image');
                $extension =  $file->getClientOriginalExtension();
                $filename = time() . '.' .$extension;
                $file->move('uploads/employee/', $filename);
                $employee->image = $filename;
            }
            
            $employee->save();

            return response()->json([
                'status'=>200,
                'message' => 'Added Successfully',
            ]);
      
        
        }
    }

}
