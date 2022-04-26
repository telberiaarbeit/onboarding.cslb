<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteDetail extends Model
{
    protected $table = 'note_detail';
    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
