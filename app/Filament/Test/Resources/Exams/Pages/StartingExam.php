<?php

namespace App\Filament\Test\Resources\Exams\Pages;

use App\Filament\Test\Resources\Exams\ExamResource;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ExamAttemptAnswer;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class StartingExam extends Page
{
    protected static string $resource = ExamResource::class;

    protected string $view = 'filament.test.resources.exams.pages.starting-exam';

    public array $collections = [];

    // jawaban siswa: key = question_id, value = answer_id
    public array $jawaban = [];

    public ?ExamAttempt $attempt = null;

    public ?Exam $exam = null;

    public function mount(Exam $exam)
    {
        $student = Auth::user()->student;

        if (! $student) {
            Notification::make()
                ->title('Data siswa tidak ditemukan')
                ->danger()
                ->send();

            $this->redirect(ExamResource::getUrl());
            return;
        }

        // cek apakah sudah pernah mengerjakan ujian ini dan sudah selesai
        $existing = ExamAttempt::where('student_id', $student->id)
            ->where('exam_id', $exam->id)
            ->whereNotNull('finished_at')
            ->first();

        if ($existing) {
            Notification::make()
                ->title('Kamu sudah mengerjakan ujian ini')
                ->warning()
                ->send();

            $this->redirect(ExamResource::getUrl());
            return;
        }

        // cek apakah sudah ada attempt yang belum selesai (lanjutkan)
        $this->attempt = ExamAttempt::firstOrCreate(
            [
                'student_id' => $student->id,
                'exam_id'    => $exam->id,
                'finished_at' => null,
            ],
            [
                'started_at' => now(),
            ]
        );

        $this->exam = $exam;

        $pelajarans = $exam->subjects;

        foreach ($pelajarans as $mapel) {
            $this->collections[] = [
                'id'    => $mapel->id,
                'name'  => $mapel->name,
                'soals' => $mapel
                            ->questions()
                            ->where('is_active', true)
                            ->with([
                                'answers' => fn ($query) => $query->inRandomOrder(),
                            ])
                            ->inRandomOrder()
                            ->limit($mapel->pivot->qty)
                            ->get()
                            ->toArray(),
            ];
        }

        // inisialisasi jawaban kosong
        foreach ($this->collections as $pelajaran) {
            foreach ($pelajaran['soals'] as $soal) {
                $this->jawaban[$soal['id']] = null;
            }
        }
    }

    public function submit(): void
    {
        if (! $this->attempt) {
            return;
        }

        $correctCount = 0;
        $wrongCount = 0;
        $unansweredCount = 0;
        $totalScore = 0;
        $maxScore = 0;

        foreach ($this->collections as $pelajaran) {
            foreach ($pelajaran['soals'] as $soal) {
                $questionId = $soal['id'];
                $answerId = $this->jawaban[$questionId] ?? null;
                $questionScore = $soal['score'] ?? 1;
                $maxScore += $questionScore;

                // cari jawaban yang benar untuk soal ini
                $correctAnswer = collect($soal['answers'])
                    ->firstWhere('is_correct', true);

                $isCorrect = false;

                if ($answerId) {
                    $isCorrect = $correctAnswer && (int) $answerId === (int) $correctAnswer['id'];

                    if ($isCorrect) {
                        $correctCount++;
                        $totalScore += $questionScore;
                    } else {
                        $wrongCount++;
                    }
                } else {
                    $unansweredCount++;
                }

                // simpan jawaban ke database
                ExamAttemptAnswer::create([
                    'exam_attempt_id' => $this->attempt->id,
                    'question_id'     => $questionId,
                    'answer_id'       => $answerId ?: null,
                    'is_correct'      => $isCorrect,
                    'score'           => $isCorrect ? $questionScore : 0,
                ]);
            }
        }

        // hitung apakah lulus
        $threshold = $this->exam->threshold ?? 50;
        $percentage = $maxScore > 0 ? ($totalScore / $maxScore) * 100 : 0;
        $isPassed = $percentage >= $threshold;

        // update attempt
        $this->attempt->update([
            'finished_at'      => now(),
            'total_score'      => $totalScore,
            'max_score'        => $maxScore,
            'correct_count'    => $correctCount,
            'wrong_count'      => $wrongCount,
            'unanswered_count' => $unansweredCount,
            'is_passed'        => $isPassed,
        ]);

        $statusText = $isPassed ? 'Lulus' : 'Tidak Lulus';

        Notification::make()
            ->title("Ujian selesai! Status: {$statusText}")
            ->body("Skor: {$totalScore}/{$maxScore} | Benar: {$correctCount} | Salah: {$wrongCount}")
            ->color($isPassed ? 'success' : 'danger')
            ->icon($isPassed ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
            ->send();

        $this->redirect(ExamResource::getUrl());
    }
}
