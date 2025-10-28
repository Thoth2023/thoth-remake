<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsSource extends Model
{
    use HasFactory;

    protected $table = 'news_sources';

    protected $fillable = [
        'name',
        'url',
        'more_link',
        'active',
    ];

    /**
     * Retorna o domínio base da URL (ex: sbc.org.br)
     */
    public function getDomainAttribute(): string
    {
        $host = parse_url($this->url, PHP_URL_HOST);
        return preg_replace('/^www\./', '', $host);
    }
}
