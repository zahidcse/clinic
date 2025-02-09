<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsState extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'us_states';
}
