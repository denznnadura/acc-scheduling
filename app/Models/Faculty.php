<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculty'; // Add this line to specify the table name

    protected $fillable = [
        'user_id',
        'department_id',
        'employee_id',
        'position',
        'rank',
        'specializations',
        'max_units',
        'max_preparations',
        'preferred_days',
        'preferred_times',
        'is_active',
    ];

    protected $casts = [
        'specializations' => 'array',
        'max_units' => 'integer',
        'max_preparations' => 'integer',
        'preferred_days' => 'array',
        'preferred_times' => 'array',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function advisingSections(): HasMany
    {
        return $this->hasMany(Section::class, 'adviser_id');
    }
}
