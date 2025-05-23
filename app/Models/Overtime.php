<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    protected $fillable = ['employee_id', 'overtime_date', 'start_time', 'end_time', 'duration_hours', 'reason'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

   
}
