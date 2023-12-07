<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EmployeeCrud;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class EmployeeCrudController extends Controller
{
    public function index()
    {
        return view('EmployeeCrud.index');
    }

    public function fetchemployee()
    {
        $employee = EmployeeCrud::all();
        return response()->json([
            'employee'=> $employee,
        ]);

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
            $date = $request->input('doj');
            $employee = new EmployeeCrud;
            $employee->name = $request->input('name');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
            $employee->address = $request->input('address');

            $employee->gender = $request->input('gender');
            $employee->department = $request->input('department');
            $employee->designation = $request->input('designation');


            try {
                $dobString = $request->input('dob');
                $dojString = $request->input('doj');

                // Parse and format the 'dob' and 'doj' dates
                $dob = Carbon::createFromFormat('m/d/Y', $dobString);
                $doj = Carbon::createFromFormat('m/d/Y', $dojString);
            
                $employee->dob = $dob->format('Y-m-d');
                $employee->doj = $doj->format('Y-m-d');
            } catch (\Exception $e) {
                // Print the error message for further debugging
                dd($e->getMessage());
            }
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

    public function edit($id){

        $employee = EmployeeCrud::find($id);
        if($employee){
            return response()->json([

                'status'=>200,
                'employee'=>$employee
            ]);
        }
        else{
            return response()->json([

                'status'=>404,
                'employee'=>'Employee Not found'
            ]);
        }
    }

    public function update(Request $request , $id){
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
            $employee = EmployeeCrud::find($id);

            if($employee)
            {
                $employee->name = $request->input('name');
                $employee->email = $request->input('email');
                $employee->phone = $request->input('phone');
                $employee->address = $request->input('address');

                $employee->gender = $request->input('gender');
                // $employee->dob = $request->input('dob');
                $employee->department = $request->input('department');
                $employee->designation = $request->input('designation');
                // $employee->doj = $request->input('doj');

                try {
                    $dobString = $request->input('dob');
                    $dojString = $request->input('doj');
    
                    // Parse and format the 'dob' and 'doj' dates
                    $dob = Carbon::createFromFormat('m/d/Y', $dobString);
                    $doj = Carbon::createFromFormat('m/d/Y', $dojString);
                
                    $employee->dob = $dob->format('Y-m-d');
                    $employee->doj = $doj->format('Y-m-d');
                } catch (\Exception $e) {
                    // Print the error message for further debugging
                    dd($e->getMessage());
                }

                if($request->hasFile('image'))
                {
                    $path = 'uploads/employee/'.$employee->image;

                    if(File::exists($path))
                    {
                        File::delete($path);
                    }

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
            else
            {

                return response()->json([
                    'status'=>404,
                    'message' => 'Employee Not found',
                ]);
            }
                
      
        
        } 
    }

    public function destroy ($id){

        $employee = EmployeeCrud::find($id);
        if($employee){

            $path = 'uploads/employee/'.$employee->image;

            if(File::exists($path)){
                File::delete($path);
            }

            $employee->delete();
            return response()->json([

                'status'=>200,
                'message'=>"Deleted Successfully"
            ]);
        }
        else{
            return response()->json([

                'status'=>404,
                'employee'=>'Employee Not found'
            ]);
        }
    }

}
