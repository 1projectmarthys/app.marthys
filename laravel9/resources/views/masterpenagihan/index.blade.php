@extends('layouts.app')

@push('styles')
{{-- Tippy tooltip --}}
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">
{{-- SweetAlert2 --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

<style>
    /* ── Page wrapper ──────────────────────────────── */
    .pg-wrap { padding: 28px 24px 64px; font-family: var(--font, 'DM Sans', sans-serif); }

    /* ── Page Header ───────────────────────────────── */
    .pg-header {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
        margin-bottom: 24px;
    }
    .pg-title { font-family: var(--disp, 'Fraunces', serif); font-size: 22px; font-weight: 600; color: #0f172a; line-height: 1.2; }
    .pg-sub   { font-size: 13px; color: #64748b; margin-top: 3px; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 8px 18px; border-radius: 10px; font-size: 13px; font-weight: 600;
        background: linear-gradient(135deg, #1042b0, #1a56db);
        color: #fff; text-decoration: none; border: none; cursor: pointer;
        box-shadow: 0 2px 8px rgba(26,86,219,.3);
        transition: box-shadow .2s, transform .15s;
    }
    .btn-primary:hover { box-shadow: 0 6px 18px rgba(26,86,219,.4); transform: translateY(-1px); color: #fff; }

    /* ── Alert ─────────────────────────────────────── */
    .alert-success {
        display: flex; align-items: flex-start; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;
        padding: 12px 14px; margin-bottom: 20px; font-size: 13px; color: #166534;
    }
    .alert-success button { margin-left: auto; background: none; border: none; cursor: pointer; color: #16a34a; font-size: 14px; }

    /* ── Card wrapper ──────────────────────────────── */
    .card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.04);
        overflow: hidden;
    }
    .card-body { padding: 20px 20px 0; }

    /* ── Filters row ───────────────────────────────── */
    .filters-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
        margin-bottom: 16px;
    }
    @media (max-width: 768px) { .filters-row { grid-template-columns: 1fr; } }

    .input-wrap {
        position: relative;
    }
    .input-wrap .input-icon {
        position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 13px; pointer-events: none;
    }
    .input-wrap input,
    .input-wrap select {
        width: 100%; padding: 8px 36px;
        font-size: 13px; font-family: inherit;
        border: 1px solid #e2e8f0; border-radius: 8px;
        background: #f8fafc; color: #0f172a;
        outline: none; appearance: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .input-wrap input:focus,
    .input-wrap select:focus {
        border-color: #1a56db; background: #fff;
        box-shadow: 0 0 0 3px rgba(26,86,219,.12);
    }
    .input-wrap .input-suffix {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 11px; pointer-events: none;
    }

    /* ── Toolbar (per-page + count) ────────────────── */
    .table-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
        padding: 12px 20px;
        border-bottom: 1px solid #f1f5f9;
    }
    .per-page-wrap { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #475569; }
    .per-page-wrap select {
        padding: 5px 28px 5px 10px; font-size: 13px; font-family: inherit;
        border: 1px solid #e2e8f0; border-radius: 7px; background: #f8fafc;
        outline: none; appearance: none; cursor: pointer;
        transition: border-color .2s;
    }
    .per-page-wrap select:focus { border-color: #1a56db; }
    .per-page-arrow { position: relative; display: inline-block; }
    .per-page-arrow::after {
        content: ''; position: absolute; right: 9px; top: 50%; transform: translateY(-50%);
        border: 4px solid transparent; border-top: 5px solid #94a3b8;
        margin-top: 3px; pointer-events: none;
    }

    .count-badge {
        font-size: 12px; color: #64748b;
    }
    .count-badge strong { color: #1a56db; }

    /* ── Table ─────────────────────────────────────── */
    .tbl-wrap { overflow-x: auto; }

    table { width: 100%; border-collapse: collapse; }

    thead tr {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    thead th {
        padding: 10px 14px;
        font-size: 11px; font-weight: 700; letter-spacing: .8px;
        text-transform: uppercase; color: #64748b;
        white-space: nowrap;
        user-select: none;
    }
    thead th.sortable { cursor: pointer; }
    thead th.sortable:hover { color: #1a56db; }
    thead th .sort-icon { margin-left: 4px; font-size: 10px; color: #cbd5e1; }
    thead th.sorted-asc .sort-icon,
    thead th.sorted-desc .sort-icon { color: #1a56db; }

    tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background .12s;
    }
    tbody tr:hover { background: #f8fafc; }
    tbody tr:last-child { border-bottom: none; }

    tbody td {
        padding: 11px 14px;
        font-size: 13px; color: #334155;
        vertical-align: middle;
    }

    /* Customer avatar cell */
    .cust-cell { display: flex; align-items: center; gap: 10px; }
    .cust-avatar {
        width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
        background: linear-gradient(135deg, #1042b0, #1a56db);
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; color: #fff;
    }
    .cust-name  { font-size: 13px; font-weight: 600; color: #0f172a; }
    .cust-code  { font-size: 11px; color: #94a3b8; }

    /* Status badge */
    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 99px;
        font-size: 11px; font-weight: 700; letter-spacing: .3px;
    }
    .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .badge-completed { background: #f0fdf4; color: #16a34a; }
    .badge-pending   { background: #fefce8; color: #ca8a04; }
    .badge-canceled  { background: #fef2f2; color: #dc2626; }
    .badge-default   { background: #f1f5f9; color: #475569; }

    /* Amount */
    .amount { font-family: var(--disp, 'Fraunces', serif); font-size: 13px; font-weight: 600; color: #0f172a; }

    /* Action buttons */
    .actions { display: flex; align-items: center; justify-content: center; gap: 6px; }
    .act-btn {
        width: 30px; height: 30px; border-radius: 8px; border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; text-decoration: none;
        transition: background .15s, transform .1s;
    }
    .act-btn:hover { transform: scale(1.12); }
    .act-view   { background: #eff6ff; color: #1a56db; }
    .act-edit   { background: #fefce8; color: #ca8a04; }
    .act-print  { background: #eff6ff; color: #0369a1; }
    .act-rcpt   { background: #f0fdf4; color: #16a34a; }
    .act-check  { background: #f0fdf4; color: #16a34a; }
    .act-del    { background: #fef2f2; color: #dc2626; }

    /* Empty state */
    .empty-state {
        text-align: center; padding: 56px 24px;
        color: #94a3b8;
    }
    .empty-state i { font-size: 40px; margin-bottom: 12px; display: block; opacity: .5; }
    .empty-state p { font-size: 14px; }

    /* ── Pagination ─────────────────────────────────── */
    .pagination-wrap {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
    }
    .pag-info { font-size: 12.5px; color: #64748b; }
    .pag-btns { display: flex; align-items: center; gap: 4px; }

    .pag-btn {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px; border-radius: 8px;
        font-size: 12.5px; font-weight: 500;
        border: 1px solid #e2e8f0; background: #fff; color: #475569;
        text-decoration: none; transition: all .15s; cursor: pointer;
    }
    .pag-btn:hover:not(.disabled) { background: #f8fafc; border-color: #cbd5e1; color: #0f172a; }
    .pag-btn.active { background: linear-gradient(135deg, #1042b0, #1a56db); border-color: transparent; color: #fff; }
    .pag-btn.disabled { opacity: .45; cursor: not-allowed; pointer-events: none; }
</style>
@endpush

@section('content')
<div class="pg-wrap">

    {{-- ── Page Header ─────────────────────────────── --}}
    <div class="pg-header">
        <div>
            <h1 class="pg-title">Daftar Penagihan</h1>
            <p class="pg-sub">Kelola semua penagihan customer</p>
        </div>
        <a href="{{ route('masterpenagihan.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i> Tambah Penagihan
        </a>
    </div>

    {{-- ── Flash Message ────────────────────────────── --}}
    @if (session('success'))
        <div class="alert-success" id="flashAlert">
            <i class="fas fa-check-circle" style="margin-top:1px;font-size:15px"></i>
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('flashAlert').remove()" title="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    {{-- ── Main Card ────────────────────────────────── --}}
    <div class="card">

        {{-- Filters --}}
        <div class="card-body">
            <div class="filters-row">

                {{-- Search --}}
                <form action="{{ route('masterpenagihan.index') }}" method="GET">
                    <div class="input-wrap">
                        <i class="fas fa-search input-icon"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari penagihan...">
                        @if(request('status'))   <input type="hidden" name="status"   value="{{ request('status') }}"> @endif
                        @if(request('date'))     <input type="hidden" name="date"     value="{{ request('date') }}"> @endif
                        @if(request('per_page')) <input type="hidden" name="per_page" value="{{ request('per_page') }}"> @endif
                        <button type="submit" class="input-suffix" style="background:none;border:none;cursor:pointer;pointer-events:all">
                            <i class="fas fa-arrow-right" style="color:#1a56db"></i>
                        </button>
                    </div>
                </form>

                {{-- Status filter --}}
                <form action="{{ route('masterpenagihan.index') }}" method="GET" id="statusFilterForm">
                    <div class="input-wrap">
                        <i class="fas fa-filter input-icon"></i>
                        <select name="status" onchange="this.closest('form').submit()">
                            <option value=""        {{ !request('status')               ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled"  {{ request('status') == 'canceled'  ? 'selected' : '' }}>Canceled</option>
                        </select>
                        <i class="fas fa-chevron-down input-suffix"></i>
                        @if(request('search'))   <input type="hidden" name="search"   value="{{ request('search') }}"> @endif
                        @if(request('date'))     <input type="hidden" name="date"     value="{{ request('date') }}"> @endif
                        @if(request('per_page')) <input type="hidden" name="per_page" value="{{ request('per_page') }}"> @endif
                    </div>
                </form>

                {{-- Date filter --}}
                <form action="{{ route('masterpenagihan.index') }}" method="GET" id="dateFilterForm">
                    <div class="input-wrap">
                        <i class="fas fa-calendar input-icon"></i>
                        <input type="date" name="date" value="{{ request('date') }}"
                               onchange="this.closest('form').submit()">
                        @if(request('search'))   <input type="hidden" name="search"   value="{{ request('search') }}"> @endif
                        @if(request('status'))   <input type="hidden" name="status"   value="{{ request('status') }}"> @endif
                        @if(request('per_page')) <input type="hidden" name="per_page" value="{{ request('per_page') }}"> @endif
                    </div>
                </form>

            </div>
        </div>{{-- /.card-body --}}

        {{-- Toolbar: per-page --}}
        <div class="table-toolbar">
            <div class="per-page-wrap">
                <span>Tampilkan</span>
                <form action="{{ route('masterpenagihan.index') }}" method="GET" id="pageSizeForm">
                    <div class="per-page-arrow">
                        <select name="per_page" id="pageSizeSelect" onchange="document.getElementById('pageSizeForm').submit()">
                            <option value="10"  {{ (request('per_page','10') == '10')  ? 'selected' : '' }}>10</option>
                            <option value="100" {{ request('per_page') == '100'         ? 'selected' : '' }}>100</option>
                            <option value="500" {{ request('per_page') == '500'         ? 'selected' : '' }}>Semua</option>
                        </select>
                    </div>
                    @if(request('search'))   <input type="hidden" name="search"   value="{{ request('search') }}"> @endif
                    @if(request('status'))   <input type="hidden" name="status"   value="{{ request('status') }}"> @endif
                    @if(request('date'))     <input type="hidden" name="date"     value="{{ request('date') }}"> @endif
                </form>
                <span>data per halaman</span>
            </div>
            <div class="count-badge">
                Total: <strong>{{ $masterpenaghihans->total() }}</strong> penagihan
            </div>
        </div>

        {{-- Table --}}
        <div class="tbl-wrap">
            <table id="penagihanTable">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="id">No <i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-sort="nomor_dokumen">No. Dokumen <i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-sort="tanggal_dokumen">Tanggal <i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-sort="nama_customer">Customer <i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-sort="keterangan_lengkap">Keterangan <i class="fas fa-sort sort-icon"></i></th>
                        <th class="sortable" data-sort="total_tagihan">Total <i class="fas fa-sort sort-icon"></i></th>
                        <th style="text-align:center">Aksi</th>
                        <th class="sortable" data-sort="status_bayar">Status <i class="fas fa-sort sort-icon"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($masterpenaghihans as $penagihan)
                        <tr>
                            <td>{{ $penagihan->id }}</td>
                            <td style="font-weight:600;color:#0f172a">{{ $penagihan->nomor_dokumen }}</td>
                            <td>{{ $penagihan->tanggal_dokumen }}</td>
                            <td>
                                <div class="cust-cell">
                                    <div class="cust-avatar">{{ strtoupper(substr($penagihan->nama_customer, 0, 1)) }}</div>
                                    <div>
                                        <div class="cust-name">{{ $penagihan->nama_customer }}</div>
                                        <div class="cust-code">{{ $penagihan->kode_customer }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $penagihan->keterangan_lengkap }}</td>
                            <td><span class="amount">Rp {{ number_format($penagihan->total_tagihan, 2, ',', '.') }}</span></td>

                            <td>
                                <div class="actions">
                                    <a href="{{ route('masterpenagihan.show', $penagihan) }}"
                                       class="act-btn act-view" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('masterpenagihan.edit', $penagihan) }}"
                                       class="act-btn act-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('print.penagihan', $penagihan->id) }}"
                                       class="act-btn act-print" title="Print Penagihan" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('print.kwitansi', $penagihan->id) }}"
                                       class="act-btn act-rcpt" title="Print Kwitansi" target="_blank">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    @if($penagihan->status_bayar != 'completed')
                                        <button type="button"
                                                class="act-btn act-check update-status-btn"
                                                data-id="{{ $penagihan->id }}"
                                                title="Tandai Lunas">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <form id="update-form-{{ $penagihan->id }}"
                                              action="{{ route('masterpenagihan.update-status', $penagihan) }}"
                                              method="POST" class="hidden" style="display:none">
                                            @csrf
                                            @method('PUT')
                                        </form>
                                    @endif
                                </div>
                            </td>

                            <td>
                                @php
                                    $sc = match($penagihan->status_bayar) {
                                        'completed' => 'badge-completed',
                                        'pending'   => 'badge-pending',
                                        'canceled'  => 'badge-canceled',
                                        default     => 'badge-pending',
                                    };
                                @endphp
                              <span class="badge {{ $sc }}">{{ ucfirst(!empty($penagihan->status_bayar) ? $penagihan->status_bayar : 'pending') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>Tidak ada data penagihan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>{{-- /.tbl-wrap --}}

        {{-- Pagination --}}
        <div class="pagination-wrap">
            <div class="pag-info">
                Menampilkan {{ $masterpenaghihans->firstItem() ?? 0 }}–{{ $masterpenaghihans->lastItem() ?? 0 }}
                dari {{ $masterpenaghihans->total() }} data
            </div>
            <div class="pag-btns">
                @if ($masterpenaghihans->onFirstPage())
                    <span class="pag-btn disabled"><i class="fas fa-chevron-left" style="font-size:10px"></i> Sebelumnya</span>
                @else
                    <a href="{{ $masterpenaghihans->previousPageUrl() }}" class="pag-btn">
                        <i class="fas fa-chevron-left" style="font-size:10px"></i> Sebelumnya
                    </a>
                @endif

                @foreach ($masterpenaghihans->getUrlRange(max($masterpenaghihans->currentPage()-2,1), min($masterpenaghihans->currentPage()+2,$masterpenaghihans->lastPage())) as $page => $url)
                    @if ($page == $masterpenaghihans->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($masterpenaghihans->hasMorePages())
                    <a href="{{ $masterpenaghihans->nextPageUrl() }}" class="pag-btn">
                        Selanjutnya <i class="fas fa-chevron-right" style="font-size:10px"></i>
                    </a>
                @else
                    <span class="pag-btn disabled">Selanjutnya <i class="fas fa-chevron-right" style="font-size:10px"></i></span>
                @endif
            </div>
        </div>

    </div>{{-- /.card --}}
</div>{{-- /.pg-wrap --}}
@endsection

@push('scripts')
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Tippy tooltips ──────────────────────────── */
    document.querySelectorAll('[title]').forEach(el => {
        tippy(el, { content: el.getAttribute('title'), placement: 'top' });
        el.removeAttribute('title');
    });

    /* ── Tandai Lunas ────────────────────────────── */
    document.querySelectorAll('.update-status-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Konfirmasi Status',
                text: 'Tandai penagihan ini sebagai lunas?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Tandai Lunas',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    document.getElementById('update-form-' + id).submit();
                }
            });
        });
    });

    /* ── Sorting ─────────────────────────────────── */
    const table = document.getElementById('penagihanTable');
    if (!table) return;

    const sortState = {};   // { colKey: 'asc'|'desc'|null }

    table.querySelectorAll('thead th.sortable').forEach(th => {
        th.addEventListener('click', function () {
            const col = this.dataset.sort;

            // reset others
            table.querySelectorAll('thead th.sortable').forEach(h => {
                if (h !== this) {
                    h.classList.remove('sorted-asc', 'sorted-desc');
                    const ic = h.querySelector('.sort-icon');
                    if (ic) ic.className = 'fas fa-sort sort-icon';
                    sortState[h.dataset.sort] = null;
                }
            });

            // toggle
            sortState[col] = sortState[col] === 'asc' ? 'desc' : 'asc';
            const asc = sortState[col] === 'asc';
            this.classList.toggle('sorted-asc', asc);
            this.classList.toggle('sorted-desc', !asc);
            const icon = this.querySelector('.sort-icon');
            if (icon) icon.className = asc ? 'fas fa-sort-up sort-icon' : 'fas fa-sort-down sort-icon';

            sortBy(table, col, asc);
        });
    });

    function colIndex(col) {
        let i = 0;
        for (const th of table.querySelectorAll('thead th')) {
            if (th.dataset.sort === col) return i;
            i++;
        }
        return 0;
    }

    function cellValue(row, idx) {
        const cell = row.cells[idx];
        if (!cell) return '';
        return cell.textContent.trim();
    }

    function parseVal(raw, col) {
        if (col === 'id') return parseInt(raw, 10) || 0;
        if (col === 'total_tagihan') return parseFloat(raw.replace(/[^\d,]/g,'').replace(',','.')) || 0;
        if (col === 'tanggal_dokumen') {
            const p = raw.includes('/') ? raw.split('/') : raw.split('-');
            if (p.length === 3) return raw.includes('/')
                ? new Date(p[2], p[1]-1, p[0]).getTime()
                : new Date(p[0], p[1]-1, p[2]).getTime();
        }
        return raw.toLowerCase();
    }

    function sortBy(tbl, col, asc) {
        const tbody = tbl.querySelector('tbody');
        const rows  = Array.from(tbody.rows);
        const idx   = colIndex(col);

        // don't sort empty-state row
        if (rows.length === 1 && rows[0].querySelector('td[colspan]')) return;

        rows.sort((a, b) => {
            if (a.querySelector('td[colspan]')) return  1;
            if (b.querySelector('td[colspan]')) return -1;
            const av = parseVal(cellValue(a, idx), col);
            const bv = parseVal(cellValue(b, idx), col);
            return asc ? (av > bv ? 1 : av < bv ? -1 : 0)
                       : (bv > av ? 1 : bv < av ? -1 : 0);
        });

        rows.forEach(r => tbody.appendChild(r));
    }
});
</script>
@endpush