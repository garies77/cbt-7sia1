<?php

namespace App\Filament\Test\Resources\ExamAttempts;

use App\Filament\Test\Resources\ExamAttempts\Pages\ListStudentExamAttempts;
use App\Filament\Test\Resources\ExamAttempts\Pages\ViewStudentExamAttempt;
use App\Models\ExamAttempt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ExamAttemptResource extends Resource
{
    protected static ?string $model = ExamAttempt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?string $navigationLabel = 'Histori Ujian';

    protected static ?string $modelLabel = 'Histori Ujian';

    protected static ?string $pluralModelLabel = 'Histori Ujian';

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // hanya tampilkan ujian milik siswa yang login
                $student = Auth::user()->student;
                if ($student) {
                    $query->where('student_id', $student->id)
                        ->whereNotNull('finished_at');
                } else {
                    $query->whereRaw('1 = 0');
                }
            })
            ->defaultSort('finished_at', 'desc')
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

                IconColumn::make('is_passed')
                    ->label('Lulus')
                    ->boolean()
                    ->sortable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentExamAttempts::route('/'),
            'view'  => ViewStudentExamAttempt::route('/{record}'),
        ];
    }
}
