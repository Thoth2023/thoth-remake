<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use App\Models\User;

class Level extends Model{
    use HasFactory;
    protected $table = 'levels';
    

    protected $fillable = [
        'level',
        'description',
    ]; 

    protected $primaryKey = 'id_level';
    public $incrementing = true; 
    protected $keyType = 'int';
    public $timestamps = true;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}