<?php

namespace App\Models;

use App\Models\Project\Conducting\QualityAssessment\PapersQA;
use App\Models\Project\Conducting\StudySelection\PapersSelection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_members';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function papers_selection()
    {
        return $this->hasMany(PapersSelection::class, 'id_member', 'id_members');
    }

    public function evaluation_criteria()
    {
        return $this->hasMany(EvaluationCriteria::class, 'id_member', 'id_members');
    }

    public function evaluationQA()
    {
        return $this->hasMany(EvaluationQA::class, 'id_member', 'id_member');
    }

    public function papersQA()
    {
        return $this->hasMany(PapersQA::class, 'id_member', 'id_member');
    }
}
