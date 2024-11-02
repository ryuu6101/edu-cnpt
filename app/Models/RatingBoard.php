<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'semester_id',
        'department_id',
        'school_id',
        'class_id',
        'student_id',
        'tu_quan',
        'hop_tac',
        'tu_hoc',
        'cham_hoc',
        'tu_tin',
        'trung_thuc',
        'doan_ket',
    ];
}
