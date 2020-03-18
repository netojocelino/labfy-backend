<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $primaryKey = 'card_id';

    protected $fillable = [
        'title', 'content', 'label', 'created_at'
    ];
}
