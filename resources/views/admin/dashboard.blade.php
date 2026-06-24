@extends('layouts.master')

@section('title', 'Admin Dashboard')

@push('styles')
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
        }

        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #1a3c5e;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .sidebar-brand span {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .65rem 1.25rem;
            color: rgba(255, 255, 255, .7);
            text-decoration: none;
            font-size: .9rem;
            transition: .2s;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255, 255, 255, .1);
            color: #fff;
        }

        .main-content {
            margin-left: 240px;
            padding: 2rem;
        }

        .topbar {
            background: #fff;
            padding: .9rem 1.5rem;
            border-radius: .5rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
            margin-bottom: 1.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ── Filter Bar ── */
        .filter-bar {
            background: #fff;
            border-radius: .6rem;
            padding: 1.1rem 1.5rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
            margin-bottom: 1.75rem;
        }

        .filter-bar .form-label {
            font-size: .75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #6c757d;
            margin-bottom: .3rem;
        }

        .period-btn {
            border: 1.5px solid #dee2e6;
            background: #fff;
            color: #495057;
            padding: .35rem .9rem;
            border-radius: .4rem;
            font-size: .85rem;
            cursor: pointer;
            transition: .15s;
        }

        .period-btn:hover {
            border-color: #1a3c5e;
            color: #1a3c5e;
        }

        .period-btn.active {
            background: #1a3c5e;
            border-color: #1a3c5e;
            color: #fff;
            font-weight: 600;
        }

        .filter-divider {
            width: 1px;
            background: #dee2e6;
            margin: 0 .5rem;
            align-self: stretch;
        }

        /* ── Cards ── */
        .card-stat {
            background: #fff;
            border-radius: .6rem;
            padding: 1.4rem 1.5rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
            border: none;
        }

        .card-stat .icon {
            width: 48px;
            height: 48px;
            border-radius: .5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .card-stat .value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a3c5e;
        }

        .card-stat .label {
            font-size: .8rem;
            color: #6c757d;
            margin-top: .2rem;
        }

        .card-stat .delta {
            font-size: .75rem;
            margin-top: .3rem;
        }

        /* ── Section cards ── */
        .section-card {
            background: #fff;
            border-radius: .6rem;
            padding: 1.5rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
            margin-bottom: 1.75rem;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1a3c5e;
            padding-bottom: .75rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .table {
            font-size: .875rem;
        }

        .table thead th {
            background: #1a3c5e;
            color: #fff;
            font-weight: 600;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            border: none;
            padding: .75rem 1rem;
        }

        .table tbody tr:hover {
            background: #f8f9ff;
        }

        .table td {
            padding: .7rem 1rem;
            vertical-align: middle;
            border-color: #f0f2f5;
        }

        .badge-rank {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
            font-weight: 700;
        }

        .rank-1 {
            background: #FFD700;
            color: #7a6000;
        }

        .rank-2 {
            background: #C0C0C0;
            color: #555;
        }

        .rank-3 {
            background: #CD7F32;
            color: #fff;
        }

        .rank-n {
            background: #e9ecef;
            color: #555;
        }

        .stars {
            color: #f4a820;
            font-size: .85rem;
        }

        .bar-wrap {
            height: 6px;
            border-radius: 3px;
            background: #e9ecef;
        }

        .bar-fill {
            height: 100%;
            border-radius: 3px;
            background: linear-gradient(90deg, #1a3c5e, #2e86c1);
        }

        .rev-bar {
            height: 8px;
            border-radius: 4px;
            background: #e9ecef;
            min-width: 80px;
        }

        .rev-fill {
            height: 100%;
            border-radius: 4px;
        }

        #customRange {
            display: none;
        }
    </style>
@endpush

@section('content')

    <div class="main-content">

        {{-- Topbar --}}
        <div class="topbar">
            <div>
                <h5 class="mb-0 fw-bold" style="color:#1a3c5e">Dashboard Laporan</h5>
                <small class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <small class="text-muted">
                    {{ $startDate->format('d M Y') }} – {{ $endDate->format('d M Y') }}
                </small>
                <span class="bg-success badge">● Live</span>
            </div>
        </div>

        {{-- ── FILTER BAR ──────────────────────────────────────────────────── --}}
        <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">
            <div class="filter-bar">
                <div class="d-flex flex-wrap align-items-end gap-3">

                    {{-- Period buttons --}}
                    <div>
                        <div class="form-label">Periode</div>
                        <div class="d-flex gap-1" id="periodBtns">
                            @foreach (['7' => '7 Hari', '30' => '30 Hari', '90' => '90 Hari', 'custom' => 'Custom'] as $val => $label)
                                <button type="button" class="period-btn {{ $period === $val ? 'active' : '' }}"
                                    data-period="{{ $val }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="period" id="periodInput" value="{{ $period }}">
                    </div>

                    {{-- Custom range (tampil jika period=custom) --}}
                    <div id="customRange" class="d-flex align-items-end gap-2">
                        <div>
                            <div class="form-label">Dari</div>
                            <input type="date" name="start_date" class="form-control form-control-sm"
                                value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                        </div>
                        <div>
                            <div class="form-label">Sampai</div>
                            <input type="date" name="end_date" class="form-control form-control-sm"
                                value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="filter-divider"></div>

                    {{-- Filter Kategori --}}
                    <div>
                        <div class="form-label">Kategori</div>
                        <select name="category_id" class="form-select-sm form-select" style="min-width:160px">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $categoryFilter == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Status --}}
                    <div>
                        <div class="form-label">Status Order</div>
                        <select name="status" class="form-select-sm form-select" style="min-width:150px">
                            <option value="all" {{ $statusFilter === 'all' || !$statusFilter ? 'selected' : '' }}>
                                Semua (non-cancelled)
                            </option>
                            @foreach ($statuses as $s)
                                <option value="{{ $s }}" {{ $statusFilter === $s ? 'selected' : '' }}>
                                    {{ ucfirst($s) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-divider"></div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="px-3 btn btn-primary btn-sm">
                            <i class="me-1 bi bi-funnel-fill"></i> Terapkan
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="px-3 btn-outline-secondary btn btn-sm">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>

                </div>

                {{-- Active filter badges --}}
                @if (request()->hasAny(['period', 'category_id', 'status', 'start_date', 'end_date']))
                    <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top">
                        <small class="align-self-center text-muted">Filter aktif:</small>

                        @if ($period !== '30')
                            <span class="rounded-pill badge" style="background:#e8f4fd; color:#1a6fad">
                                <i class="bi bi-calendar3"></i>
                                {{ $period === 'custom'
                                    ? $startDate->format('d M') . ' – ' . $endDate->format('d M Y')
                                    : $period . ' hari terakhir' }}
                            </span>
                        @endif

                        @if ($categoryFilter)
                            <span class="rounded-pill badge" style="background:#eafaf1; color:#1a7a4a">
                                <i class="bi bi-tag"></i>
                                {{ $categories->firstWhere('id', $categoryFilter)?->name }}
                            </span>
                        @endif

                        @if ($statusFilter && $statusFilter !== 'all')
                            <span class="rounded-pill badge" style="background:#fef9e7; color:#b7950b">
                                <i class="bi bi-circle-fill" style="font-size:.5rem"></i>
                                {{ ucfirst($statusFilter) }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </form>

        {{-- ── SUMMARY CARDS ───────────────────────────────────────────────── --}}
        <div class="mb-4 row g-3">
            @php
                $cards = [
                    [
                        'label' => 'Total Revenue',
                        'value' => 'Rp ' . number_format($summary['total_revenue'], 0, ',', '.'),
                        'icon' => 'bi-currency-dollar',
                        'bg' => '#e8f4fd',
                        'color' => '#1a6fad',
                    ],
                    [
                        'label' => 'Total Order',
                        'value' => number_format($summary['total_orders'], 0, ',', '.'),
                        'icon' => 'bi-cart-check',
                        'bg' => '#eafaf1',
                        'color' => '#1a7a4a',
                    ],
                    [
                        'label' => 'Produk Aktif',
                        'value' => number_format($summary['total_products'], 0, ',', '.'),
                        'icon' => 'bi-box-seam',
                        'bg' => '#fef9e7',
                        'color' => '#b7950b',
                    ],
                    [
                        'label' => 'User Bertransaksi',
                        'value' => number_format($summary['total_users'], 0, ',', '.'),
                        'icon' => 'bi-people-fill',
                        'bg' => '#fdf2f8',
                        'color' => '#8e44ad',
                    ],
                ];
            @endphp
            @foreach ($cards as $card)
                <div class="col-sm-6 col-xl-3">
                    <div class="d-flex align-items-center gap-3 card-stat">
                        <div class="icon" style="background:{{ $card['bg'] }};color:{{ $card['color'] }}">
                            <i class="bi {{ $card['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="value">{{ $card['value'] }}</div>
                            <div class="label">{{ $card['label'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── ROW 1: Top Produk + Revenue Kategori ───────────────────────── --}}
        <div class="row g-4">

            {{-- 1. Top 10 Produk --}}
            <div class="col-xl-7">
                <div class="section-card">
                    <div class="section-title">
                        <i class="text-warning bi bi-trophy-fill"></i>
                        Top 10 Produk Terlaris
                        @if ($categoryFilter)
                            <span class="ms-1 badge" style="background:#eafaf1;color:#1a7a4a;font-size:.7rem">
                                {{ $categories->firstWhere('id', $categoryFilter)?->name }}
                            </span>
                        @endif
                    </div>
                    @if ($topProducts->isEmpty())
                        <p class="py-4 text-muted text-center">Tidak ada data untuk filter ini.</p>
                    @else
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end">Revenue</th>
                                    <th>Bar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $maxQty = $topProducts->max('total_qty') ?: 1; @endphp
                                @foreach ($topProducts as $i => $p)
                                    <tr>
                                        <td>
                                            @php
                                                $rc = match ($i) {
                                                    0 => 'rank-1',
                                                    1 => 'rank-2',
                                                    2 => 'rank-3',
                                                    default => 'rank-n',
                                                };
                                            @endphp
                                            <span class="badge-rank {{ $rc }}">{{ $i + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold" style="color:#1a3c5e">{{ $p->name }}</div>
                                            <small class="text-muted">{{ $p->category_name }} · {{ $p->total_orders }}
                                                order</small>
                                        </td>
                                        <td class="text-end fw-semibold">{{ number_format($p->total_qty) }}</td>
                                        <td class="text-success text-end fw-semibold">
                                            Rp {{ number_format($p->total_revenue, 0, ',', '.') }}
                                        </td>
                                        <td style="width:90px">
                                            <div class="bar-wrap">
                                                <div class="bar-fill"
                                                    style="width:{{ round(($p->total_qty / $maxQty) * 100) }}%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            {{-- 2. Revenue per Kategori --}}
            <div class="col-xl-5">
                <div class="section-card">
                    <div class="section-title">
                        <i class="text-primary bi bi-pie-chart-fill"></i>
                        Revenue per Kategori
                        <span class="bg-primary ms-auto badge" style="font-size:.7rem">
                            {{ $period === 'custom' ? $startDate->format('d M') . ' – ' . $endDate->format('d M') : $period . ' Hari' }}
                        </span>
                    </div>
                    @if ($revenueByCategory->isEmpty())
                        <p class="py-4 text-muted text-center">Tidak ada data untuk filter ini.</p>
                    @else
                        @php
                            $maxRev = $revenueByCategory->max('total_revenue') ?: 1;
                            $totalRev = $revenueByCategory->sum('total_revenue');
                            $palette = ['#1a3c5e', '#2e86c1', '#117a65', '#b7950b', '#8e44ad', '#c0392b', '#d35400'];
                        @endphp
                        <div class="d-flex flex-column gap-3">
                            @foreach ($revenueByCategory as $i => $cat)
                                <div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fw-semibold"
                                            style="font-size:.875rem">{{ $cat->category_name }}</span>
                                        <span class="fw-semibold" style="color:{{ $palette[$i % 7] }}">
                                            Rp {{ number_format($cat->total_revenue, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="flex-grow-1 rev-bar">
                                            <div class="rev-fill"
                                                style="width:{{ round(($cat->total_revenue / $maxRev) * 100) }}%;
                                            background:{{ $palette[$i % 7] }}">
                                            </div>
                                        </div>
                                        <small class="text-muted" style="width:36px;text-align:right">
                                            {{ round(($cat->total_revenue / $totalRev) * 100) }}%
                                        </small>
                                    </div>
                                    <small class="text-muted">{{ number_format($cat->total_qty) }} item ·
                                        {{ $cat->total_orders }} order</small>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── ROW 2: Rating + User Aktif ─────────────────────────────────── --}}
        <div class="mt-0 row g-4">

            {{-- 3. Rating Produk --}}
            <div class="col-xl-5">
                <div class="section-card">
                    <div class="section-title">
                        <i class="text-warning bi bi-star-fill"></i> Rating Produk Teratas
                    </div>
                    @if ($productRatings->isEmpty())
                        <p class="py-4 text-muted text-center">Tidak ada data untuk filter ini.</p>
                    @else
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Rating</th>
                                    <th class="text-end">Reviews</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productRatings as $p)
                                    <tr>
                                        <td class="fw-semibold" style="color:#1a3c5e">{{ $p->name }}</td>
                                        <td><span class="bg-light text-dark badge">{{ $p->category_name }}</span></td>
                                        <td class="text-center">
                                            <div class="stars">
                                                @for ($s = 1; $s <= 5; $s++)
                                                    <i
                                                        class="bi bi-star{{ $s <= round($p->avg_rating) ? '-fill' : '' }}"></i>
                                                @endfor
                                            </div>
                                            <small class="fw-semibold">{{ number_format($p->avg_rating, 1) }}</small>
                                        </td>
                                        <td class="text-muted text-end">{{ number_format($p->total_reviews) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            {{-- 4. User Paling Aktif --}}
            <div class="col-xl-7">
                <div class="section-card">
                    <div class="section-title">
                        <i class="bi-person-fill-check text-success bi"></i> Top 10 User Paling Aktif
                    </div>
                    @if ($activeUsers->isEmpty())
                        <p class="py-4 text-muted text-center">Tidak ada data untuk filter ini.</p>
                    @else
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th class="text-center">Order</th>
                                    <th class="text-end">Total Belanja</th>
                                    <th class="text-end">Avg/Order</th>
                                    <th>Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activeUsers as $i => $u)
                                    <tr>
                                        <td>
                                            @php
                                                $rc = match ($i) {
                                                    0 => 'rank-1',
                                                    1 => 'rank-2',
                                                    2 => 'rank-3',
                                                    default => 'rank-n',
                                                };
                                            @endphp
                                            <span class="badge-rank {{ $rc }}">{{ $i + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold" style="color:#1a3c5e">{{ $u->name }}</div>
                                            <small class="text-muted">{{ $u->email }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="bg-primary rounded-pill badge">{{ $u->total_orders }}</span>
                                        </td>
                                        <td class="text-success text-end fw-semibold">
                                            Rp {{ number_format($u->total_spent, 0, ',', '.') }}
                                        </td>
                                        <td class="text-muted text-end">
                                            Rp {{ number_format($u->avg_order_value, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ \Carbon\Carbon::parse($u->last_order_at)->diffForHumans() }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>

        {{-- CHALLENGE BAB 4 - Analisis Sentimen Review & Statistik Kupon --}}

        {{-- Statistik Cards: Review & Sentimen --}}
        <div class="mt-4 mb-1 row g-3">
            @php
                $reviewCards = [
                    [
                        'label' => 'Total Review',
                        'value' => number_format($sentiment['total']),
                        'icon' => 'bi-chat-square-text-fill',
                        'bg' => '#e8f4fd',
                        'color' => '#1a6fad',
                    ],
                    [
                        'label' => 'Sentimen Positif',
                        'value' => number_format($sentiment['positive']),
                        'icon' => 'bi-emoji-smile-fill',
                        'bg' => '#eafaf1',
                        'color' => '#1a7a4a',
                    ],
                    [
                        'label' => 'Sentimen Netral',
                        'value' => number_format($sentiment['neutral']),
                        'icon' => 'bi-emoji-neutral-fill',
                        'bg' => '#fef9e7',
                        'color' => '#b7950b',
                    ],
                    [
                        'label' => 'Sentimen Negatif',
                        'value' => number_format($sentiment['negative']),
                        'icon' => 'bi-emoji-frown-fill',
                        'bg' => '#fdecea',
                        'color' => '#c0392b',
                    ],
                ];
            @endphp
            @foreach ($reviewCards as $card)
                <div class="col-sm-6 col-xl-3">
                    <div class="d-flex align-items-center gap-3 card-stat">
                        <div class="icon" style="background:{{ $card['bg'] }};color:{{ $card['color'] }}">
                            <i class="bi {{ $card['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="value">{{ $card['value'] }}</div>
                            <div class="label">{{ $card['label'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Statistik Cards: Kupon --}}
        <div class="mb-4 row g-3">
            @php
                $couponCards = [
                    [
                        'label' => 'Kupon Aktif',
                        'value' => number_format($couponStats['active']),
                        'icon' => 'bi-ticket-perforated-fill',
                        'bg' => '#eafaf1',
                        'color' => '#1a7a4a',
                    ],
                    [
                        'label' => 'Kupon Kadaluarsa',
                        'value' => number_format($couponStats['expired']),
                        'icon' => 'bi-ticket-detailed',
                        'bg' => '#fdecea',
                        'color' => '#c0392b',
                    ],
                    [
                        'label' => 'Total Penggunaan Kupon',
                        'value' => number_format($couponStats['total_usage']),
                        'icon' => 'bi-graph-up-arrow',
                        'bg' => '#fdf2f8',
                        'color' => '#8e44ad',
                    ],
                ];
            @endphp
            @foreach ($couponCards as $card)
                <div class="col-sm-6 col-xl-4">
                    <div class="d-flex align-items-center gap-3 card-stat">
                        <div class="icon" style="background:{{ $card['bg'] }};color:{{ $card['color'] }}">
                            <i class="bi {{ $card['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="value">{{ $card['value'] }}</div>
                            <div class="label">{{ $card['label'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pie Chart + Bar Chart + Persentase Sentimen --}}
        <div class="row g-4">

            {{-- Pie Chart Sentimen --}}
            <div class="col-xl-4">
                <div class="section-card">
                    <div class="section-title">
                        <i class="text-primary bi bi-pie-chart-fill"></i> Pie Chart Sentimen
                    </div>
                    <canvas id="sentimentPieChart" height="220"></canvas>
                </div>
            </div>

            {{-- Bar Chart Sentimen --}}
            <div class="col-xl-4">
                <div class="section-card">
                    <div class="section-title">
                        <i class="text-primary bi bi-bar-chart-fill"></i> Bar Chart Sentimen
                    </div>
                    <canvas id="sentimentBarChart" height="220"></canvas>
                </div>
            </div>

            {{-- Persentase Sentimen + Ringkasan --}}
            <div class="col-xl-4">
                <div class="section-card">
                    <div class="section-title">
                        <i class="text-primary bi bi-percent"></i> Persentase Sentimen
                    </div>

                    @if ($sentiment['total'] === 0)
                        <p class="py-4 text-muted text-center">Belum ada data review.</p>
                    @else
                        <div class="d-flex flex-column gap-3">
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-semibold">Positif</span>
                                    <span class="fw-semibold"
                                        style="color:#1a7a4a">{{ $sentiment['percentage']['positive'] }}%</span>
                                </div>
                                <div class="bar-wrap">
                                    <div class="bar-fill"
                                        style="width:{{ $sentiment['percentage']['positive'] }}%;background:#1a7a4a">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-semibold">Netral</span>
                                    <span class="fw-semibold"
                                        style="color:#b7950b">{{ $sentiment['percentage']['neutral'] }}%</span>
                                </div>
                                <div class="bar-wrap">
                                    <div class="bar-fill"
                                        style="width:{{ $sentiment['percentage']['neutral'] }}%;background:#b7950b"></div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-semibold">Negatif</span>
                                    <span class="fw-semibold"
                                        style="color:#c0392b">{{ $sentiment['percentage']['negative'] }}%</span>
                                </div>
                                <div class="bar-wrap">
                                    <div class="bar-fill"
                                        style="width:{{ $sentiment['percentage']['negative'] }}%;background:#c0392b">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Ringkasan Dashboard --}}
                        <div class="mt-3 pt-3 border-top">
                            <small class="text-muted">
                                Dari total <strong>{{ number_format($sentiment['total']) }}</strong> review,
                                mayoritas pelanggan kasih sentimen
                                <strong style="color:#1a7a4a">positif
                                    ({{ $sentiment['percentage']['positive'] }}%)</strong>.
                                Saat ini ada <strong style="color:#1a7a4a">{{ $couponStats['active'] }}</strong> kupon
                                aktif
                                dan <strong style="color:#c0392b">{{ $couponStats['expired'] }}</strong> kupon kadaluarsa,
                                dengan total <strong>{{ number_format($couponStats['total_usage']) }}</strong> kali
                                pemakaian.
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        </main>

        @push('scripts')

                {{-- CDN Chart.js - CHALLENGE BAB 4 --}}
                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

                <script>
                    // ── CHALLENGE BAB 4 - Pie & Bar Chart Analisis Sentimen ─────────────
                    const sentimentData = {
                        positive: {{ $sentiment['positive'] }},
                        neutral: {{ $sentiment['neutral'] }},
                        negative: {{ $sentiment['negative'] }},
                    };

                    // Pie Chart - distribusi sentimen dalam bentuk lingkaran
                    new Chart(document.getElementById('sentimentPieChart'), {
                        type: 'pie',
                        data: {
                            labels: ['Positif (4-5)', 'Netral (3)', 'Negatif (1-2)'],
                            datasets: [{
                                data: [sentimentData.positive, sentimentData.neutral, sentimentData.negative],
                                backgroundColor: ['#1a7a4a', '#b7950b', '#c0392b'],
                                borderWidth: 0,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });

                    // Bar Chart - perbandingan jumlah review tiap kategori sentimen
                    new Chart(document.getElementById('sentimentBarChart'), {
                        type: 'bar',
                        data: {
                            labels: ['Positif', 'Netral', 'Negatif'],
                            datasets: [{
                                label: 'Jumlah Review',
                                data: [sentimentData.positive, sentimentData.neutral, sentimentData.negative],
                                backgroundColor: ['#1a7a4a', '#b7950b', '#c0392b'],
                                borderRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                </script>

            <script>
                // ── Period button toggle ───────────────────────────────────────────────────
                document.querySelectorAll('.period-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');

                        const period = this.dataset.period;
                        document.getElementById('periodInput').value = period;
                        document.getElementById('customRange').style.display =
                            period === 'custom' ? 'flex' : 'none';

                        // Auto-submit untuk period non-custom
                        if (period !== 'custom') document.getElementById('filterForm').submit();
                    });
                });

                // Tampilkan custom range jika period=custom saat halaman load
                if (document.getElementById('periodInput').value === 'custom') {
                    document.getElementById('customRange').style.display = 'flex';
                }
            </script>
        @endpush
    @endsection
