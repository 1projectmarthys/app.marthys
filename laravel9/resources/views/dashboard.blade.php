@extends('layouts.app')

@push('styles')
<style>
    /* ── Page ──────────────────────────────────────── */
    .dash-wrap { padding: 28px 24px 64px; font-family: var(--font, 'DM Sans', sans-serif); }

    /* ── Welcome Banner ────────────────────────────── */
    .welcome-banner {
        background: linear-gradient(135deg, #0d1b2a 0%, #0e2044 55%, #1042b0 100%);
        border-radius: 16px;
        padding: 32px 36px;
        display: flex; align-items: center; justify-content: space-between;
        gap: 24px; flex-wrap: wrap;
        margin-bottom: 32px;
        position: relative; overflow: hidden;
    }
    .welcome-banner::before {
        content: '';
        position: absolute; inset: 0; pointer-events: none;
        background: radial-gradient(circle at 80% 50%, rgba(59,130,246,.15) 0%, transparent 55%);
    }
    .welcome-banner::after {
        content: '';
        position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #1042b0, #1a56db, #60a5fa);
    }
    /* noise texture */
    .welcome-banner .noise {
        position: absolute; inset: 0; pointer-events: none; opacity: .4;
        background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.04'/%3E%3C/svg%3E") repeat;
    }

    .welcome-left { position: relative; z-index: 1; }
    .welcome-eyebrow {
        font-size: 10.5px; font-weight: 700; letter-spacing: 2px;
        text-transform: uppercase; color: rgba(255,255,255,.40);
        margin-bottom: 7px;
    }
    .welcome-title {
        font-family: var(--disp, 'Fraunces', serif);
        font-size: clamp(20px, 2.5vw, 28px);
        font-weight: 600; color: #fff; line-height: 1.2; margin-bottom: 8px;
    }
    .welcome-title em { font-style: italic; font-weight: 300; color: #93c5fd; }
    .welcome-sub { font-size: 13.5px; color: rgba(255,255,255,.50); line-height: 1.6; }

    .welcome-right {
        position: relative; z-index: 1;
        display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
    }
    .stat-pill {
        display: flex; flex-direction: column; align-items: center;
        background: rgba(255,255,255,.09);
        border: 1px solid rgba(255,255,255,.13);
        border-radius: 12px; padding: 14px 22px; min-width: 88px; text-align: center;
    }
    .stat-pill .snum {
        font-family: var(--disp, 'Fraunces', serif);
        font-size: 26px; font-weight: 600; color: #fff; line-height: 1;
    }
    .stat-pill .slbl {
        font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
        text-transform: uppercase; color: rgba(255,255,255,.35); margin-top: 4px;
    }

    /* ── Section Label ──────────────────────────────── */
    .section-label {
        display: flex; align-items: center; gap: 10px;
        font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
        text-transform: uppercase; color: #94a3b8;
        margin-bottom: 18px;
    }
    .section-label::before, .section-label::after {
        content: ''; flex: 1; height: 1px; background: #e2e8f0;
    }

    /* ── Stat Cards ─────────────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 14px;
        margin-bottom: 36px;
    }
    .stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px 18px;
        box-shadow: 0 1px 4px rgba(0,0,0,.04);
        transition: transform .2s, box-shadow .2s;
        animation: cardIn .4s ease both;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,.07);
    }
    @keyframes cardIn {
        from { opacity:0; transform:translateY(10px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .stat-card:nth-child(1){animation-delay:.05s}
    .stat-card:nth-child(2){animation-delay:.10s}
    .stat-card:nth-child(3){animation-delay:.15s}
    .stat-card:nth-child(4){animation-delay:.20s}

    .stat-card-icon {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; margin-bottom: 14px;
    }
    .stat-card-label {
        font-size: 11.5px; font-weight: 600; color: #64748b;
        text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px;
    }
    .stat-card-value {
        font-family: var(--disp, 'Fraunces', serif);
        font-size: 32px; font-weight: 600; line-height: 1;
    }

    /* ── Menu Cards ─────────────────────────────────── */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
    }
    .menu-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px 20px 20px;
        display: flex; flex-direction: column; gap: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,.04), 0 4px 14px rgba(26,86,219,.05);
        transition: transform .22s, box-shadow .22s, border-color .22s;
        animation: cardIn .4s ease both;
        text-decoration: none;
        position: relative; overflow: hidden;
    }
    .menu-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 3px;
        border-radius: 16px 16px 0 0;
        background: var(--card-accent, #e2e8f0);
        transition: height .22s;
    }
    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0,0,0,.09), 0 20px 48px rgba(26,86,219,.12);
        border-color: #bfdbfe;
    }
    .menu-card:hover::before { height: 4px; }

    .menu-card:nth-child(1){animation-delay:.08s}
    .menu-card:nth-child(2){animation-delay:.13s}
    .menu-card:nth-child(3){animation-delay:.18s}

    .menu-card-head { display: flex; align-items: center; gap: 14px; }
    .menu-card-icon {
        width: 52px; height: 52px; border-radius: 14px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        transition: transform .22s, box-shadow .22s;
    }
    .menu-card:hover .menu-card-icon {
        transform: scale(1.08);
        box-shadow: 0 6px 18px rgba(0,0,0,.18);
    }

    .menu-card-title {
        font-size: 15px; font-weight: 700; color: #0f172a; line-height: 1.3;
    }
    .menu-card-desc {
        font-size: 12.5px; color: #64748b; line-height: 1.5;
    }

    .menu-card-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 7px;
        padding: 9px 16px; border-radius: 9px;
        font-size: 13px; font-weight: 600; color: #fff;
        border: none; cursor: pointer; text-decoration: none;
        transition: filter .2s, transform .15s;
    }
    .menu-card-btn:hover { filter: brightness(1.08); transform: translateY(-1px); color: #fff; }

    /* ── Color themes ── */
    /* Accounting – blue */
    .theme-blue  { --card-accent: #1a56db; }
    .theme-blue  .menu-card-icon { background: #eff6ff; color: #1a56db; }
    .theme-blue  .menu-card-btn  { background: linear-gradient(135deg, #1042b0, #1a56db); }

    /* Penagihan – emerald */
    .theme-green { --card-accent: #059669; }
    .theme-green .menu-card-icon { background: #f0fdf4; color: #059669; }
    .theme-green .menu-card-btn  { background: linear-gradient(135deg, #065f46, #059669); }

    /* Legal – violet */
    .theme-violet { --card-accent: #7c3aed; }
    .theme-violet .menu-card-icon { background: #f5f3ff; color: #7c3aed; }
    .theme-violet .menu-card-btn  { background: linear-gradient(135deg, #5b21b6, #7c3aed); }

    /* HRD – rose */
    .theme-rose  { --card-accent: #e11d48; }
    .theme-rose  .menu-card-icon { background: #fff1f2; color: #e11d48; }
    .theme-rose  .menu-card-btn  { background: linear-gradient(135deg, #9f1239, #e11d48); }

    /* Admin – slate */
    .theme-slate { --card-accent: #475569; }
    .theme-slate .menu-card-icon { background: #f1f5f9; color: #475569; }
    .theme-slate .menu-card-btn  { background: linear-gradient(135deg, #1e293b, #475569); }

    /* ── Responsive ─────────────────────────────────── */
    @media (max-width: 640px) {
        .welcome-banner { padding: 24px 20px; }
        .welcome-right  { display: none; }
        .menu-grid  { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

@section('content')
<div class="dash-wrap">

    {{-- ── Welcome Banner ──────────────────────────── --}}
    @php
        $hour  = (int) now()->format('G');
        $greet = $hour < 11 ? 'Selamat Pagi' : ($hour < 15 ? 'Selamat Siang' : ($hour < 18 ? 'Selamat Sore' : 'Selamat Malam'));
    @endphp

    <div class="welcome-banner">
        <div class="noise"></div>
        <div class="welcome-left">
            <div class="welcome-eyebrow">{{ $greet }}, {{ Auth::user()->role }}</div>
            <h1 class="welcome-title">Halo, <em>{{ Auth::user()->name }}</em></h1>
            <p class="welcome-sub">
                Selamat datang di Sistem Penagihan.<br>
                Pilih menu di bawah untuk memulai aktivitas Anda.
            </p>
        </div>
        <div class="welcome-right">
            <div class="stat-pill">
                <div class="snum">{{ now()->format('d') }}</div>
                <div class="slbl">{{ now()->format('M Y') }}</div>
            </div>
            <div class="stat-pill">
                <div class="snum" id="clock"></div>
                <div class="slbl">Waktu</div>
            </div>
        </div>
    </div>

    {{-- ── Stats Row ────────────────────────────────── --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-icon" style="background:#eff6ff;color:#1a56db">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <div class="stat-card-label">Total Pengajuan</div>
            <div class="stat-card-value" style="color:#1a56db">{{ $totalPengajuan ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:#f0fdf4;color:#059669">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-card-label">Total Penagihan</div>
            <div class="stat-card-value" style="color:#059669">{{ $totalPenagihan ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:#fefce8;color:#ca8a04">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-card-label">Menunggu Persetujuan</div>
            <div class="stat-card-value" style="color:#ca8a04">{{ $pendingApproval ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon" style="background:#f0f9ff;color:#0369a1">
                <i class="fas fa-circle-check"></i>
            </div>
            <div class="stat-card-label">Selesai Bulan Ini</div>
            <div class="stat-card-value" style="color:#0369a1">{{ $completedThisMonth ?? 0 }}</div>
        </div>
    </div>

    {{-- ── Menu Cards ───────────────────────────────── --}}
    <div class="section-label">Menu Tersedia</div>

    <div class="menu-grid">

        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'accounting')
        <div class="menu-card theme-blue">
            <div class="menu-card-head">
                <div class="menu-card-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <div class="menu-card-title">Pengajuan Pembayaran</div>
                </div>
            </div>
            <div class="menu-card-desc">
                Kelola pengajuan pembayaran, lacak status, dan proses persetujuan.
            </div>
            <a href="{{ route('pengajuan-pembayaran.index') }}" class="menu-card-btn">
                <i class="fas fa-arrow-right"></i> Lihat Pengajuan
            </a>
        </div>
        @endif

        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'purchasing')
        <div class="menu-card theme-green">
            <div class="menu-card-head">
                <div class="menu-card-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div>
                    <div class="menu-card-title">Master Penagihan</div>
                </div>
            </div>
            <div class="menu-card-desc">
                Kelola penagihan customer dan pantau status pembayaran secara real-time.
            </div>
            <a href="{{ route('masterpenagihan.index') }}" class="menu-card-btn">
                <i class="fas fa-arrow-right"></i> Lihat Penagihan
            </a>
        </div>
        @endif

        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'legal')
        <div class="menu-card theme-violet">
            <div class="menu-card-head">
                <div class="menu-card-icon">
                    <i class="fas fa-scale-balanced"></i>
                </div>
                <div>
                    <div class="menu-card-title">Anggaran Legal</div>
                </div>
            </div>
            <div class="menu-card-desc">
                Kelola pengajuan anggaran legal operasional maupun non-operasional.
            </div>
            <a href="{{ route('anggaranlegal.index') }}" class="menu-card-btn">
                <i class="fas fa-arrow-right"></i> Lihat Anggaran
            </a>
        </div>
        @endif

        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'hrd')
        <div class="menu-card theme-rose">
            <div class="menu-card-head">
                <div class="menu-card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="menu-card-title">HRD</div>
                </div>
            </div>
            <div class="menu-card-desc">
                Kelola data karyawan, anggaran operasional, dan anggaran non-operasional HRD.
            </div>
            <a href="{{ route('karyawan.index') }}" class="menu-card-btn">
                <i class="fas fa-arrow-right"></i> Lihat Karyawan
            </a>
        </div>
        @endif

        @if (Auth::user()->role === 'admin')
        <div class="menu-card theme-slate">
            <div class="menu-card-head">
                <div class="menu-card-icon">
                    <i class="fas fa-gear"></i>
                </div>
                <div>
                    <div class="menu-card-title">Admin Panel</div>
                </div>
            </div>
            <div class="menu-card-desc">
                Akses panel administrasi untuk pengaturan sistem dan manajemen pengguna.
            </div>
            <a href="/admin" class="menu-card-btn">
                <i class="fas fa-arrow-right"></i> Buka Admin Panel
            </a>
        </div>
        @endif

    </div>

</div>
<script>
function updateClock() {
    const now = new Date();

    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');

    document.getElementById('clock').textContent =
        `${hours}:${minutes}`;
}

updateClock(); // jalankan pertama kali
setInterval(updateClock, 1000); // update tiap detik
</script>
@endsection