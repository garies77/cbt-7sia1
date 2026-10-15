<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamAttempt extends Model
{
    protected $guarded = [];

    protected $casts = [
        'started_at'  => 'datetime',
        'finished_at' => 'datetime',
        'is_passed'   => 'boolean',
    ];

    // relasi ke model Student
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    // relasi ke model Exam
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    // relasi ke model ExamAttemptAnswer
    public function attemptAnswers(): HasMany
    {
        return $this->hasMany(ExamAttemptAnswer::class);
    }
}
