<x-filament-panels::page>
    <style>
        .exam-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            width: 100%;
        }

        .exam-subject-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        :is(.dark) .exam-subject-card {
            background: #111827;
            border-color: #374151;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .exam-subject-header {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.08) 0%, rgba(99, 102, 241, 0.03) 100%);
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid #e5e7eb;
        }

        :is(.dark) .exam-subject-header {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, rgba(99, 102, 241, 0.08) 100%);
            border-color: #374151;
        }

        .exam-subject-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #4338ca;
            margin: 0;
            letter-spacing: -0.01em;
        }

        :is(.dark) .exam-subject-title {
            color: #a5b4fc;
        }

        .exam-question-list {
            display: flex;
            flex-direction: column;
        }

        .exam-question-row {
            padding: 1.5rem 1.75rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .exam-question-row:last-child {
            border-bottom: none;
        }

        :is(.dark) .exam-question-row {
            border-color: #1f2937;
        }

        .exam-question-header {
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            margin-bottom: 1.25rem;
        }

        .exam-question-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            background: #eef2ff;
            color: #4f46e5;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        :is(.dark) .exam-question-badge {
            background: rgba(79, 70, 229, 0.25);
            color: #a5b4fc;
        }

        .exam-question-text {
            font-size: 0.9375rem;
            color: #1f2937;
            line-height: 1.6;
            flex-grow: 1;
        }

        :is(.dark) .exam-question-text {
            color: #e5e7eb;
        }

        .exam-options-list {
            margin-left: 2.875rem;
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
        }

        @media (max-width: 640px) {
            .exam-options-list {
                margin-left: 0;
            }
        }

        .exam-option-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: all 0.15s ease;
            background: #ffffff;
        }

        :is(.dark) .exam-option-item {
            background: #111827;
            border-color: #374151;
            color: #e5e7eb;
        }

        .exam-option-item:hover {
            border-color: #6366f1;
            background: #f8fafc;
        }

        :is(.dark) .exam-option-item:hover {
            border-color: #818cf8;
            background: #1e293b;
        }

        .exam-option-item.is-selected {
            border-color: #4f46e5;
            background: #eef2ff;
            box-shadow: 0 0 0 1px #4f46e5;
        }

        :is(.dark) .exam-option-item.is-selected {
            border-color: #818cf8;
            background: rgba(79, 70, 229, 0.2);
            box-shadow: 0 0 0 1px #818cf8;
        }

        .exam-radio-input {
            width: 1.125rem;
            height: 1.125rem;
            accent-color: #4f46e5;
            cursor: pointer;
        }

        .exam-option-text {
            font-size: 0.875rem;
            color: #374151;
            flex-grow: 1;
        }

        :is(.dark) .exam-option-text {
            color: #d1d5db;
        }

        .exam-submit-bar {
            margin-top: 2rem;
            display: flex;
            justify-content: flex-end;
            padding-bottom: 2rem;
        }
    </style>

    <form wire:submit="submit">
        <div class="exam-container">
            @foreach ($collections as $pelajaranIdx => $pelajaran)
                <div class="exam-subject-card">
                    {{-- Header Mata Pelajaran --}}
                    <div class="exam-subject-header">
                        <h2 class="exam-subject-title">
                            {{ chr(65 + $pelajaranIdx) }}. {{ $pelajaran['name'] }}
                        </h2>
                    </div>

                    {{-- Daftar Soal --}}
                    <div class="exam-question-list">
                        @foreach ($pelajaran['soals'] as $soalIdx => $pertanyaan)
                            <div class="exam-question-row">
                                {{-- Soal --}}
                                <div class="exam-question-header">
                                    <span class="exam-question-badge">
                                        {{ $soalIdx + 1 }}
                                    </span>
                                    <div class="exam-question-text">
                                        {!! $pertanyaan['payload'] !!}
                                    </div>
                                </div>

                                {{-- Pilihan Jawaban --}}
                                <div class="exam-options-list">
                                    @foreach ($pertanyaan['answers'] as $jawaban)
                                        @php
                                            $isSelected = isset($this->jawaban[$pertanyaan['id']]) && (string) $this->jawaban[$pertanyaan['id']] === (string) $jawaban['id'];
                                        @endphp
                                        <label class="exam-option-item {{ $isSelected ? 'is-selected' : '' }}">
                                            <input
                                                type="radio"
                                                name="jawaban_{{ $pertanyaan['id'] }}"
                                                value="{{ $jawaban['id'] }}"
                                                wire:model.live="jawaban.{{ $pertanyaan['id'] }}"
                                                class="exam-radio-input"
                                            />
                                            <span class="exam-option-text">
                                                {{ $jawaban['text'] }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tombol Submit --}}
        <div class="exam-submit-bar">
            <x-filament::button
                type="submit"
                size="lg"
                icon="heroicon-o-paper-airplane"
                wire:confirm="Apakah kamu yakin ingin mengirim jawaban? Jawaban tidak dapat diubah setelah dikirim."
            >
                Kirim Jawaban
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
