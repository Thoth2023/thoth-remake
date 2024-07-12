<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Study extends Model
{
    protected $table = 'papers';

    protected $primaryKey = 'id_paper';
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
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

    protected $dates = [
        'added_at',
        'update_at',
    ];

    public function bibUpload()
    {
        return $this->belongsTo(BibUpload::class, 'id_bib', 'id_bib');
    }
}
