<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'board_id'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_user', 'user_id', 'board_id');
    }
}
