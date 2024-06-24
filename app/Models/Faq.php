<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'response',
        'page_id' // Adicionando identificador de página
    ];
    protected $table = 'faq';
    
    public static function boot()
    {
        parent::boot();

        static::updated(function ($faq) {
            PageVersion::create([
                'page_id' => $faq->page_id,
                'title' => $faq->question,
                'content' => $faq->response,
                'created_at' => now()
            ]);
        });

        static::deleted(function ($faq) {
            PageVersion::create([
                'page_id' => $faq->page_id,
                'title' => $faq->question,
                'content' => $faq->response,
                'created_at' => now()
            ]);
        });
    }
}
