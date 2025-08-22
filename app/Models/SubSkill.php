<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'skill_id'
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    // Accessor para obtener el level a través de skill
    public function getLevelAttribute()
    {
        return $this->skill->level ?? null;
    }

    // Scope para filtrar por level
    public function scopeByLevel($query, $levelId)
    {
        return $query->whereHas('skill', function ($q) use ($levelId) {
            $q->where('level_id', $levelId);
        });
    }
}
