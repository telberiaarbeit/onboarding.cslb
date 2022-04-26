<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    protected $table = 'task_detail';
    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
