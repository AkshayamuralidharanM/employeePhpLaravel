<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function department()
    {
        $states = DB::table("departments")->pluck('name','id');        
        return view('index',compact('departments'));
    }

    public function designation($id)
    {
        $cities = DB::table("designation")
                    ->where("department_id",$id)
                    ->pluck('name','id');
        return json_encode($cities);
    }
}
