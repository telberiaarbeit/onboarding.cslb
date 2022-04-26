<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateDetail extends Model
{
    protected $table = 'category_date_detail';
    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
