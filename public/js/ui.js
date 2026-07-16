// ==========================================
// BAGIAN DETAIL RESEP & NAVIGASI UI
// ==========================================

let activeRecipe = null;

function openRecipe(id) {
    activeRecipe = recipes.find(r => r.id == id);

    // Menyembunyikan area pencarian
    document.getElementById("searchArea").style.display = "none";
    document.getElementById("resultArea").style.display = "none";
    
    // Menampilkan area detail
    document.getElementById("recipeDetail").style.display = "block";
    
    // 👇 TAMBAHIN KODE INI BIAR LAYAR OTOMATIS KE ATAS 👇
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Bikin efek scroll-nya mulus, gak langsung loncat kaku
    });
    
    // Mengisi informasi dasar
    document.getElementById("recipeTitle").innerText = activeRecipe.name;
    document.getElementById("recipeTime").innerText = activeRecipe.time + " menit";
    document.getElementById("recipeDifficulty").innerText = activeRecipe.difficulty;
    document.getElementById("recipePortion").innerText = activeRecipe.portion;
    document.getElementById("recipeImage").src = activeRecipe.image; 

    // Mengisi daftar bahan
    let ingredientsList = document.getElementById("detailIngredients");
    ingredientsList.innerHTML = "";
    activeRecipe.ingredients.forEach(ing => {
        let li = document.createElement("li");
        li.innerHTML = "<i class='fas fa-circle-dot' style='color: #e67e22; font-size: 10px; margin-right: 10px; transform: translateY(-2px);'></i>" + ing;
        ingredientsList.appendChild(li);
    });

    // Mengisi langkah-langkah memasak
    let stepsList = document.getElementById("detailSteps");
    stepsList.innerHTML = "";
    activeRecipe.steps.forEach(step => {
        let li = document.createElement("li");
        li.innerHTML = "<strong>Menit ke-" + step.minute + ":</strong> " + step.text;
        stepsList.appendChild(li);
    });

    // Reset teks instruksi
    document.getElementById("instructionText").innerText = "Tekan 'Mulai' untuk menjalankan timer pintar";

    // Set waktu awal timer
    totalSeconds = activeRecipe.time * 60;
    updateDisplay();

    // Manipulasi URL history
    history.pushState({ view: 'detail' }, "Detail Resep", "#detail");
}

function closeRecipe(isManual = true) {
    document.getElementById("searchArea").style.display = "block";
    document.getElementById("resultArea").style.display = "block";
    document.getElementById("recipeDetail").style.display = "none";
    
    pauseTimer();
    activeRecipe = null;
    searchRecipes();

    if (isManual && window.location.hash === "#detail") {
        history.back();
    }
}

window.onpopstate = function(event) {
    if (activeRecipe) {
        closeRecipe(false);
    }
};