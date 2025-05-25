<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    use HasFactory;

    protected $fillable = ['projeto_id', 'remetente_id', 'mensagem', 'tipo'];




    protected $table = 'mensagens';

    public function remetente()
    {
        return $this->belongsTo(\App\Models\User::class, 'remetente_id');
    }
}
