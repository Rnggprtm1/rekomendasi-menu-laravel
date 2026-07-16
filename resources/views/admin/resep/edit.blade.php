@extends('admin.layouts.app')
@section('title', 'Edit Resep')

@section('content')

<div style="margin-bottom:20px">
    <a href="{{ route('admin.resep.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if($errors->any())
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <ul style="margin:0;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="card" style="padding:32px">
    <h2 style="font-size:1em;font-weight:700;color:#f1f5f9;margin-bottom:28px">
        <i class="fas fa-pen" style="color:#f39c12"></i> Edit: {{ $recipe->name }}
    </h2>

    <form action="{{ route('admin.resep.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Nama Resep *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', $recipe->name) }}" required>
            </div>
            <div class="form-group">
                <label>Gambar Masakan</label>
                <div style="border: 2px dashed #334155; border-radius: 10px; padding: 16px; text-align:center; cursor:pointer; transition: border-color 0.2s;" onclick="document.getElementById('imageUpload').click()" id="dropZone">
                    <img id="imagePreview"
                         src="{{ asset($recipe->image ?? 'images/default.jpg') }}"
                         style="max-height:150px; max-width:100%; border-radius:8px; display:block; margin:0 auto 10px; object-fit:cover;">
                    <p style="color:#94a3b8; font-size:0.82em; margin:0;"><i class="fas fa-cloud-upload-alt" style="margin-right:6px;"></i>Klik untuk ganti gambar</p>
                    <p style="color:#475569; font-size:0.75em; margin:4px 0 0;">Format: JPG, JPEG, PNG, WEBP (Maks. 2MB) &mdash; Kosongkan jika tidak ingin mengganti</p>
                </div>
                <input type="file" id="imageUpload" name="image" accept="image/*"
                       style="display:none;"
                       onchange="previewImage(this)">
            </div>
        </div>

        <div class="form-row-3">
            <div class="form-group">
                <label>Waktu Masak (menit) *</label>
                <input type="number" name="time" class="form-control"
                       value="{{ old('time', $recipe->time) }}" min="1" required>
            </div>
            <div class="form-group">
                <label>Tingkat Kesulitan *</label>
                <select name="difficulty" class="form-control" required>
                    @foreach(['mudah','sedang','sulit'] as $d)
                        <option value="{{ $d }}" {{ old('difficulty', $recipe->difficulty) === $d ? 'selected' : '' }}>
                            {{ ucfirst($d) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Porsi (orang) *</label>
                <input type="number" name="portion" class="form-control"
                       value="{{ old('portion', $recipe->portion) }}" min="1" required>
            </div>
        </div>

        <div class="form-group">
            <label>Bahan-bahan * <span style="font-weight:400;color:#475569">(pisahkan koma)</span></label>
            <input type="text" name="ingredients" class="form-control"
                   value="{{ old('ingredients', implode(', ', $recipe->ingredients ?? [])) }}" required>
        </div>

        <div class="form-group">
            <label>Langkah Memasak *</label>
            <div class="steps-container" id="stepsContainer">
                @php $steps = $recipe->steps ?? []; @endphp
                @foreach($steps as $i => $step)
                <div class="step-row">
                    <input type="number" name="steps[{{ $i }}][minute]"
                           value="{{ $step['minute'] ?? 0 }}" placeholder="Menit" min="0"
                           class="form-control" style="padding:8px">
                    <textarea name="steps[{{ $i }}][text]" rows="2"
                              class="form-control" style="padding:8px">{{ $step['text'] ?? '' }}</textarea>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeStep(this)"><i class="fas fa-times"></i></button>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary btn-sm" style="margin-top:12px" onclick="addStep()">
                <i class="fas fa-plus"></i> Tambah Langkah
            </button>
        </div>

        <div style="display:flex;gap:12px;margin-top:8px">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
            <a href="{{ route('admin.resep.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
    // Preview gambar sebelum upload
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('dropZone').style.borderColor = '#f39c12';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    let stepCount = {{ count($recipe->steps ?? []) }};
    function addStep() {
        const c = document.getElementById('stepsContainer');
        const div = document.createElement('div');
        div.className = 'step-row';
        div.innerHTML = `
            <input type="number" name="steps[${stepCount}][minute]" placeholder="Menit" min="0" class="form-control" style="padding:8px">
            <textarea name="steps[${stepCount}][text]" rows="2" placeholder="Instruksi..." class="form-control" style="padding:8px"></textarea>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeStep(this)"><i class="fas fa-times"></i></button>
        `;
        c.appendChild(div);
        stepCount++;
    }
    function removeStep(btn) {
        const rows = document.querySelectorAll('.step-row');
        if (rows.length > 1) btn.closest('.step-row').remove();
    }
</script>

@endsection
