<?php

namespace App\Filament\Test\Pages;

use App\Models\ExamAttempt;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SubjectHistory extends Page
{
    protected string $view = 'filament.test.pages.subject-history';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $navigationLabel = 'Histori Pelajaran';

    protected static ?string $title = 'Histori Pelajaran';

    public Collection $subjectStats;

    public array $overallStats = [];

    public function mount(): void
    {
        $student = Auth::user()?->student;

        if (! $student) {
            $this->subjectStats = collect();
            $this->overallStats = [
                'total_subjects' => 0,
                'total_exams'    => 0,
                'overall_avg'    => 0,
                'total_correct'  => 0,
                'total_wrong'    => 0,
                'accuracy'       => 0,
            ];
            return;
        }

        // ambil semua attempt siswa yang sudah selesai
        $attempts = ExamAttempt::where('student_id', $student->id)
            ->whereNotNull('finished_at')
            ->with(['exam.subjects', 'attemptAnswers.question.subject'])
            ->get();

        // kelompokkan per mata pelajaran
        $subjectData = [];

        foreach ($attempts as $attempt) {
            foreach ($attempt->attemptAnswers as $attemptAnswer) {
                $subject = $attemptAnswer->question?->subject;
                if (! $subject) {
                    continue;
                }

                $subjectId = $subject->id;

                if (! isset($subjectData[$subjectId])) {
                    $subjectData[$subjectId] = [
                        'name'        => $subject->name,
                        'total_exams' => [],
                        'total_score' => 0,
                        'max_score'   => 0,
                        'correct'     => 0,
                        'wrong'       => 0,
                        'scores'      => [],
                        'last_date'   => null,
                    ];
                }

                // track unique exams
                $subjectData[$subjectId]['total_exams'][$attempt->exam_id] = true;

                $subjectData[$subjectId]['total_score'] += $attemptAnswer->score;
                $subjectData[$subjectId]['max_score'] += $attemptAnswer->question->score ?? 1;

                if ($attemptAnswer->is_correct) {
                    $subjectData[$subjectId]['correct']++;
                } else {
                    $subjectData[$subjectId]['wrong']++;
                }

                // track scores per attempt for min/max percentage
                $attemptKey = $attempt->id . '_' . $subjectId;
                if (! isset($subjectData[$subjectId]['scores'][$attemptKey])) {
                    $subjectData[$subjectId]['scores'][$attemptKey] = [
                        'score' => 0,
                        'max'   => 0,
                    ];
                }
                $subjectData[$subjectId]['scores'][$attemptKey]['score'] += $attemptAnswer->score;
                $subjectData[$subjectId]['scores'][$attemptKey]['max'] += ($attemptAnswer->question->score ?? 1);

                // track last date
                $attemptDate = $attempt->finished_at;
                if (! $subjectData[$subjectId]['last_date'] || $attemptDate->gt($subjectData[$subjectId]['last_date'])) {
                    $subjectData[$subjectId]['last_date'] = $attemptDate;
                }
            }
        }

        // format data
        $this->subjectStats = collect($subjectData)->map(function ($data) {
            $scores = array_map(function ($s) {
                return $s['max'] > 0 ? round(($s['score'] / $s['max']) * 100, 1) : 0;
            }, array_values($data['scores']));

            $totalQuestions = $data['correct'] + $data['wrong'];
            $avgPercentage = $data['max_score'] > 0
                ? round(($data['total_score'] / $data['max_score']) * 100, 1)
                : 0;

            // predikat
            if ($avgPercentage >= 85) {
                $grade = 'Sangat Baik';
                $gradeType = 'excellent';
            } elseif ($avgPercentage >= 70) {
                $grade = 'Baik';
                $gradeType = 'good';
            } elseif ($avgPercentage >= 55) {
                $grade = 'Cukup';
                $gradeType = 'fair';
            } else {
                $grade = 'Perlu Remedial';
                $gradeType = 'poor';
            }

            return [
                'name'            => $data['name'],
                'exam_count'      => count($data['total_exams']),
                'avg_score'       => $avgPercentage,
                'grade'           => $grade,
                'grade_type'      => $gradeType,
                'highest_score'   => count($scores) > 0 ? max($scores) : 0,
                'lowest_score'    => count($scores) > 0 ? min($scores) : 0,
                'total_correct'   => $data['correct'],
                'total_wrong'     => $data['wrong'],
                'total_questions' => $totalQuestions,
                'last_date'       => $data['last_date']?->format('d M Y, H:i'),
            ];
        })->sortBy('name')->values();

        $totalQuestions = $this->subjectStats->sum('total_questions');
        $totalCorrect = $this->subjectStats->sum('total_correct');

        $this->overallStats = [
            'total_subjects' => $this->subjectStats->count(),
            'total_exams'    => $this->subjectStats->sum('exam_count'),
            'overall_avg'    => $this->subjectStats->count() > 0 ? round($this->subjectStats->avg('avg_score'), 1) : 0,
            'total_correct'  => $totalCorrect,
            'total_wrong'    => $this->subjectStats->sum('total_wrong'),
            'accuracy'       => $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100, 1) : 0,
        ];
    }
}
