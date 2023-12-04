<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCrud extends Model
{
    use HasFactory;

    protected $table  = "employeescrud";
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'gender',
        'image',
        'Dob',
        'Department',
        'Doj',
        'Designation',        
    ];
}
