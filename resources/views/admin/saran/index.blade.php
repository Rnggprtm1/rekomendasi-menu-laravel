@extends('admin.layouts.app')
@section('title', 'Kotak Saran')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
    <div>
        <h2 style="font-size:1.1em;color:#f1f5f9;font-weight:700">Kotak Saran</h2>
        <p style="color:#64748b;font-size:0.82em;margin-top:2px">{{ $suggestions->count() }} saran masuk</p>
    </div>
</div>

@if($suggestions->isEmpty())
<div class="card">
    <div class="empty-state" style="padding:80px 20px">
        <i class="fas fa-comment-slash"></i>
        <p style="margin-top:12px;font-size:0.9em">Belum ada saran yang masuk.</p>
    </div>
</div>
@else
<div style="display:flex;flex-direction:column;gap:16px">
    @foreach($suggestions as $saran)
    <div class="card" style="padding:24px">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;flex-wrap:wrap">
            <div style="flex:1">
                {{-- Header saran --}}
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;flex-wrap:wrap">
                    <span class="badge {{ $saran->jenis === 'resep_baru' ? 'badge-orange' : 'badge-blue' }}">
                        <i class="fas {{ $saran->jenis === 'resep_baru' ? 'fa-lightbulb' : 'fa-comment' }}"></i>
                        {{ $saran->jenis === 'resep_baru' ? 'Usulan Resep' : 'Saran/Masukan' }}
                    </span>
                    @if($saran->status === 'baru')
                        <span class="badge" style="background:rgba(239,68,68,0.15);color:#f87171">
                            <i class="fas fa-circle" style="font-size:0.5em"></i> Baru
                        </span>
                    @elseif($saran->status === 'disetujui')
                        <span class="badge" style="background:rgba(34,197,94,0.15);color:#4ade80">
                            <i class="fas fa-check-circle"></i> Disetujui
                        </span>
                    @endif
                    <span style="color:#475569;font-size:0.78em">
                        <i class="fas fa-clock"></i>
                        {{ $saran->created_at ? $saran->created_at->diffForHumans() : '-' }}
                    </span>
                </div>

                {{-- Pengirim --}}
                <p style="color:#94a3b8;font-size:0.8em;margin-bottom:8px">
                    <i class="fas fa-user"></i>
                    <strong style="color:#f1f5f9">{{ $saran->pengirim ?? 'Anonim' }}</strong>
                </p>

                @if($saran->jenis === 'resep_baru')
                    {{-- ===================== --}}
                    {{-- TAMPILAN USULAN RESEP --}}
                    {{-- ===================== --}}

                    {{-- Judul Resep --}}
                    @if($saran->judul)
                    <p style="color:#f39c12;font-weight:700;font-size:1.1em;margin-bottom:12px">
                        <i class="fas fa-utensils"></i> {{ $saran->judul }}
                    </p>
                    @endif

                    {{-- Gambar & Info --}}
                    <div style="display:flex;gap:16px;margin-bottom:14px;flex-wrap:wrap">
                        @if($saran->image && $saran->image !== 'images/default.jpg')
                        <img src="{{ asset($saran->image) }}" alt="Gambar Resep"
                             style="width:140px;height:100px;object-fit:cover;border-radius:10px;border:2px solid #1e293b;">
                        @endif
                        <div style="display:flex;flex-direction:column;gap:6px;font-size:0.82em;color:#94a3b8">
                            @if($saran->time)
                            <span><i class="fas fa-clock" style="color:#3b82f6;width:16px"></i> {{ $saran->time }} menit</span>
                            @endif
                            @if($saran->difficulty)
                            <span><i class="fas fa-fire" style="color:#ef4444;width:16px"></i> {{ ucfirst($saran->difficulty) }}</span>
                            @endif
                            @if($saran->portion)
                            <span><i class="fas fa-users" style="color:#8b5cf6;width:16px"></i> {{ $saran->portion }} porsi</span>
                            @endif
                        </div>
                    </div>

                    {{-- Bahan-bahan --}}
                    @if($saran->ingredients && is_array($saran->ingredients) && count($saran->ingredients) > 0)
                    <div style="margin-bottom:12px;background:#0f1117;padding:14px;border-radius:10px">
                        <p style="color:#64748b;font-size:0.72em;font-weight:700;margin-bottom:6px;text-transform:uppercase">Bahan-bahan:</p>
                        <div style="display:flex;flex-wrap:wrap;gap:6px">
                            @foreach($saran->ingredients as $bahan)
                            <span style="background:#1e293b;color:#94a3b8;padding:4px 10px;border-radius:8px;font-size:0.8em">{{ $bahan }}</span>
                            @endforeach
                        </div>
                    </div>
                    @elseif($saran->bahan)
                    <div style="margin-bottom:12px;background:#0f1117;padding:12px;border-radius:10px">
                        <p style="color:#64748b;font-size:0.72em;font-weight:700;margin-bottom:4px;text-transform:uppercase">Bahan yang diusulkan:</p>
                        <p style="color:#94a3b8;font-size:0.85em">{{ $saran->bahan }}</p>
                    </div>
                    @endif

                    {{-- Langkah Memasak --}}
                    @if($saran->steps && is_array($saran->steps) && count($saran->steps) > 0)
                    <div style="background:#0f1117;padding:14px;border-radius:10px">
                        <p style="color:#64748b;font-size:0.72em;font-weight:700;margin-bottom:8px;text-transform:uppercase">Langkah Memasak:</p>
                        <ol style="margin:0;padding-left:20px;color:#94a3b8;font-size:0.82em;line-height:1.8">
                            @foreach($saran->steps as $step)
                            <li>
                                @if(isset($step['minute']) && $step['minute'] > 0)
                                <span style="color:#3b82f6;font-weight:600">[Menit {{ $step['minute'] }}]</span>
                                @endif
                                {{ $step['text'] ?? '' }}
                            </li>
                            @endforeach
                        </ol>
                    </div>
                    @endif

                @else
                    {{-- ===================== --}}
                    {{-- TAMPILAN SARAN BIASA --}}
                    {{-- ===================== --}}
                    <p style="color:#cbd5e1;font-size:0.88em;line-height:1.7">{{ $saran->konten }}</p>
                @endif
            </div>

            {{-- Actions --}}
            <div style="display:flex;flex-direction:column;gap:8px;min-width:140px">
                @if($saran->jenis === 'resep_baru' && $saran->status !== 'disetujui')
                    @if($saran->ingredients && is_array($saran->ingredients) && count($saran->ingredients) > 0)
                    {{-- Usulan resep lengkap: langsung approve --}}
                    <form action="{{ route('admin.saran.approve', $saran->id) }}" method="POST"
                          onsubmit="return confirm('Setujui resep &quot;{{ $saran->judul }}&quot;? Resep akan langsung masuk ke daftar menu.')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" style="width:100%">
                            <i class="fas fa-check-circle"></i> Setujui
                        </button>
                    </form>
                    @else
                    {{-- Usulan resep lama (tanpa data lengkap): redirect ke form --}}
                    <a href="{{ route('admin.saran.convert', $saran->id) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-magic"></i> Jadikan Resep
                    </a>
                    @endif
                @elseif($saran->status === 'disetujui')
                    <span class="btn btn-sm" style="background:rgba(34,197,94,0.1);color:#4ade80;cursor:default;text-align:center">
                        <i class="fas fa-check"></i> Sudah Disetujui
                    </span>
                @endif
                <form action="{{ route('admin.saran.destroy', $saran->id) }}" method="POST"
                      onsubmit="return confirm('Hapus saran dari {{ $saran->pengirim ?? 'Anonim' }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" style="width:100%">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection
