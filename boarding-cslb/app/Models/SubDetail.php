<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDetail extends Model
{
    protected $table = 'category_sub_detail';
    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
