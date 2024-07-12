<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $table = 'paper';

    public $timestamps = true;

    protected $fillable = [
        'id_paper',
        'id_bib',
        'title',
        'author',
        'book_title',
        'volume',
        'pages',
        'num_pages',
        'abstract',
        'keywords',
        'doi',
        'journal',
        'issn',
        'location',
        'isbn',
        'address',
        'type',
        'bib_key',
        'url',
        'publisher',
        'year',
        'added_at',
        'update_at',
        'data_base',
        'id',
        'status_selection',
        'check_status_selection',
        'status_qa',
        'id_gen_score',
        'check_qa',
        'score',
        'status_extraction',
        'note',

    ];

}
