<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeCrudController extends Controller
{
    public function index()
    {
        return view('EmployeeCrud.index');
    }

}
