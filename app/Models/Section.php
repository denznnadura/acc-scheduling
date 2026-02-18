<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'semester_id',
        'name',
        'year_level',
        'capacity',
        'adviser_id',
        'is_active',
    ];

    protected $casts = [
        'year_level' => 'integer',
        'capacity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function adviser(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'adviser_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    // ADD THIS RELATIONSHIP
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
