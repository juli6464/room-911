<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
    use HasFactory;
    protected $fillable = ['internal_id', 'name', 'last_name', 'department_id', 'access_granted'];
}
