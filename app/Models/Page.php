<?php


//Intereção com banco de dados
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['title', 'content'];

    public function versions()
    {
        return $this->hasMany(PageVersion::class);
    }
}