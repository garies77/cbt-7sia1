<x-filament-panels::page>
    <style>
        .sh-container {
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
            width: 100%;
        }

        /* Summary Stats Top Bar */
        .sh-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            width: 100%;
        }

        .sh-summary-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04);
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .sh-summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px -2px rgba(0, 0, 0, 0.08);
        }

        :is(.dark) .sh-summary-card {
            background: #111827;
            border-color: #374151;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
        }

        .sh-summary-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sh-summary-icon svg {
            width: 1.5rem;
            height: 1.5rem;
        }

        .sh-summary-info {
            display: flex;
            flex-direction: column;
        }

        .sh-summary-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        :is(.dark) .sh-summary-label {
            color: #9ca3af;
        }

        .sh-summary-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
            margin-top: 0.25rem;
        }

        :is(.dark) .sh-summary-value {
            color: #f9fafb;
        }

        /* Subjects Grid */
        .sh-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
            width: 100%;
        }

        .sh-subject-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sh-subject-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        :is(.dark) .sh-subject-card {
            background: #111827;
            border-color: #374151;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
        }

        :is(.dark) .sh-subject-card:hover {
            border-color: #4b5563;
            box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.4);
        }

        /* Card Header */
        .sh-card-header {
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(99, 102, 241, 0.02) 100%);
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        :is(.dark) .sh-card-header {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.15) 0%, rgba(99, 102, 241, 0.05) 100%);
            border-color: #1f2937;
        }

        .sh-card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e1b4b;
            margin: 0;
            text-transform: capitalize;
            line-height: 1.3;
        }

        :is(.dark) .sh-card-title {
            color: #e0e7ff;
        }

        .sh-card-subtitle {
            font-size: 0.8125rem;
            color: #64748b;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        :is(.dark) .sh-card-subtitle {
            color: #94a3b8;
        }

        /* Grade Badge */
        .sh-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            white-space: nowrap;
        }

        .sh-badge-excellent {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        :is(.dark) .sh-badge-excellent {
            background: rgba(22, 101, 52, 0.3);
            color: #86efac;
            border-color: rgba(34, 197, 94, 0.4);
        }

        .sh-badge-good {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }
        :is(.dark) .sh-badge-good {
            background: rgba(3, 105, 161, 0.3);
            color: #7dd3fc;
            border-color: rgba(56, 189, 248, 0.4);
        }

        .sh-badge-fair {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        :is(.dark) .sh-badge-fair {
            background: rgba(180, 83, 9, 0.3);
            color: #fcd34d;
            border-color: rgba(251, 191, 36, 0.4);
        }

        .sh-badge-poor {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        :is(.dark) .sh-badge-poor {
            background: rgba(185, 28, 28, 0.3);
            color: #fca5a5;
            border-color: rgba(248, 113, 113, 0.4);
        }

        /* Card Body */
        .sh-card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            flex-grow: 1;
        }

        /* Progress Bar Section */
        .sh-score-section {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .sh-score-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .sh-score-label {
            font-size: 0.8125rem;
            font-weight: 500;
            color: #64748b;
        }

        :is(.dark) .sh-score-label {
            color: #94a3b8;
        }

        .sh-score-value {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.025em;
        }

        .sh-score-track {
            width: 100%;
            height: 0.625rem;
            background: #f1f5f9;
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        :is(.dark) .sh-score-track {
            background: #1f2937;
        }

        .sh-score-bar {
            height: 100%;
            border-radius: 9999px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* 2x2 Mini Metrics Grid */
        .sh-mini-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .sh-mini-tile {
            padding: 0.875rem 1rem;
            border-radius: 0.875rem;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            transition: background-color 0.15s ease;
        }

        .sh-mini-label {
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .sh-mini-value {
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.2;
        }

        /* Tile Color Variants */
        .sh-tile-highest {
            background: #f0fdf4;
            border: 1px solid #dcfce7;
        }
        :is(.dark) .sh-tile-highest {
            background: rgba(20, 83, 45, 0.2);
            border-color: rgba(34, 197, 94, 0.2);
        }
        .sh-tile-highest .sh-mini-label { color: #16a34a; }
        .sh-tile-highest .sh-mini-value { color: #15803d; }
        :is(.dark) .sh-tile-highest .sh-mini-value { color: #86efac; }

        .sh-tile-lowest {
            background: #fff7ed;
            border: 1px solid #ffedd5;
        }
        :is(.dark) .sh-tile-lowest {
            background: rgba(124, 45, 18, 0.2);
            border-color: rgba(249, 115, 22, 0.2);
        }
        .sh-tile-lowest .sh-mini-label { color: #ea580c; }
        .sh-tile-lowest .sh-mini-value { color: #c2410c; }
        :is(.dark) .sh-tile-lowest .sh-mini-value { color: #fdba74; }

        .sh-tile-correct {
            background: #eff6ff;
            border: 1px solid #dbeafe;
        }
        :is(.dark) .sh-tile-correct {
            background: rgba(30, 58, 138, 0.2);
            border-color: rgba(59, 130, 246, 0.2);
        }
        .sh-tile-correct .sh-mini-label { color: #2563eb; }
        .sh-tile-correct .sh-mini-value { color: #1d4ed8; }
        :is(.dark) .sh-tile-correct .sh-mini-value { color: #93c5fd; }

        .sh-tile-wrong {
            background: #fef2f2;
            border: 1px solid #fee2e2;
        }
        :is(.dark) .sh-tile-wrong {
            background: rgba(127, 29, 29, 0.2);
            border-color: rgba(239, 68, 68, 0.2);
        }
        .sh-tile-wrong .sh-mini-label { color: #dc2626; }
        .sh-tile-wrong .sh-mini-value { color: #b91c1c; }
        :is(.dark) .sh-tile-wrong .sh-mini-value { color: #fca5a5; }

        /* Card Footer */
        .sh-card-footer {
            padding: 1rem 1.5rem;
            background: #fafafa;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: #64748b;
        }

        :is(.dark) .sh-card-footer {
            background: #0f172a;
            border-color: #1f2937;
            color: #94a3b8;
        }

        .sh-footer-link {
            color: #4f46e5;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: color 0.15s ease;
        }

        .sh-footer-link:hover {
            color: #4338ca;
            text-decoration: underline;
        }

        :is(.dark) .sh-footer-link {
            color: #818cf8;
        }

        :is(.dark) .sh-footer-link:hover {
            color: #a5b4fc;
        }

        /* Empty State */
        .sh-empty-card {
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 1.5rem;
            padding: 4rem 2rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 32rem;
            margin: 2rem auto;
        }

        :is(.dark) .sh-empty-card {
            background: #111827;
            border-color: #374151;
        }

        .sh-empty-icon-wrap {
            width: 4.5rem;
            height: 4.5rem;
            border-radius: 1.25rem;
            background: #f1f5f9;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        :is(.dark) .sh-empty-icon-wrap {
            background: #1f2937;
            color: #94a3b8;
        }
    </style>

    <div class="sh-container">
        @if($subjectStats->isEmpty())
            <div class="sh-empty-card">
                <div class="sh-empty-icon-wrap">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width: 2.25rem; height: 2.25rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem 0;">Belum Ada Histori Pelajaran</h3>
                <p style="font-size: 0.875rem; color: #64748b; margin: 0 0 1.5rem 0; line-height: 1.5;">
                    Anda belum menyelesaikan ujian apapun. Silakan kerjakan sesi ujian yang tersedia untuk mulai melihat rekam jejak nilai dan materi pelajaran Anda.
                </p>
                <a href="{{ route('filament.test.resources.exams.index') }}"
                   style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: #4f46e5; color: #ffffff; border-radius: 0.75rem; font-size: 0.875rem; font-weight: 600; text-decoration: none; transition: background-color 0.15s ease;">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 1.125rem; height: 1.125rem;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                    Lihat Sesi Ujian
                </a>
            </div>
        @else
            {{-- Top KPI Summary Banner --}}
            <div class="sh-summary-grid">
                {{-- Total Pelajaran --}}
                <div class="sh-summary-card">
                    <div class="sh-summary-icon" style="background: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="sh-summary-info">
                        <span class="sh-summary-label">Mata Pelajaran</span>
                        <span class="sh-summary-value">{{ $overallStats['total_subjects'] }} <span style="font-size: 0.875rem; font-weight: 500; color: #64748b;">Materi</span></span>
                    </div>
                </div>

                {{-- Total Ujian --}}
                <div class="sh-summary-card">
                    <div class="sh-summary-icon" style="background: rgba(14, 165, 233, 0.1); color: #0284c7;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    <div class="sh-summary-info">
                        <span class="sh-summary-label">Ujian Dikerjakan</span>
                        <span class="sh-summary-value">{{ $overallStats['total_exams'] }} <span style="font-size: 0.875rem; font-weight: 500; color: #64748b;">Kali</span></span>
                    </div>
                </div>

                {{-- Rata-rata Skor --}}
                <div class="sh-summary-card">
                    <div class="sh-summary-icon" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                        </svg>
                    </div>
                    <div class="sh-summary-info">
                        <span class="sh-summary-label">Rata-rata Nilai</span>
                        <span class="sh-summary-value" style="color: {{ $overallStats['overall_avg'] >= 70 ? '#10b981' : ($overallStats['overall_avg'] >= 50 ? '#f59e0b' : '#ef4444') }};">
                            {{ $overallStats['overall_avg'] }}%
                        </span>
                    </div>
                </div>

                {{-- Akurasi Jawaban --}}
                <div class="sh-summary-card">
                    <div class="sh-summary-icon" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="sh-summary-info">
                        <span class="sh-summary-label">Akurasi Jawaban</span>
                        <span class="sh-summary-value">{{ $overallStats['accuracy'] }}%</span>
                    </div>
                </div>
            </div>

            {{-- Grid Kartu Mata Pelajaran --}}
            <div class="sh-cards-grid">
                @foreach($subjectStats as $subject)
                    @php
                        $scoreColor = $subject['avg_score'] >= 75 ? '#10b981' : ($subject['avg_score'] >= 55 ? '#f59e0b' : '#ef4444');
                        $gradientBar = $subject['avg_score'] >= 75
                            ? 'linear-gradient(90deg, #10b981 0%, #059669 100%)'
                            : ($subject['avg_score'] >= 55
                                ? 'linear-gradient(90deg, #f59e0b 0%, #d97706 100%)'
                                : 'linear-gradient(90deg, #ef4444 0%, #dc2626 100%)');
                    @endphp

                    <div class="sh-subject-card">
                        {{-- Header Card --}}
                        <div class="sh-card-header">
                            <div>
                                <h3 class="sh-card-title">{{ $subject['name'] }}</h3>
                                <div class="sh-card-subtitle">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 0.875rem; height: 0.875rem;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                    </svg>
                                    <span>{{ $subject['exam_count'] }} kali ujian</span>
                                </div>
                            </div>
                            <span class="sh-badge sh-badge-{{ $subject['grade_type'] }}">
                                {{ $subject['grade'] }}
                            </span>
                        </div>

                        {{-- Body Card --}}
                        <div class="sh-card-body">
                            {{-- Average Score Progress Bar --}}
                            <div class="sh-score-section">
                                <div class="sh-score-header">
                                    <span class="sh-score-label">Rata-rata Skor</span>
                                    <span class="sh-score-value" style="color: {{ $scoreColor }};">
                                        {{ $subject['avg_score'] }}%
                                    </span>
                                </div>
                                <div class="sh-score-track">
                                    <div class="sh-score-bar" style="width: {{ min($subject['avg_score'], 100) }}%; background: {{ $gradientBar }};"></div>
                                </div>
                            </div>

                            {{-- 2x2 Mini Metrics Grid --}}
                            <div class="sh-mini-grid">
                                {{-- Skor Tertinggi --}}
                                <div class="sh-mini-tile sh-tile-highest">
                                    <div class="sh-mini-label">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 0.875rem; height: 0.875rem;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                        </svg>
                                        <span>Tertinggi</span>
                                    </div>
                                    <div class="sh-mini-value">{{ $subject['highest_score'] }}%</div>
                                </div>

                                {{-- Skor Terendah --}}
                                <div class="sh-mini-tile sh-tile-lowest">
                                    <div class="sh-mini-label">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 0.875rem; height: 0.875rem;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                        <span>Terendah</span>
                                    </div>
                                    <div class="sh-mini-value">{{ $subject['lowest_score'] }}%</div>
                                </div>

                                {{-- Jawaban Benar --}}
                                <div class="sh-mini-tile sh-tile-correct">
                                    <div class="sh-mini-label">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 0.875rem; height: 0.875rem;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                        <span>Benar</span>
                                    </div>
                                    <div class="sh-mini-value">{{ $subject['total_correct'] }} <span style="font-size: 0.75rem; font-weight: 500; opacity: 0.8;">soal</span></div>
                                </div>

                                {{-- Jawaban Salah --}}
                                <div class="sh-mini-tile sh-tile-wrong">
                                    <div class="sh-mini-label">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 0.875rem; height: 0.875rem;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                        <span>Salah</span>
                                    </div>
                                    <div class="sh-mini-value">{{ $subject['total_wrong'] }} <span style="font-size: 0.75rem; font-weight: 500; opacity: 0.8;">soal</span></div>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Card --}}
                        <div class="sh-card-footer">
                            <div style="display: flex; align-items: center; gap: 0.35rem;">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 0.875rem; height: 0.875rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span>Terakhir: {{ $subject['last_date'] ?? '-' }}</span>
                            </div>
                            <a href="{{ route('filament.test.resources.exam-attempts.index') }}" class="sh-footer-link">
                                <span>Riwayat Ujian</span>
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width: 0.75rem; height: 0.75rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-filament-panels::page>
