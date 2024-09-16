<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'room_feature');
    }
}
