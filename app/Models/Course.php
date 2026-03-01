<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'code',
        'name',
        'description',
        'units',
        'lecture_hours',
        'lab_hours',
        'type',
        'prerequisite_ids',
        'is_active',
    ];

    protected $casts = [
        'units' => 'integer',
        'lecture_hours' => 'integer',
        'lab_hours' => 'integer',
        'prerequisite_ids' => 'array',
        'is_active' => 'boolean',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function sections(): HasManyThrough
    {
        return $this->hasManyThrough(
            Section::class,
            Schedule::class,
            'course_id', 
            'id',        
            'id',        
            'section_id' 
        )->distinct();
    }

    public function prerequisites()
    {
        if (empty($this->prerequisite_ids)) {
            return collect();
        }
        return Course::whereIn('id', $this->prerequisite_ids)->get();
    }
}