<?php

namespace App\Models\Project\Conducting\StudySelection;

use App\Models\Member;
use App\Models\Project\Conducting\Papers;
use Illuminate\Database\Eloquent\Model;

class PaperDecisionConflict extends Model
{
    // Define the table name if it's not the plural form of the model name
    protected $table = 'paper_decision_conflicts';

    // The attributes that are mass assignable
    protected $fillable = [
        'id_paper',
        'phase',
        'id_member',
        'old_status_paper',
        'new_status_paper',
        'note',
    ];

    // Define the relationship to the Papers model
    public function paper()
    {
        return $this->belongsTo(Papers::class, 'id_paper', 'id_paper');
    }

    // Define the relationship to the Members model
    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_members');
    }
}
