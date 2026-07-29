// ==========================================
// FITUR PENCARIAN & INPUT BAHAN
// ==========================================

const selectedIngredients = [];

// ===========================================
// DAFTAR KATA KUNCI NON-MAKANAN (BLACKLIST)
// ===========================================
const nonFoodKeywords = [
    // Benda / Objek
    'meja', 'kursi', 'buku', 'pena', 'pensil', 'tas', 'sepatu', 'baju', 'celana', 'kaos',
    'handphone', 'hp', 'laptop', 'komputer', 'televisi', 'tv', 'radio', 'kamera', 'jam',
    'mobil', 'motor', 'sepeda', 'pesawat', 'kapal', 'kereta', 'bus', 'truk',
    'rumah', 'gedung', 'kantor', 'sekolah', 'kampus', 'universitas', 'toko', 'mall',
    'pohon', 'bunga', 'tanah', 'batu', 'air', 'api', 'angin', 'udara',
    'plastik', 'kertas', 'kain', 'kayu', 'besi', 'baja', 'kaca', 'tembok',
    // Kata Sifat / Abstrak
    'bagus', 'jelek', 'besar', 'kecil', 'panjang', 'pendek', 'mahal', 'murah',
    'cepat', 'lambat', 'pintar', 'bodoh', 'cantik', 'ganteng', 'baik', 'jahat',
    'senang', 'sedih', 'marah', 'takut', 'cinta', 'benci', 'rindu',
    // Kata Kerja
    'makan', 'minum', 'tidur', 'bangun', 'pergi', 'datang', 'lari', 'jalan',
    'belajar', 'kerja', 'bermain', 'menangis', 'tertawa', 'berteriak', 'diam',
    'membeli', 'menjual', 'mencuci', 'memasak', 'membaca', 'menulis', 'menggambar',
    // Nama Orang / Tempat
    'indonesia', 'jakarta', 'surabaya', 'bandung', 'medan', 'bali', 'jawa', 'sumatra',
    'asia', 'eropa', 'amerika', 'australia', 'dunia', 'bumi', 'bulan', 'matahari', 'bintang',
    // Angka & Simbol
    'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh',
    // Kata Tidak Bermakna
    'asdfjkl', 'qwerty', 'zzzzz', 'aaaaa', 'bbbbb', 'xxxxx', 'haha', 'hehe', 'wkwk',
    'test', 'tes', 'testing', 'abc', 'xyz', 'blah', 'lorem', 'ipsum',
];

