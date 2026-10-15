<?php

use App\Models\Answer;
use App\Models\ExamAttempt;
use App\Models\Question;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ExamAttempt::class)
                ->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Question::class)
                ->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Answer::class)
                ->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_correct')->default(false);
            $table->integer('score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_attempt_answers');
    }
};
