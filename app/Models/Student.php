<?php

namespace App\Models;

use App\Traits\HasUuidPrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes, HasUuidPrimaryKey;

    protected $guarded = ['id'];
    protected $primaryKey = 'id';

    public function lateStudent()
    {
        return $this->hasMany(LateStudent::class);
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
