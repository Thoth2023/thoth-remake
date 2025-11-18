<?php

namespace App\Models\Project\Conducting;

use Illuminate\Database\Eloquent\Model;

class SnowballJob extends Model
{
    protected $table = 'snowball_jobs';

    protected $fillable = [
        'project_id','paper_id','seed_doi','modes','status','progress',
        'processed','discovered','enqueued','message','started_at','finished_at',
    ];

    protected $casts = [
        'modes' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}
