@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

<div class="stat-grid">
    <div class="stat-card">
        <div class="icon" style="background:rgba(243,156,18,0.15);color:#f39c12"><i class="fas fa-book-open"></i></div>
        <div class="val">{{ $totalResep }}</div>
        <div class="lbl">Total Resep</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(59,130,246,0.15);color:#60a5fa"><i class="fas fa-comment-dots"></i></div>
        <div class="val">{{ $totalSaran }}</div>
        <div class="lbl">Total Saran Masuk</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(239,68,68,0.15);color:#f87171"><i class="fas fa-bell"></i></div>
        <div class="val">{{ $saranBaru }}</div>
        <div class="lbl">Saran Belum Dibaca</div>
    </div>
    <div class="stat-card">
        <div class="icon" style="background:rgba(34,197,94,0.15);color:#4ade80"><i class="fas fa-lightbulb"></i></div>
        <div class="val">{{ $saranResepBaru }}</div>
        <div class="lbl">Usulan Resep Baru</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px">

    {{-- Resep terbaru --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-clock" style="color:#f39c12"></i> Resep Terbaru</h3>
            <a href="{{ route('admin.resep.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Resep
            </a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama Resep</th>
                    <th>Waktu</th>
                    <th>Kesulitan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($resepTerbaru as $resep)
                <tr>
                    <td style="font-weight:600;color:#f1f5f9">{{ $resep->name }}</td>
                    <td><span class="badge badge-orange"><i class="fas fa-clock"></i> {{ $resep->time }} menit</span></td>
                    <td>
                        @if($resep->difficulty === 'mudah')
                            <span class="badge badge-green">Mudah</span>
                        @elseif($resep->difficulty === 'sedang')
                            <span class="badge badge-blue">Sedang</span>
                        @else
                            <span class="badge badge-gray">Sulit</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.resep.edit', $resep->id) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-pen"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="empty-state">Belum ada resep.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Quick Actions --}}
    <div class="card" style="padding:24px;display:flex;flex-direction:column;gap:12px;align-self:start">
        <h3 style="font-size:0.9em;font-weight:700;margin-bottom:4px;color:#f1f5f9"><i class="fas fa-bolt" style="color:#f39c12"></i> Aksi Cepat</h3>
        <a href="{{ route('admin.resep.create') }}" class="btn btn-primary" style="justify-content:center">
            <i class="fas fa-plus"></i> Tambah Resep Baru
        </a>
        <a href="{{ route('admin.saran.index') }}" class="btn btn-secondary" style="justify-content:center">
            <i class="fas fa-comment-dots"></i> Lihat Saran ({{ $saranBaru }} baru)
        </a>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-secondary" style="justify-content:center">
            <i class="fas fa-external-link-alt"></i> Buka Website
        </a>
    </div>

</div>

@endsection
