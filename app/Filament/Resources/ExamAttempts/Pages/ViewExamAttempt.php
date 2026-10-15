<?php

namespace App\Filament\Resources\ExamAttempts\Pages;

use App\Filament\Resources\ExamAttempts\ExamAttemptResource;
use App\Models\ExamAttempt;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewExamAttempt extends ViewRecord
{
    protected static string $resource = ExamAttemptResource::class;

    protected static ?string $title = 'Detail Hasil Ujian';

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Info Umum
                Section::make('Informasi Umum')
                    ->icon('heroicon-o-user')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('student.name')
                            ->label('Nama Siswa'),
                        TextEntry::make('student.nis')
                            ->label('NIS'),
                        TextEntry::make('exam.title')
                            ->label('Ujian'),
                        TextEntry::make('started_at')
                            ->label('Mulai')
                            ->dateTime('d M Y, H:i:s'),
                        TextEntry::make('finished_at')
                            ->label('Selesai')
                            ->dateTime('d M Y, H:i:s'),
                        TextEntry::make('durasi')
                            ->label('Durasi Pengerjaan')
                            ->state(function (ExamAttempt $record) {
                                if (! $record->finished_at) {
                                    return 'Belum selesai';
                                }
                                $diff = $record->started_at->diff($record->finished_at);
                                return $diff->format('%H:%I:%S');
                            }),
                    ]),

                // Ringkasan Skor
                Section::make('Ringkasan Skor')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('total_score')
                            ->label('Total Skor')
                            ->formatStateUsing(fn ($record) => "{$record->total_score}/{$record->max_score}")
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight('bold'),
                        TextEntry::make('correct_count')
                            ->label('Jawaban Benar')
                            ->badge()
                            ->color('success'),
                        TextEntry::make('wrong_count')
                            ->label('Jawaban Salah')
                            ->badge()
                            ->color('danger'),
                        TextEntry::make('unanswered_count')
                            ->label('Tidak Dijawab')
                            ->badge()
                            ->color('gray'),
                        IconEntry::make('is_passed')
                            ->label('Status Kelulusan')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle'),
                    ]),

                // Detail Jawaban
                Section::make('Detail Jawaban Per Soal')
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
                                    ->label('Jawaban Siswa')
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
                                TextEntry::make('score')
                                    ->label('Skor'),
                            ])
                            ->columns(3),
                    ]),
            ]);
    }
}
