<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VneduSheet extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Filterable;

    protected $fillable = [
        'sheet_name',
        'vnedu_file_id',
        'vnedu_subject_id',
        'sheet_index',
    ];

    public function vnedu_file() {
        return $this->belongsTo(VneduFile::class, 'vnedu_file_id');
    }

    public function vnedu_subject() {
        return $this->belongsTo(VneduSubject::class, 'vnedu_subject_id');
    }
}
