<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kirim saran atau usulan resep baru ke Rekomendasi Menu Masakan.">
    <title>Kotak Saran — Rekomendasi Menu Masakan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .saran-container {
            max-width: 720px;
            margin: 40px auto 80px;
            padding: 0 20px;
        }
        .saran-card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08);
        }
        .saran-card h2 {
            color: #2d3436;
            font-size: 1.6em;
            margin-bottom: 6px;
        }
        .saran-card .subtitle {
            color: #636e72;
            font-size: 0.92em;
            margin-bottom: 32px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 0.85em;
            color: #2d3436;
            margin-bottom: 8px;
        }
        .form-group .hint {
            font-size: 0.75em;
            color: #b2bec3;
            font-weight: 400;
            margin-left: 6px;
        }
        .form-control {
            width: 100%;
            border: 2px solid #f1f2f6;
            border-radius: 14px;
            padding: 13px 16px;
            font-size: 15px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2d3436;
            background: #f8f9fa;
            outline: none;
            transition: 0.3s;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: #e67e22;
            background: white;
            box-shadow: 0 0 0 4px rgba(230,126,34,0.12);
        }
        textarea.form-control { resize: vertical; min-height: 120px; }
        select.form-control { cursor: pointer; }

        /* Grid layouts */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
        }

        /* Jenis selector */
        .jenis-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .jenis-option { position: relative; }
        .jenis-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
        }
        .jenis-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 20px;
            border: 2px solid #f1f2f6;
            border-radius: 16px;
            cursor: pointer;
            text-align: center;
            transition: 0.25s;
            background: #f8f9fa;
        }
        .jenis-label i { font-size: 1.5em; color: #b2bec3; }
        .jenis-label span { font-size: 0.85em; font-weight: 700; color: #636e72; }
        .jenis-option input:checked + .jenis-label {
            border-color: #e67e22;
            background: #fff8f1;
        }
        .jenis-option input:checked + .jenis-label i,
        .jenis-option input:checked + .jenis-label span { color: #e67e22; }

        /* Extra fields */
        .extra-fields { display: none; }
        .extra-fields.show { display: block; }
        .saran-fields { display: block; }
        .saran-fields.hide { display: none; }

        /* Upload zone */
        .upload-zone {
            border: 2px dashed #dfe6e9;
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: border-color 0.3s, background 0.3s;
            background: #f8f9fa;
        }
        .upload-zone:hover {
            border-color: #e67e22;
            background: #fff8f1;
        }
        .upload-zone img {
            max-height: 160px;
            max-width: 100%;
            border-radius: 10px;
            display: block;
            margin: 0 auto 10px;
            object-fit: cover;
        }

        /* Steps */
        .step-row {
            display: grid;
            grid-template-columns: 80px 1fr 40px;
            gap: 10px;
            align-items: start;
            margin-bottom: 10px;
        }
        .step-row input[type="number"] {
            padding: 10px !important;
            text-align: center;
        }
        .step-row textarea {
            min-height: 50px !important;
            padding: 10px !important;
        }
        .btn-remove-step {
            width: 36px;
            height: 36px;
            border: none;
            background: #fee2e2;
            color: #ef4444;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }
        .btn-remove-step:hover { background: #fecaca; }
        .btn-add-step {
            background: #f1f2f6;
            border: 2px dashed #dfe6e9;
            color: #636e72;
            padding: 10px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85em;
            transition: 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-add-step:hover { border-color: #e67e22; color: #e67e22; }

        /* Submit */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #f39c12, #d35400);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin-top: 8px;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(230,126,34,0.35); }

        /* Alert */
        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 24px;
            font-weight: 600;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #636e72;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9em;
            margin-bottom: 20px;
            transition: 0.2s;
        }
        .back-link:hover { color: #e67e22; }

        /* Section divider */
        .section-divider {
            border: none;
            border-top: 2px dashed #f1f2f6;
            margin: 24px 0;
        }
        .section-title {
            font-weight: 700;
            font-size: 0.9em;
            color: #2d3436;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title i { color: #e67e22; }

        @media(max-width:600px) {
            .saran-card { padding: 24px 18px; }
            .jenis-group { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .form-row-3 { grid-template-columns: 1fr; }
            .step-row { grid-template-columns: 60px 1fr 36px; }
        }
    </style>
</head>
<body>
    <header class="header">
        <h1><i class="fas fa-comment-dots"></i> Kotak Saran</h1>
        <p>Punya ide resep atau masukan? Sampaikan di sini!</p>
    </header>

    <div class="saran-container">
        <a href="{{ route('home') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Beranda
        </a>

        <div class="saran-card">
            <h2><i class="fas fa-paper-plane" style="color:#e67e22"></i> Kirim Saran</h2>
            <p class="subtitle">Saranmu sangat berarti! Nama ditampilkan jika resepmu dijadikan resep resmi.</p>

            @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
            @endif

            <form action="{{ route('saran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Jenis Saran --}}
                <div class="form-group">
                    <label>Jenis Saran</label>
                    <div class="jenis-group">
                        <div class="jenis-option">
                            <input type="radio" name="jenis" id="jenis_saran" value="saran"
                                   {{ old('jenis', 'saran') === 'saran' ? 'checked' : '' }}
                                   onchange="toggleFields()">
                            <label class="jenis-label" for="jenis_saran">
                                <i class="fas fa-comment"></i>
                                <span>Saran / Masukan</span>
                                <small style="color:#b2bec3;font-size:0.75em">Feedback umum</small>
                            </label>
                        </div>
                        <div class="jenis-option">
                            <input type="radio" name="jenis" id="jenis_resep" value="resep_baru"
                                   {{ old('jenis') === 'resep_baru' ? 'checked' : '' }}
                                   onchange="toggleFields()">
                            <label class="jenis-label" for="jenis_resep">
                                <i class="fas fa-lightbulb"></i>
                                <span>Usul Resep Baru</span>
                                <small style="color:#b2bec3;font-size:0.75em">Kirim resep lengkap</small>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- ============================================ --}}
                {{-- FORM SARAN BIASA --}}
                {{-- ============================================ --}}
                <div class="saran-fields" id="saranFields">
                    <div class="form-group">
                        <label>Isi Saran / Masukan *</label>
                        <textarea name="konten" class="form-control"
                                  placeholder="Tulis saranmu atau masukan untuk website...">{{ old('konten') }}</textarea>
                    </div>
                </div>

                {{-- ============================================ --}}
                {{-- FORM RESEP LENGKAP (SEPERTI ADMIN) --}}
                {{-- ============================================ --}}
                <div class="extra-fields {{ old('jenis') === 'resep_baru' ? 'show' : '' }}" id="extraFields">

                    {{-- Nama & Gambar --}}
                    <div class="section-title"><i class="fas fa-utensils"></i> Informasi Resep</div>
                    <div class="form-row" style="margin-bottom:16px;">
                        <div class="form-group">
                            <label>Nama Resep *</label>
                            <input type="text" name="judul" class="form-control"
                                   value="{{ old('judul') }}" placeholder="cth: Soto Betawi, Rendang Padang...">
                        </div>
                        <div class="form-group">
                            <label>Gambar Masakan</label>
                            <div class="upload-zone" onclick="document.getElementById('imageUpload').click()" id="dropZone">
                                <img id="imagePreview" src="{{ asset('images/default.jpg') }}">
                                <p style="color:#94a3b8; font-size:0.82em; margin:0;">
                                    <i class="fas fa-cloud-upload-alt" style="margin-right:6px;"></i>Klik untuk pilih gambar
                                </p>
                                <p style="color:#b2bec3; font-size:0.72em; margin:4px 0 0;">JPG, JPEG, PNG, WEBP (Maks. 2MB)</p>
                            </div>
                            <input type="file" id="imageUpload" name="image" accept="image/*"
                                   style="display:none;" onchange="previewImage(this)">
                        </div>
                    </div>

                    {{-- Waktu, Kesulitan, Porsi --}}
                    <div class="form-row-3" style="margin-bottom:16px;">
                        <div class="form-group">
                            <label>Waktu Masak (menit) *</label>
                            <input type="number" name="time" class="form-control"
                                   value="{{ old('time', 15) }}" min="1">
                        </div>
                        <div class="form-group">
                            <label>Tingkat Kesulitan *</label>
                            <select name="difficulty" class="form-control">
                                <option value="mudah" {{ old('difficulty') === 'mudah' ? 'selected' : '' }}>Mudah</option>
                                <option value="sedang" {{ old('difficulty') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="sulit" {{ old('difficulty') === 'sulit' ? 'selected' : '' }}>Sulit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Porsi (orang) *</label>
                            <input type="number" name="portion" class="form-control"
                                   value="{{ old('portion', 1) }}" min="1">
                        </div>
                    </div>

                    <hr class="section-divider">

                    {{-- Bahan --}}
                    <div class="section-title"><i class="fas fa-basket-shopping"></i> Bahan-bahan</div>
                    <div class="form-group">
                        <label>Daftar Bahan * <span class="hint">(pisahkan dengan koma)</span></label>
                        <input type="text" name="ingredients" class="form-control"
                               value="{{ old('ingredients') }}" placeholder="telur, garam, minyak, bawang putih...">
                    </div>

                    <hr class="section-divider">

                    {{-- Langkah Memasak --}}
                    <div class="section-title"><i class="fas fa-list-ol"></i> Langkah Memasak</div>
                    <p style="font-size:0.78em;color:#b2bec3;margin-bottom:14px;">
                        Masukkan menit ke berapa setiap instruksi dijalankan dan tuliskan instruksinya.
                    </p>
                    <div id="stepsContainer">
                        <div class="step-row">
                            <input type="number" name="steps[0][minute]" placeholder="Menit" min="0" class="form-control">
                            <textarea name="steps[0][text]" rows="2" placeholder="Instruksi langkah ini..." class="form-control"></textarea>
                            <button type="button" class="btn-remove-step" onclick="removeStep(this)"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button type="button" class="btn-add-step" onclick="addStep()" style="margin-top:8px;">
                        <i class="fas fa-plus"></i> Tambah Langkah
                    </button>
                </div>

                <hr class="section-divider">

                {{-- Nama pengirim --}}
                <div class="form-group">
                    <label>Namamu <span class="hint">(opsional — akan ditampilkan jika jadi resep)</span></label>
                    <input type="text" name="pengirim" class="form-control"
                           value="{{ old('pengirim') }}" placeholder="cth: Siti, Budi... (kosongkan jika anonim)">
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> <span id="submitText">Kirim Saran</span>
                </button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Aplikasi Rekomendasi Menu Masakan | Rangga Pratama</p>
    </footer>

    <script>
        function toggleFields() {
            const isResep = document.getElementById('jenis_resep').checked;
            document.getElementById('extraFields').classList.toggle('show', isResep);
            document.getElementById('saranFields').classList.toggle('hide', isResep);
            document.getElementById('submitText').textContent = isResep ? 'Kirim Usulan Resep' : 'Kirim Saran';
        }
        // Pastikan state awal benar
        toggleFields();

        // Preview gambar sebelum upload
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('dropZone').style.borderColor = '#e67e22';
                    document.getElementById('dropZone').style.background = '#fff8f1';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Langkah memasak (tambah/hapus)
        let stepCount = 1;
        function addStep() {
            const c = document.getElementById('stepsContainer');
            const div = document.createElement('div');
            div.className = 'step-row';
            div.innerHTML = `
                <input type="number" name="steps[${stepCount}][minute]" placeholder="Menit" min="0" class="form-control">
                <textarea name="steps[${stepCount}][text]" rows="2" placeholder="Instruksi langkah ini..." class="form-control"></textarea>
                <button type="button" class="btn-remove-step" onclick="removeStep(this)"><i class="fas fa-times"></i></button>
            `;
            c.appendChild(div);
            stepCount++;
        }
        function removeStep(btn) {
            const rows = document.querySelectorAll('.step-row');
            if (rows.length > 1) btn.closest('.step-row').remove();
        }
    </script>
</body>
</html>
