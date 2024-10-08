<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'room_feature', 'room_id', 'feature_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}
