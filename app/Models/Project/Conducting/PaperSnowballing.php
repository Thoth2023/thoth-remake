<?php

namespace App\Models\Project\Conducting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaperSnowballing extends Model
{
    use HasFactory;

    protected $table = 'papers_snowballing';
    protected $primaryKey = 'id';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'paper_reference_id',
        'parent_snowballing_id',
        'doi',
        'title',
        'authors',
        'year',
        'abstract',
        'keywords',
        'type',
        'bib_key',
        'url',
        'type_snowballing',
        'is_duplicate',
        'is_relevant',
    ];

    /**
     * Relacionamento com a tabela papers
     * Cada entrada de snowballing pode ter como base um paper da tabela papers
     */
    public function paperReference()
    {
        return $this->belongsTo(Papers::class, 'paper_reference_id');
    }

    /**
     * Relacionamento com a própria tabela papers_snowballing
     * Cada entrada pode ter como "pai" outra entrada de snowballing
     */
    public function parentSnowballing()
    {
        return $this->belongsTo(PaperSnowballing::class, 'parent_snowballing_id');
    }

    /**
     * Relacionamento com os "filhos" de uma entrada de snowballing
     * Permite rastrear referências originadas de uma entrada atual
     */
    public function childSnowballings()
    {
        return $this->hasMany(PaperSnowballing::class, 'parent_snowballing_id');
    }
}
