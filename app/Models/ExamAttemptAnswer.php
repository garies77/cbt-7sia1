<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamAttemptAnswer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    // relasi ke model ExamAttempt
    public function examAttempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    // relasi ke model Question
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    // relasi ke model Answer (jawaban yang dipilih siswa)
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
