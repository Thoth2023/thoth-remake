<?php

namespace App\Models; // Namespace principal do diretório dos modelos

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeManagerHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['home_manager_id', 'title', 'description', 'icon', 'deleted_at'];

    protected $dates = ['deleted_at'];

    // Relacionamento com HomeManager
    public function homeManager()
    {
        return $this->belongsTo(HomeManager::class);
    }
}
