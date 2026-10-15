<?php

namespace App\Filament\Resources\Students\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExamAttemptsRelationManager extends RelationManager
{
    protected static string $relationship = 'examAttempts';

    protected static ?string $title = 'Histori Ujian Siswa';

    protected static ?string $modelLabel = 'Histori Ujian';

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('started_at', 'desc')
            ->columns([
                TextColumn::make('exam.title')
                    ->label('Ujian')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('started_at')
                    ->label('Tanggal')
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
            ]);
    }
}
