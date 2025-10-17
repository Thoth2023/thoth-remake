<?php

namespace App\Models\Project\Conducting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project\Conducting\Papers;

class PaperSnowballing extends Model
{
    use HasFactory;

    protected $table = 'papers_snowballing';
    protected $primaryKey = 'id';

    protected $fillable = [
        'paper_reference_id',
        'parent_snowballing_id',
        'doi',
        'title',
        'authors',
        'year',
        'url',
        'type',
        'abstract',
        'bib_key',
        'type_snowballing',
        'snowballing_process',
        'source',
        'relevance_score',
        'duplicate_count',
        'is_duplicate',
        'is_relevant',
    ];

    protected $casts = [
        'relevance_score' => 'float',
        'duplicate_count' => 'integer',
        'is_relevant' => 'boolean',
        'is_duplicate' => 'boolean',
    ];

    /**
     * Cada entrada de snowballing tem como base um paper original.
     */
    public function paper()
    {
        // paper_reference_id -> id_paper
        return $this->belongsTo(Papers::class, 'paper_reference_id', 'id_paper');
    }

    /**
     * Relação recursiva: cada entrada pode ter um "pai" (outra entrada de snowballing)
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_snowballing_id');
    }

    /**
     * Relação recursiva inversa: obter todos os "filhos" de uma entrada de snowballing
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_snowballing_id');
    }

    /**
     * Escopo auxiliar: ordenar pelos critérios de relevância e duplicidade
     */
    public function scopeOrderByRelevance($query)
    {
        return $query->orderByDesc('relevance_score')->orderByDesc('duplicate_count');
    }
}