// ===========================================
// DAFTAR BAHAN MAKANAN UMUM (WHITELIST)
// ===========================================
const foodKeywords = [
    // Protein Hewani
    'ayam', 'daging', 'sapi', 'kambing', 'babi', 'ikan', 'udang', 'cumi', 'kepiting', 'kerang',
    'telur', 'bebek', 'domba', 'kalkun', 'lele', 'gurame', 'nila', 'kakap', 'salmon', 'tuna',
    'tongkol', 'cakalang', 'bandeng', 'bawal', 'teri', 'patin', 'mas', 'mujair', 'gabus',
    'keju', 'susu', 'yogurt', 'mentega', 'krim', 'mayones',
    // Protein Nabati
    'tahu', 'tempe', 'kacang', 'kedelai', 'edamame', 'polong', 'lentil', 'miju',
    // Karbohidrat
    'nasi', 'beras', 'mi', 'mie', 'mee', 'pasta', 'spageti', 'makaroni', 'fettuccine',
    'roti', 'kentang', 'singkong', 'ubi', 'talas', 'jagung', 'sagu', 'tepung', 'terigu',
    'kwetiau', 'bihun', 'soun', 'sohun', 'oatmeal', 'havermut',
    // Sayuran
    'bayam', 'kangkung', 'sawi', 'kubis', 'kol', 'brokoli', 'kembang kol', 'wortel',
    'tomat', 'mentimun', 'timun', 'terong', 'labu', 'oyong', 'pare', 'buncis', 'kacang panjang',
    'daun', 'seledri', 'selada', 'lettuce', 'spinach', 'asparagus', 'jamur', 'champignon',
    'lobak', 'bit', 'artichoke', 'paprika', 'cabai', 'cabe', 'lombok', 'rawit',
    'daun bawang', 'bawang', 'merah', 'putih', 'bombay', 'leek', 'daun salam', 'salam',
    'daun pandan', 'pandan', 'daun jeruk', 'daun kunyit', 'daun kemangi', 'kemangi',
    'daun singkong', 'daun pepaya', 'daun pakis', 'pakis',
    // Buah
    'pisang', 'mangga', 'pepaya', 'nanas', 'semangka', 'melon', 'jeruk', 'apel', 'pir',
    'anggur', 'strawberry', 'blueberry', 'raspberry', 'alpukat', 'kelapa', 'lemon',
    'limau', 'rambutan', 'leci', 'manggis', 'durian', 'salak', 'belimbing', 'jambu',
    'sawo', 'nangka', 'cempedak', 'sukun', 'sirsak', 'markisa', 'buah naga', 'kiwi',
    // Bumbu & Rempah
    'garam', 'gula', 'merica', 'lada', 'ketumbar', 'kunyit', 'jahe', 'lengkuas', 'laos',
    'sereh', 'serai', 'kayu manis', 'cengkeh', 'pala', 'kapulaga', 'jintan', 'adas',
    'kemiri', 'terasi', 'belacan', 'petis', 'tauco', 'tauco', 'ebi', 'rebon',
    'kecap', 'saus', 'sambal', 'saos', 'cuka', 'asam', 'belimbing wuluh', 'wuluh',
    'minyak', 'margarin', 'santan', 'coconut milk', 'susu kental',
    'kaldu', 'bouillon', 'royco', 'masako', 'vetsin', 'msg', 'ajinomoto',
    'kari', 'curry', 'bumbu', 'rempah', 'isian',
    // Bahan Pelengkap
    'maizena', 'baking', 'soda', 'powder', 'ragi', 'vanili', 'vanila', 'coklat', 'kakao',
    'cokelat', 'selai', 'jam', 'sirup', 'madu', 'gula merah', 'gula jawa', 'gula aren',
    'agar', 'gelatin', 'jelly', 'pudding', 'puding', 'es krim', 'krim', 'topping',
];

/**
 * Cek apakah input adalah bahan makanan
 * Logika: jika ada di blacklist = bukan makanan.
 *         jika ada di whitelist = makanan.
 *         jika tidak ada di keduanya = cek apakah input cuma simbol / angka / terlalu pendek.
 */
function isFoodIngredient(value) {
    const cleaned = value.trim().toLowerCase();

    // Tolak jika terlalu pendek (1 karakter)
    if (cleaned.length < 2) return false;

    // Tolak jika isinya cuma angka atau simbol
    if (/^[\d\s\W]+$/.test(cleaned)) return false;

    // Tolak jika ada di daftar non-makanan (blacklist)
    for (let keyword of nonFoodKeywords) {
        if (cleaned === keyword || cleaned.includes(keyword)) {
            // Hanya blacklist jika kata blacklist adalah kata utama, bukan sebagian kata makanan
            if (cleaned.split(' ').some(word => word === keyword)) return false;
        }
    }

    // Lolos jika ada di daftar makanan (whitelist)
    for (let keyword of foodKeywords) {
        if (cleaned.includes(keyword) || keyword.includes(cleaned)) return true;
    }

    // Fallback: jika tidak ada di keduanya, kita anggap MUNGKIN makanan
    // (supaya bahan baru/tidak umum tetap bisa diinput)
    // Namun jika panjangnya < 3, tolak
    return cleaned.length >= 3;
}

function showWarning(message) {
    let warning = document.getElementById('ingredientWarning');
    if (!warning) return;
    warning.innerHTML = `<i class="fas fa-triangle-exclamation"></i> ${message}`;
    warning.classList.add('show');
    clearTimeout(warning._hideTimer);
    warning._hideTimer = setTimeout(() => {
        warning.classList.remove('show');
    }, 3500);
}

function hideWarning() {
    let warning = document.getElementById('ingredientWarning');
    if (warning) warning.classList.remove('show');
}

