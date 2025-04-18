<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model {
    use HasFactory;
    protected $fillable = ['employee_id', 'status', 'attempt_time'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

