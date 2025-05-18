<?php

namespace App\Models;

<<<<<<< Updated upstream
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> Stashed changes
use Illuminate\Database\Eloquent\Model;

class ProjectNotification extends Model
{
<<<<<<< Updated upstream
    protected $table = 'project_notifications'; // Tabela existente

    protected $fillable = [
        'user_id',
        'project_id',
        'type',      // Ex: 'invitation', 'update'
        'message',
        'read'       // 0 = não lida, 1 = lida
    ];

    // Relação com o usuário
=======
    protected $fillable = [
        'user_id',
        'project_id',
        'type',
        'message',
        'read'
    ];

>>>>>>> Stashed changes
    public function user()
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< Updated upstream
    // Relação com o projeto
    // app/Models/ProjectNotification.php

// Especifique a relação com Project usando a chave correta
public function project()
{
    return $this->belongsTo(Project::class, 'project_id', 'id_project');
}

    // Marcar como lida
    public function markAsRead()
    {
        $this->update(['read' => true]);
=======
    public function project()
    {
        return $this->belongsTo(Project::class);
>>>>>>> Stashed changes
    }
}