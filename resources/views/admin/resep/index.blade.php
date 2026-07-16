@extends('admin.layouts.app')
@section('title', 'Kelola Resep')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
    <div>
        <h2 style="font-size:1.1em;color:#f1f5f9;font-weight:700">Semua Resep</h2>
        <p style="color:#64748b;font-size:0.82em;margin-top:2px">{{ $recipes->count() }} resep tersedia</p>
    </div>
    <a href="{{ route('admin.resep.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Resep
    </a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Resep</th>
                <th>Bahan</th>
                <th>Waktu</th>
                <th>Kesulitan</th>
                <th>Porsi</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recipes as $resep)
            <tr>
                <td style="color:#475569;font-size:0.8em">{{ $resep->id }}</td>
                <td style="font-weight:700;color:#f1f5f9">{{ $resep->name }}</td>
                <td style="color:#64748b;font-size:0.82em">
                    {{ collect($resep->ingredients)->take(3)->implode(', ') }}
                    @if(count($resep->ingredients) > 3)
                        <span style="color:#475569"> +{{ count($resep->ingredients) - 3 }} lainnya</span>
                    @endif
                </td>
                <td><span class="badge badge-orange"><i class="fas fa-clock"></i> {{ $resep->time }}m</span></td>
                <td>
                    @if($resep->difficulty === 'mudah')
                        <span class="badge badge-green">Mudah</span>
                    @elseif($resep->difficulty === 'sedang')
                        <span class="badge badge-blue">Sedang</span>
                    @else
                        <span class="badge" style="background:rgba(239,68,68,0.15);color:#f87171">Sulit</span>
                    @endif
                </td>
                <td><span style="color:#94a3b8">{{ $resep->portion }} porsi</span></td>
                <td style="text-align:right">
                    <div style="display:flex;gap:8px;justify-content:flex-end">
                        <a href="{{ route('admin.resep.edit', $resep->id) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('admin.resep.destroy', $resep->id) }}" method="POST"
                              onsubmit="return confirm('Hapus resep \"{{ $resep->name }}\"?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <i class="fas fa-book-open"></i>
                        <p>Belum ada resep. <a href="{{ route('admin.resep.create') }}" style="color:#f39c12">Tambah sekarang</a></p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
