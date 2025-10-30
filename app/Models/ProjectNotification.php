<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectNotification extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'type',
        'message',
        'params',
        'read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id_project');
    }

    public function getTranslatedMessageAttribute()
    {
        $params = $this->params ? json_decode($this->params, true) : [];

        return __($this->message, $params);
    }

    public function markAsRead()
    {
        $this->update(['read' => true]);

    }
}

