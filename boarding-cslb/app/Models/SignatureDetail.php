<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignatureDetail extends Model
{
    protected $table = 'signature_detail';
    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
