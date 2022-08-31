<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'player_id',
        'from',
        'to',
        'reference',
        'status',
        'amount',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function players()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

}
