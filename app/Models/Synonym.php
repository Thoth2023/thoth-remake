<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Term;

class Synonym extends Model
{
    use HasFactory;
    protected $table = 'synonym';
    protected $primaryKey = 'id_synonym';
    protected $fillable = [
        'description',
        'term_id',
    ];

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

}
