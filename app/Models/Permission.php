<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function levels()
    {
        return $this->belongsToMany(Level::class);
    }
}


