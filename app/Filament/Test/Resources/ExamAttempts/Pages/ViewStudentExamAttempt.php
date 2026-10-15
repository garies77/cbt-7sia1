<?php

namespace App\Filament\Test\Resources\ExamAttempts\Pages;

use App\Filament\Test\Resources\ExamAttempts\ExamAttemptResource;
use App\Models\ExamAttempt;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ViewStudentExamAttempt extends ViewRecord
{
    protected static string $resource = ExamAttemptResource::class;

    protected static ?string $title = 'Detail Hasil Ujian';

    public function mount(int|string $record): void
    {
        parent::mount($record);

        // pastikan siswa hanya bisa lihat data miliknya
        $student = Auth::user()->student;
        if (! $student || $this->record->student_id !== $student->id) {
            abort(403);
        }
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Ringkasan
                Section::make('Ringkasan Hasil')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('exam.title')
                            ->label('Ujian'),
                        TextEntry::make('started_at')
                            ->label('Tanggal')
                            ->dateTime('d M Y, H:i:s'),
                        TextEntry::make('total_score')
                            ->label('Total Skor')
                            ->formatStateUsing(fn ($record) => "{$record->total_score}/{$record->max_score}")
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight('bold'),
                        IconEntry::make('is_passed')
                            ->label('Status')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle'),
                        TextEntry::make('correct_count')
                            ->label('Benar')
                            ->badge()
                            ->color('success'),
                        TextEntry::make('wrong_count')
                            ->label('Salah')
                            ->badge()
                            ->color('danger'),
                        TextEntry::make('unanswered_count')
                            ->label('Tidak Dijawab')
                            ->badge()
                            ->color('gray'),
                    ]),

                // Detail Per Soal
                Section::make('Rincian Jawaban')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->schema([
                        RepeatableEntry::make('attemptAnswers')
                            ->label('')
                            ->schema([
                                TextEntry::make('question.subject.name')
                                    ->label('Mata Pelajaran')
                                    ->badge()
                                    ->color('info'),
                                TextEntry::make('question.payload')
                                    ->label('Soal')
                                    ->html()
                                    ->columnSpanFull(),
                                TextEntry::make('answer.text')
                                    ->label('Jawaban Kamu')
                                    ->placeholder('Tidak dijawab')
                                    ->icon(fn ($record) => $record->answer_id
                                        ? ($record->is_correct ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                                        : 'heroicon-o-minus-circle')
                                    ->color(fn ($record) => $record->answer_id
                                        ? ($record->is_correct ? 'success' : 'danger')
                                        : 'gray'),
                                TextEntry::make('kunci_jawaban')
                                    ->label('Kunci Jawaban')
                                    ->state(function ($record) {
                                        $correct = $record->question->answers->firstWhere('is_correct', true);
                                        return $correct ? $correct->text : '-';
                                    })
                                    ->icon('heroicon-o-check')
                                    ->color('success'),
                                IconEntry::make('is_correct')
                                    ->label('Status')
                                    ->boolean(),
                            ])
                            ->columns(3),
                    ]),
            ]);
    }
}
