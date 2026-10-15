<?php

namespace App\Filament\Resources\ExamAttempts;

use App\Filament\Resources\ExamAttempts\Pages\ListExamAttempts;
use App\Filament\Resources\ExamAttempts\Pages\ViewExamAttempt;
use App\Filament\Resources\ExamAttempts\Tables\ExamAttemptsTable;
use App\Models\ExamAttempt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExamAttemptResource extends Resource
{
    protected static ?string $model = ExamAttempt::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $navigationLabel = 'Rekap Ujian';

    protected static ?string $modelLabel = 'Rekap Ujian';

    protected static ?string $pluralModelLabel = 'Rekap Ujian';

    public static function table(Table $table): Table
    {
        return ExamAttemptsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExamAttempts::route('/'),
            'view'  => ViewExamAttempt::route('/{record}'),
        ];
    }
}