function addIngredient() {
    let input = document.getElementById("ingredientInput");
    let rawValue = input.value.trim().toLowerCase();

    // Validasi 1: Cegah input kosong
    if (rawValue === "") return;

    // Validasi 2: Hanya boleh 1 bahan
    if (selectedIngredients.length >= 1) {
        showWarning("Kamu hanya bisa memasukkan <strong>1 bahan</strong> saja. Hapus bahan yang ada dulu sebelum menambah yang baru!");
        input.value = "";
        input.focus();
        return;
    }

    // Validasi 3: Harus bahan makanan
    if (!isFoodIngredient(rawValue)) {
        showWarning(`"<strong>${rawValue}</strong>" bukan bahan makanan. Masukkan bahan makanan yang valid, seperti: <em>ayam, telur, tempe, wortel</em>, dll.`);
        input.value = "";
        input.focus();
        return;
    }

    // Validasi 4: Cegah bahan duplikat
    if (selectedIngredients.includes(rawValue)) {
        showWarning(`"<strong>${rawValue}</strong>" sudah ada di daftar bahan.`);
        input.value = "";
        input.focus();
        return;
    }

    hideWarning();
    selectedIngredients.push(rawValue);

    let li = document.createElement("li");
    li.dataset.value = rawValue;
    li.innerHTML = `
        <i class='fas fa-check' style='color: #2ecc71; margin-right: 8px;'></i>
        <span>${rawValue}</span>
        <button onclick="removeIngredient(this)" class="delete-ingredient-btn" title="Hapus bahan">
            <i class='fas fa-times'></i>
        </button>
    `;

    document.getElementById("ingredientList").appendChild(li);
    input.value = "";
    input.focus();
}

function removeIngredient(btn) {
    let li = btn.closest("li");
    let value = li.dataset.value;
    let idx = selectedIngredients.indexOf(value);
    if (idx !== -1) {
        selectedIngredients.splice(idx, 1);
    }
    li.remove();
}

// Tekan 'Enter' untuk menambah bahan
document.getElementById("ingredientInput").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        addIngredient();
    }
});

function searchRecipes() {
    let resultContainer = document.getElementById("recipeResults");
    resultContainer.innerHTML = "";

    if (selectedIngredients.length === 0) {
        resultContainer.innerHTML = "<p class='error-msg'><i class='fas fa-exclamation-circle'></i> Silakan masukkan bahan terlebih dahulu!</p>";
        return; 
    }

    let matchedRecipes = [];

    recipes.forEach(recipe => {
        let match = recipe.ingredients.filter(i => selectedIngredients.includes(i));
        let score = match.length / recipe.ingredients.length;

        if (score > 0) {
            // Simpan object resep asli beserta skor kecocokannya
            matchedRecipes.push({
                data: recipe,
                score: score
            });
        }
    });

    // 2. Jika tidak ada resep yang cocok sama sekali
    if (matchedRecipes.length === 0) {
        resultContainer.innerHTML = "<p class='not-found-msg'><i class='fas fa-face-frown-open'></i> Maaf, belum ada masakan dari bahan ini. Coba bahan yang lain, ya!</p>";
        return;
    }

    // 3. LOGIKA SORTING: Urutkan dari persentase tertinggi ke terendah
    matchedRecipes.sort((a, b) => b.score - a.score);

    // 4. Render ke layar menggunakan Template Literals (ES6)
    matchedRecipes.forEach(item => {
        let recipe = item.data; // Ambil data resepnya
        let scorePercentage = Math.round(item.score * 100); // Jadikan persentase

        let card = document.createElement("div");
        card.className = "recipe-card";
        
        // Menggunakan backtick (`) agar kode HTML lebih rapi dan bersih
        card.innerHTML = `
            <img src="${recipe.image}" alt="${recipe.name}">
            <h3>${recipe.name}</h3>
            <p><i class='fas fa-chart-pie' style='color: #e67e22;'></i> Kecocokan: <strong>${scorePercentage}%</strong></p>
            <button onclick='openRecipe(${recipe.id})'><i class='fas fa-eye'></i> Lihat Resep</button>
        `;

        resultContainer.appendChild(card);
    });
}

function resetIngredients() {
    selectedIngredients.length = 0;
    document.getElementById("ingredientList").innerHTML = "";
    document.getElementById("recipeResults").innerHTML = "";
    document.getElementById("ingredientInput").value = "";
}