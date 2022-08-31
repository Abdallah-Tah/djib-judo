<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'club_id',
        'user_id',
        'email',
        'phone',
        'address',
        'photo',
        'address',
        'gender',
        'dob',
    ];

    public function clubs()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'player_id');
    }
}
