<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'start_time', 'end_time', 'title'];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
