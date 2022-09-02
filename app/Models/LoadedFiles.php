<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadedFiles extends Model
{
    use HasFactory;

    protected $table = "loaded_files";

    protected $guarded = [];
}
