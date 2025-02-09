<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteTypes extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'note_types';

    static public function noteType($id)
    {
        return NoteTypes::where('id', $id)->first();
    }
}
