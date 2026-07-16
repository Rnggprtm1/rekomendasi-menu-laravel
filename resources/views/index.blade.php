<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Website rekomendasi menu masakan berdasarkan bahan yang tersedia di dapurmu. Temukan resep lezat dengan mudah!">
    <title>Rekomendasi Menu Masakan</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <header class="header">
        <h1><i class="fas fa-utensils"></i> Rekomendasi Menu <i class="fas fa-utensils"></i></h1>
        <p>✨ Cari inspirasi masakan lezat dari bahan yang tersedia di dapurmu ✨</p>
    </header>

    <section class="search-area" id="searchArea">
        <h2><i class="fas fa-carrot"></i> Masukkan Bahan</h2>
        <div class="input-area">
            <input type="text" id="ingredientInput" placeholder="Contoh: telur, ayam, nasi...">
            <button class="add-button" onclick="addIngredient()">
                <i class="fas fa-plus"></i> Tambah
            </button>
        </div>

        <div class="ingredient-box">
            <h3><i class="fas fa-list-check"></i> Bahan yang dipilih:</h3>
            <ul id="ingredientList"></ul>
        </div>

        <div class="action-buttons">
            <button class="search-button" onclick="searchRecipes()">
                <i class="fas fa-search"></i> Cari Resep
            </button>
        </div>
    </section>

    <section class="result-area" id="resultArea">
        <h2><i class="fas fa-bell-concierge"></i> Hasil Rekomendasi</h2>
        <div id="recipeResults" class="recipe-grid"></div>
    </section>

    <section id="recipeDetail" class="recipe-detail">
        <h2 id="recipeTitle"></h2>
        <img id="recipeImage" alt="Gambar Hasil Masakan">

        <div class="recipe-info">
            <p><i class="fas fa-clock"></i> Waktu : <span id="recipeTime"></span></p>
            <p><i class="fas fa-fire"></i> Kesulitan : <span id="recipeDifficulty"></span></p>
            <p><i class="fas fa-users"></i> Porsi : <span id="recipePortion"></span></p>
        </div>

        <div class="ingredient-section">
            <h3><i class="fas fa-basket-shopping"></i> Bahan-bahan</h3>
            <ul id="detailIngredients"></ul>
        </div>

        <div class="step-section">
            <h3><i class="fas fa-list-ol"></i> Langkah Memasak</h3>
            <ol id="detailSteps"></ol>
        </div>

        <div class="timer-section">
            <h3><i class="fas fa-stopwatch"></i> Timer Pintar</h3>
            <div id="timerDisplay">
                <span id="minutes">00</span> :
                <span id="seconds">00</span>
            </div>

            <div class="timer-controls">
                <button class="timer-button" id="btnMulai" onclick="startTimer()"><i class="fas fa-play"></i> Mulai</button>
                <button class="timer-button" id="btnPause" onclick="pauseTimer()" style="display:none"><i class="fas fa-pause"></i> Pause</button>
                <button class="timer-button" id="btnReset" onclick="resetTimer()" style="display:none"><i class="fas fa-stop"></i> Reset</button>
            </div>

            <p id="instructionText"></p>
        </div>

        <button class="back-button" onclick="closeRecipe()">
            <i class="fas fa-arrow-left"></i> Kembali ke Pencarian
        </button>
    </section>

    {{-- Tombol Kotak Saran --}}
    <div style="text-align:center; padding: 20px 20px 50px; margin-top: 10px;">
        <p style="color:#b2bec3; font-size:0.88em; margin-bottom:14px;">
            Punya resep favorit atau masukan untuk kami?
        </p>
        <a href="{{ route('saran') }}" style="
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #f39c12, #d35400);
            color: white;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95em;
            box-shadow: 0 8px 20px rgba(230,126,34,0.3);
            transition: all 0.3s ease;
        " onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 14px 28px rgba(230,126,34,0.45)'"
           onmouseout="this.style.transform='';this.style.boxShadow='0 8px 20px rgba(230,126,34,0.3)'">
            <i class="fas fa-comment-dots"></i> Kirim Saran / Usulan Resep
        </a>
    </div>

    <footer>
        <p>&copy; 2026 Aplikasi Rekomendasi Menu Masakan | Rangga Pratama</p>
    </footer>


    {{-- Data resep dari MongoDB diinject langsung ke JavaScript --}}
    <script>
        const recipes = {!! json_encode($recipes->map(function($r) {
            return [
                'id'          => (int) $r->id,
                'name'        => $r->name,
                'ingredients' => $r->ingredients,
                'time'        => (int) $r->time,
                'difficulty'  => $r->difficulty,
                'portion'     => (int) $r->portion,
                'image'       => $r->image,
                'steps'       => $r->steps,
            ];
        })->values()) !!};
    </script>

    <script src="{{ asset('js/search.js') }}"></script>
    <script src="{{ asset('js/ui.js') }}"></script>
    <script src="{{ asset('js/timer.js') }}"></script>
</body>

</html>
