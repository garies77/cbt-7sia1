<?php

namespace App\Filament\Resources\ExamAttempts\Tables;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExamAttemptsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('student.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('student.nis')
                    ->label('NIS')
                    ->searchable(),

                TextColumn::make('exam.title')
                    ->label('Ujian')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('started_at')
                    ->label('Tanggal Ujian')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                TextColumn::make('total_score')
                    ->label('Skor')
                    ->formatStateUsing(fn ($record) => "{$record->total_score}/{$record->max_score}")
                    ->sortable(),

                TextColumn::make('correct_count')
                    ->label('Benar')
                    ->badge()
                    ->color('success'),

                TextColumn::make('wrong_count')
                    ->label('Salah')
                    ->badge()
                    ->color('danger'),

                TextColumn::make('unanswered_count')
                    ->label('Kosong')
                    ->badge()
                    ->color('gray'),

                IconColumn::make('is_passed')
                    ->label('Lulus')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('exam_id')
                    ->label('Ujian')
                    ->relationship('exam', 'title'),

                SelectFilter::make('is_passed')
                    ->label('Status')
                    ->options([
                        '1' => 'Lulus',
                        '0' => 'Tidak Lulus',
                    ]),

                Filter::make('finished')
                    ->label('Sudah Selesai')
                    ->query(fn (Builder $query) => $query->whereNotNull('finished_at'))
                    ->default(),
            ]);
    }
}
