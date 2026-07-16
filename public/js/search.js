// ==========================================
// FITUR PENCARIAN & INPUT BAHAN
// ==========================================

const selectedIngredients = []

function addIngredient() {
    let input = document.getElementById("ingredientInput");
    let rawValue = input.value.trim().toLowerCase();

    // Validasi 1: Cegah input kosong
    if(rawValue === "") return;

    // Validasi 2: Cegah bahan duplikat
    if(selectedIngredients.includes(rawValue)) {
        input.value = ""; 
        input.placeholder = "Bahan sudah ada!"; 
        setTimeout(() => input.placeholder = "Contoh: telur, ayam, nasi...", 2000);
        return;
    }

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