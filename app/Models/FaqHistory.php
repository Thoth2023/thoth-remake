<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['faq_id', 'question', 'response', 'deleted_at'];

    protected $dates = ['deleted_at'];
}
