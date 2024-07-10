<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVersion extends Model
{
    use HasFactory;
    protected $fillable = [
        'page_id', 
        'title', 
        'content'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}