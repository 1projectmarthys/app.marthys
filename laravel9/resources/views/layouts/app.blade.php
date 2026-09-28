<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Penagihan') }}</title>

    <!-- Fonts: Fraunces (display) + DM Sans (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        disp: ['Fraunces', 'serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#1a56db',
                            600: '#1042b0',
                            700: '#0e2044',
                            800: '#0d1b2a',
                            900: '#060e18',
                        },
                    },
                },
            },
        }
    </script>

    <style>
        :root {
            --font:    'DM Sans', sans-serif;
            --disp:    'Fraunces', serif;
            --blue:    #1a56db;
            --blue-d:  #1042b0;
            --blue-p:  #eff6ff;
            --dark:    #0d1b2a;
            --border:  #e2e8f0;
            --text:    #0f172a;
            --text-2:  #475569;
            --ease:    .22s cubic-bezier(.4,0,.2,1);
            --sb-w:    256px;
            --sb-cw:   64px;
        }

        [x-cloak] { display: none !important; }

        *, *::before, *::after { box-sizing: border-box; }

        html {
            font-family: var(--font);
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }

        body {
            background: #f1f5f9;
            color: var(--text);
            margin: 0;
            overflow-x: hidden;
        }

        /* ── FORM CONTROLS ───────────────────────────── */
        /* Class .form-input/.form-select/.form-textarea dipakai di seluruh
           halaman create & edit, tapi belum pernah didefinisikan. Tailwind
           dimuat via CDN tanpa plugin tailwindcss/forms, sehingga semua
           input tampil tanpa border & tanpa lebar. Definisi di bawah ini
           memperbaiki seluruh form sekaligus. */
        .form-input,
        .form-select,
        .form-textarea,
        input[type="text"]:not([class*="px-"]),
        input[type="number"]:not([class*="px-"]),
        input[type="date"]:not([class*="px-"]),
        input[type="email"]:not([class*="px-"]),
        input[type="password"]:not([class*="px-"]) {
            display: block;
            width: 100%;
            padding: 8px 12px;
            font-family: var(--font);
            font-size: 13.5px;
            line-height: 1.45;
            color: var(--text);
            background-color: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, .04);
            transition: border-color var(--ease), box-shadow var(--ease), background-color var(--ease);
            appearance: none;
        }

        .form-select {
            padding-right: 34px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.6' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 18px 18px;
            cursor: pointer;
        }

        .form-textarea,
        textarea.form-input {
            min-height: 76px;
            resize: vertical;
        }

        .form-input:hover,
        .form-select:hover,
        .form-textarea:hover { border-color: #cbd5e1; }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, .14);
        }

        .form-input::placeholder,
        .form-textarea::placeholder { color: #94a3b8; }

        .form-input[readonly],
        .form-input:disabled,
        .form-select:disabled {
            background-color: #f8fafc;
            color: var(--text-2);
            cursor: not-allowed;
            box-shadow: none;
        }

        /* Input file */
        input[type="file"].form-input {
            padding: 6px 10px;
            font-size: 13px;
            color: var(--text-2);
            cursor: pointer;
        }
        input[type="file"].form-input::file-selector-button {
            margin-right: 10px;
            padding: 6px 12px;
            font-family: var(--font);
            font-size: 12.5px;
            font-weight: 500;
            color: var(--text-2);
            background: #f1f5f9;
            border: 1px solid var(--border);
            border-radius: 6px;
            cursor: pointer;
            transition: background-color var(--ease);
        }
        input[type="file"].form-input::file-selector-button:hover { background: #e2e8f0; }

        /* Label + wrapper .mt-1 warisan -> jangan dobel jarak */
        label + div.mt-1 { margin-top: 0; }

        /* Input di dalam tabel detail: rapat & tanpa bayangan ganda */
        table .form-input,
        table .form-select,
        table .form-textarea {
            font-size: 13px;
            padding: 7px 10px;
            box-shadow: none;
        }

        /* State error validasi */
        .form-input.border-red-300,
        .form-select.border-red-300,
        .form-textarea.border-red-300 { border-color: #fca5a5; }
        .form-input.border-red-300:focus,
        .form-select.border-red-300:focus,
        .form-textarea.border-red-300:focus {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, .14);
        }

        /* ── TABEL DETAIL (create / edit) ─────────────── */
        #detail_table { border-collapse: separate; border-spacing: 0; }
        #detail_table thead th {
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
            font-size: 11px;
            letter-spacing: .04em;
        }
        #detail_table tbody tr { transition: background-color var(--ease); }
        #detail_table tbody tr:hover { background-color: #f8fafc; }
        #detail_table tbody td { vertical-align: middle; }

        /* ── SCROLLBAR ───────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 99px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* ── SIDEBAR ─────────────────────────────────── */
        #sidebar {
            position: fixed; inset-y: 0; left: 0; z-index: 40;
            width: var(--sb-w);
            display: flex; flex-direction: column;
            background: linear-gradient(180deg, var(--dark) 0%, #0e2044 55%, #102257 100%);
            transition: width var(--ease);
            overflow: hidden;
            border-right: 1px solid rgba(255,255,255,.06);
        }
        #sidebar.collapsed { width: var(--sb-cw); }

        /* noise overlay for depth */
        #sidebar::before {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='.03'/%3E%3C/svg%3E") repeat;
            opacity: .4;
        }

        /* right-edge accent line */
        #sidebar::after {
            content: '';
            position: absolute; top: 0; right: 0; bottom: 0; width: 2px;
            background: linear-gradient(180deg, transparent, var(--blue) 40%, transparent);
            opacity: 0; transition: opacity var(--ease);
        }
        #sidebar:hover::after { opacity: .6; }

        /* ── Sidebar Header ──────────────────────────── */
        .sb-header {
            display: flex; align-items: center; justify-content: space-between;
            height: 64px; padding: 0 16px; flex-shrink: 0;
            border-bottom: 1px solid rgba(255,255,255,.07);
            position: relative; z-index: 1;
        }
        .sb-logo {
            font-family: var(--disp);
            font-size: 17px; font-weight: 600; font-style: italic;
            color: #fff; white-space: nowrap; overflow: hidden;
            opacity: 1; transition: opacity var(--ease);
        }
        #sidebar.collapsed .sb-logo { opacity: 0; pointer-events: none; }

        .sb-toggle {
            flex-shrink: 0; width: 32px; height: 32px; border-radius: 8px;
            background: rgba(255,255,255,.08); border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.7); transition: background var(--ease), color var(--ease);
        }
        .sb-toggle:hover { background: rgba(255,255,255,.15); color: #fff; }
        .sb-toggle svg { width: 16px; height: 16px; stroke-width: 2; }

        /* ── Nav ─────────────────────────────────────── */
        .sb-nav {
            flex: 1; overflow-y: auto; overflow-x: hidden;
            padding: 12px 8px; display: flex; flex-direction: column; gap: 2px;
            scrollbar-width: none;
        }
        .sb-nav::-webkit-scrollbar { display: none; }

        /* Section label */
        .sb-section {
            display: flex; align-items: center; gap: 8px;
            padding: 14px 8px 6px;
            font-size: 9.5px; font-weight: 700; letter-spacing: 1.8px;
            text-transform: uppercase; color: rgba(255,255,255,.28);
            white-space: nowrap; overflow: hidden;
            transition: opacity var(--ease);
        }
        .sb-section::after {
            content: ''; flex: 1; height: 1px;
            background: rgba(255,255,255,.08);
        }
        #sidebar.collapsed .sb-section { opacity: 0; height: 0; padding: 0; }

        /* Nav link */
        .sb-link {
            display: flex; align-items: center; gap: 12px;
            padding: 9px 10px; border-radius: 10px;
            font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,.55);
            text-decoration: none; white-space: nowrap;
            transition: background var(--ease), color var(--ease);
            position: relative; overflow: hidden;
        }
        .sb-link:hover {
            background: rgba(255,255,255,.08);
            color: rgba(255,255,255,.92);
        }
        .sb-link.active {
            background: linear-gradient(90deg, rgba(26,86,219,.45) 0%, rgba(26,86,219,.15) 100%);
            color: #93c5fd;
        }
        .sb-link.active::before {
            content: ''; position: absolute; left: 0; top: 20%; bottom: 20%;
            width: 3px; border-radius: 0 3px 3px 0;
            background: var(--blue);
        }
        /* icon */
        .sb-link .sb-icon {
            width: 32px; height: 32px; border-radius: 8px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; background: rgba(255,255,255,.06);
            transition: background var(--ease);
        }
        .sb-link:hover .sb-icon,
        .sb-link.active .sb-icon {
            background: rgba(26,86,219,.35);
        }
        .sb-link span { transition: opacity var(--ease); }
        #sidebar.collapsed .sb-link span { opacity: 0; }

        /* Tooltip when collapsed */
        #sidebar.collapsed .sb-link {
            position: relative;
            justify-content: center;
            padding: 9px;
        }
        #sidebar.collapsed .sb-link::after {
            content: attr(data-label);
            position: absolute; left: calc(var(--sb-cw) + 8px);
            background: #1e293b; color: #e2e8f0;
            font-size: 12px; font-weight: 500;
            padding: 5px 10px; border-radius: 6px;
            white-space: nowrap; pointer-events: none;
            opacity: 0; transform: translateX(-4px);
            transition: opacity .15s, transform .15s;
            box-shadow: 0 4px 12px rgba(0,0,0,.3);
        }
        #sidebar.collapsed .sb-link:hover::after {
            opacity: 1; transform: translateX(0);
        }

        /* ── Sidebar Footer / Profile ────────────────── */
        .sb-footer {
            border-top: 1px solid rgba(255,255,255,.07);
            padding: 12px 10px; flex-shrink: 0; position: relative; z-index: 1;
        }
        .sb-profile {
            display: flex; align-items: center; gap: 10px;
            padding: 8px; border-radius: 10px; cursor: pointer;
            transition: background var(--ease);
        }
        .sb-profile:hover { background: rgba(255,255,255,.08); }
        .sb-avatar {
            width: 34px; height: 34px; border-radius: 10px; flex-shrink: 0;
            background: linear-gradient(135deg, var(--blue-d), var(--blue));
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: #fff;
        }
        .sb-profile-info { overflow: hidden; transition: opacity var(--ease), width var(--ease); }
        #sidebar.collapsed .sb-profile-info { opacity: 0; width: 0; pointer-events: none; }
        .sb-profile-name { font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,.85); truncate; }
        .sb-profile-email { font-size: 11px; color: rgba(255,255,255,.35); truncate; }

        /* ── TOPBAR ──────────────────────────────────── */
        #topbar {
            position: sticky; top: 0; z-index: 30;
            height: 60px;
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 20px;
            gap: 12px;
            transition: padding-left var(--ease);
            box-shadow: 0 1px 0 rgba(0,0,0,.04), 0 4px 12px rgba(0,0,0,.03);
        }

        .topbar-logo img { height: 36px; }

        .topbar-spacer { flex: 1; }

        /* User pill in topbar */
        .topbar-user {
            display: flex; align-items: center; gap: 8px;
            padding: 5px 12px 5px 6px; border-radius: 99px;
            background: #f8fafc; border: 1px solid var(--border);
            cursor: pointer; position: relative;
            transition: background var(--ease), border-color var(--ease);
        }
        .topbar-user:hover { background: var(--blue-p); border-color: #bfdbfe; }
        .topbar-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: linear-gradient(135deg, var(--blue-d), var(--blue));
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff;
        }
        .topbar-name { font-size: 12.5px; font-weight: 600; color: var(--text); }
        .topbar-dropdown {
            position: absolute; top: calc(100% + 8px); right: 0;
            background: #fff; border: 1px solid var(--border);
            border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,.1);
            overflow: hidden; min-width: 180px;
            transform-origin: top right;
        }
        .topbar-dd-head { padding: 12px 16px; border-bottom: 1px solid var(--border); }
        .topbar-dd-head p { font-size: 13px; font-weight: 600; color: var(--text); }
        .topbar-dd-head span { font-size: 11px; color: var(--text-2); }
        .topbar-dd-action {
            display: block; padding: 10px 16px;
            font-size: 13px; color: #ef4444; font-weight: 500;
            text-decoration: none;
        }
        .topbar-dd-action:hover { background: #fef2f2; }

        /* ── MAIN LAYOUT ─────────────────────────────── */
        #layout {
            display: flex; min-height: 100vh;
        }
        #main {
            flex: 1;
            margin-left: var(--sb-w);
            transition: margin-left var(--ease);
            display: flex; flex-direction: column;
            min-width: 0;
        }
        #main.collapsed { margin-left: var(--sb-cw); }

        main {
            padding: 0;
            flex: 1;
        }

        /* ── MOBILE ──────────────────────────────────── */
        @media (max-width: 767px) {
            #sidebar { transform: translateX(-100%); transition: transform var(--ease), width var(--ease); width: var(--sb-w) !important; }
            #sidebar.mobile-open { transform: translateX(0); }
            #main { margin-left: 0 !important; }
            #sb-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 39; display: none; }
            #sb-overlay.show { display: block; }
            .desktop-only { display: none !important; }
        }
        @media (min-width: 768px) {
            .mobile-only { display: none !important; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div id="layout">

    <!-- ────────────────────────────────────────────────── SIDEBAR -->
    <aside id="sidebar" x-data x-bind:class="{ 'collapsed': $store.sb.collapsed }">

        <!-- Header -->
        <div class="sb-header">
            <span class="sb-logo">{{ config('app.name', 'Sistem Penagihan') }}</span>
            <button class="sb-toggle" @click="$store.sb.toggle()" aria-label="Toggle sidebar">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          :d="$store.sb.collapsed
                              ? 'M13 5l7 7-7 7M5 5l7 7-7 7'
                              : 'M11 19l-7-7 7-7M19 19l-7-7 7-7'"/>
                </svg>
            </button>
        </div>

        <!-- Nav -->
        <nav class="sb-nav">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
               data-label="Dashboard">
                <span class="sb-icon"><i class="fas fa-home"></i></span>
                <span>Dashboard</span>
            </a>

            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'accounting')
                <div class="sb-section"><i class="fas fa-calculator" style="font-size:9px"></i> Accounting</div>

                <a href="{{ route('pengajuan-pembayaran.index') }}"
                   class="sb-link {{ request()->routeIs('pengajuan-pembayaran.*') ? 'active' : '' }}"
                   data-label="Pengajuan Pembayaran">
                    <span class="sb-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                    <span>Pengajuan Pembayaran</span>
                </a>
                <a href="{{ route('purchasing.index') }}"
                   class="sb-link {{ request()->routeIs('purchasing.*') ? 'active' : '' }}"
                   data-label="Purchasing">
                    <span class="sb-icon"><i class="fas fa-cart-shopping"></i></span>
                    <span>Purchasing</span>
                </a>
                <a href="{{ route('pembayaraninternal.index') }}"
                   class="sb-link {{ request()->routeIs('pembayaraninternal.*') ? 'active' : '' }}"
                   data-label="Pembayaran Internal">
                    <span class="sb-icon"><i class="fas fa-money-bill-transfer"></i></span>
                    <span>Pembayaran Internal</span>
                </a>
                <a href="{{ route('internal-transfer.index') }}"
                   class="sb-link {{ request()->routeIs('internal-transfer.*') ? 'active' : '' }}"
                   data-label="Internal Transfer">
                    <span class="sb-icon"><i class="fas fa-right-left"></i></span>
                    <span>Internal Transfer</span>
                </a>
                <a href="{{ route('permintaanbarang.index') }}"
                   class="sb-link {{ request()->routeIs('permintaanbarang.*') ? 'active' : '' }}"
                   data-label="Permintaan Barang">
                    <span class="sb-icon"><i class="fas fa-box-open"></i></span>
                    <span>Permintaan Barang</span>
                </a>
                <a href="{{ route('tb_penerima.index') }}"
                   class="sb-link {{ request()->routeIs('tb_penerima.*') ? 'active' : '' }}"
                   data-label="Data Penerima">
                    <span class="sb-icon"><i class="fas fa-database"></i></span>
                    <span>Data Penerima</span>
                </a>
                <a href="{{ route('data-transfer.index') }}"
                   class="sb-link {{ request()->routeIs('data-transfer.*') ? 'active' : '' }}"
                   data-label="Transaksi">
                    <span class="sb-icon"><i class="fas fa-wallet"></i></span>
                    <span>Transaksi</span>
                </a>
            @endif

            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'purchasing')
                <div class="sb-section">Penagihan</div>

                <a href="{{ route('masterpenagihan.index') }}"
                   class="sb-link {{ request()->routeIs('masterpenagihan.*') ? 'active' : '' }}"
                   data-label="Master Penagihan">
                    <span class="sb-icon"><i class="fas fa-list-check"></i></span>
                    <span>Master Penagihan</span>
                </a>
            @endif

            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'legal')
                <div class="sb-section"><i class="fas fa-scale-balanced" style="font-size:9px"></i> Legal</div>

                <a href="{{ route('anggaranlegal.index') }}"
                   class="sb-link {{ request()->routeIs('anggaranlegal.*') ? 'active' : '' }}"
                   data-label="Anggaran Legal Non Operasional">
                    <span class="sb-icon"><i class="fas fa-file-contract"></i></span>
                    <span>Anggaran Legal Non Operasional</span>
                </a>
                <a href="{{ route('anggaranlegalop.index') }}"
                   class="sb-link {{ request()->routeIs('anggaranlegalop.*') ? 'active' : '' }}"
                   data-label="Anggaran Legal Operasional">
                    <span class="sb-icon"><i class="fas fa-file-signature"></i></span>
                    <span>Anggaran Legal Operasional</span>
                </a>
                <a href="{{ route('dokumen-legal.index') }}"
                   class="sb-link {{ request()->routeIs('dokumen-legal.*') ? 'active' : '' }}"
                   data-label="Metadata Dokumen Legal">
                    <span class="sb-icon"><i class="fas fa-folder-open"></i></span>
                    <span>Metadata Dokumen Legal</span>
                </a>
            @endif

            @if (Auth::user()->role === 'admin' || Auth::user()->role === 'hrd')
                <div class="sb-section">HRD</div>

                <a href="{{ route('anggaranhrd.index') }}"
                   class="sb-link {{ request()->routeIs('anggaranhrd.*') ? 'active' : '' }}"
                   data-label="Anggaran Operasional HRD">
                    <span class="sb-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                    <span>Anggaran Operasional HRD</span>
                </a>
                <a href="{{ route('anggaranhrdnoop.index') }}"
                   class="sb-link {{ request()->routeIs('anggaranhrdnoop.*') ? 'active' : '' }}"
                   data-label="Anggaran Non Operasional HRD">
                    <span class="sb-icon"><i class="fas fa-file-circle-minus"></i></span>
                    <span>Anggaran Non Operasional HRD</span>
                </a>
                <a href="{{ route('karyawan.index') }}"
                   class="sb-link {{ request()->routeIs('karyawan.*') ? 'active' : '' }}"
                   data-label="Karyawan">
                    <span class="sb-icon"><i class="fas fa-users"></i></span>
                    <span>Karyawan</span>
                </a>
            @endif

        </nav>

        <!-- Footer / Profile -->
        <div class="sb-footer">
            <div class="sb-profile" x-data="{ open: false }" @click.away="open = false" @click="open = !open">
                <div class="sb-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="sb-profile-info">
                    <div class="sb-profile-name">{{ Auth::user()->name }}</div>
                    <div class="sb-profile-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
        </div>

    </aside>

    <!-- Mobile overlay -->
    <div id="sb-overlay" onclick="closeMobileSidebar()"></div>

    <!-- ────────────────────────────────────────────────── MAIN -->
    <div id="main" x-data x-bind:class="{ 'collapsed': $store.sb.collapsed }">

        <!-- Topbar -->
        <header id="topbar">
            <!-- Mobile hamburger -->
            <button class="mobile-only sb-toggle" style="background:transparent; border:1px solid var(--border); color:var(--text-2);"
                    onclick="openMobileSidebar()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>

            <!-- Logo -->
            <div class="topbar-logo desktop-only">
                <img src="{{ asset('image/logo.png') }}" alt="{{ config('app.name') }}">
            </div>

            <div class="topbar-spacer"></div>

            <!-- User pill -->
            <div class="topbar-user" x-data="{ open: false }" @click.away="open = false" @click="open = !open">
                <div class="topbar-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <span class="topbar-name desktop-only">{{ Auth::user()->name }}</span>
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#94a3b8;margin-left:2px">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>

                <div class="topbar-dropdown" x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     x-cloak>
                    <div class="topbar-dd-head">
                        <p>{{ Auth::user()->name }}</p>
                        <span>{{ Auth::user()->email }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();"
                           class="topbar-dd-action">
                            <i class="fas fa-right-from-bracket" style="margin-right:6px"></i> Logout
                        </a>
                    </form>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main>
            @yield('content')
            {{ $slot ?? '' }}
        </main>

    </div><!-- /#main -->
</div><!-- /#layout -->

<!-- Alpine Store -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('sb', {
            collapsed: localStorage.getItem('sb-collapsed') === 'true',
            toggle() {
                this.collapsed = !this.collapsed;
                localStorage.setItem('sb-collapsed', this.collapsed);
            }
        });
    });

    function openMobileSidebar() {
        document.getElementById('sidebar').classList.add('mobile-open');
        document.getElementById('sb-overlay').classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeMobileSidebar() {
        document.getElementById('sidebar').classList.remove('mobile-open');
        document.getElementById('sb-overlay').classList.remove('show');
        document.body.style.overflow = '';
    }
</script>

@stack('modals')
@stack('scripts')

</body>
</html>