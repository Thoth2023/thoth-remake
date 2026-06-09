<?php

namespace App\Models\Project\Conducting\QualityAssessment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PapersQaAnswer extends Model
{
    use HasFactory;

    protected $table      = 'papers_qa_answer';
    protected $primaryKey = 'id_papers_qa_answer';
    public $incrementing  = true;
    protected $keyType    = 'integer';
    public $timestamps    = false;

    protected $fillable = [
        'id_paper',
        'id_question',
        'id_answer',
    ];

    public function papersQa()
    {
        return $this->belongsTo(PapersQA::class, 'id_paper', 'id_paper');
    }
}
