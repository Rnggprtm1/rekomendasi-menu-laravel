// ==========================================
// BAGIAN DETAIL RESEP & NAVIGASI UI
// ==========================================

let activeRecipe = null;
let currentPanel = 0; // 0 = marinate panel, 1 = cook panel

function openRecipe(id) {
    activeRecipe = recipes.find(r => r.id == id);

    // Sembunyikan area pencarian, tampilkan detail
    document.getElementById("searchArea").style.display = "none";
    document.getElementById("resultArea").style.display = "none";
    document.getElementById("recipeDetail").style.display = "block";

    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Isi informasi dasar
    document.getElementById("recipeTitle").innerText = activeRecipe.name;
    document.getElementById("recipeTime").innerText = activeRecipe.time + " menit";
    document.getElementById("recipeDifficulty").innerText = activeRecipe.difficulty;
    document.getElementById("recipePortion").innerText = activeRecipe.portion;
    document.getElementById("recipeImage").src = activeRecipe.image;

    // Isi bahan-bahan
    let ingredientsList = document.getElementById("detailIngredients");
    ingredientsList.innerHTML = "";
    (activeRecipe.ingredients || []).forEach(ing => {
        let li = document.createElement("li");
        li.innerHTML = "<i class='fas fa-circle-dot' style='color:#e67e22;font-size:10px;margin-right:10px;transform:translateY(-2px);'></i>" + ing;
        ingredientsList.appendChild(li);
    });

    const hasMarinate = (activeRecipe.marinate_time || 0) > 0;

    // ---- PANEL NAV ----
    const panelNav = document.getElementById('panelNav');
    const panelsTrack = document.getElementById('panelsTrack');

    if (hasMarinate) {
        panelNav.style.display = 'flex';
        renderMarinatePanel();
        renderCookPanel();
        // Init marinate timer
        marinateTotalSeconds = activeRecipe.marinate_time * 60;
        updateMarinateDisplay();
        resetMarinateTimerButtons();
        document.getElementById("marinateInstructionText").innerText = "Tekan 'Mulai' untuk memulai timer marinasi";
        // Start on marinate panel
        currentPanel = 0;
    } else {
        panelNav.style.display = 'none';
        renderCookPanel();
        // Jump to cook panel (panel index 1)
        currentPanel = 1;
    }

    // Init cook timer
    totalSeconds = activeRecipe.time * 60;
    updateDisplay();
    resetCookTimerButtons();
    document.getElementById("instructionText").innerText = "Tekan 'Mulai' untuk menjalankan timer pintar";

    // Apply panel position
    updatePanelPosition(false); // no animation on open

    history.pushState({ view: 'detail' }, "Detail Resep", "#detail");
}

function renderMarinatePanel() {
    const list = document.getElementById("marinateSteps");
    list.innerHTML = "";
    const marinateSteps = (activeRecipe.steps || []).filter(s => s.type === 'marinate');

    if (marinateSteps.length === 0) {
        const li = document.createElement("li");
        li.innerHTML = "<em style='color:#b2bec3'>Tidak ada langkah marinasi untuk resep ini.</em>";
        list.appendChild(li);
    } else {
        marinateSteps.forEach(step => {
            const li = document.createElement("li");
            li.style.lineHeight = "1.7";
            li.style.marginBottom = "8px";
            li.innerHTML = step.text;
            list.appendChild(li);
        });
    }
}

function renderCookPanel() {
    const list = document.getElementById("cookSteps");
    list.innerHTML = "";
    const nonMarinateSteps = (activeRecipe.steps || []).filter(s => s.type !== 'marinate');

    let langkahCount = 0;
    nonMarinateSteps.forEach(step => {
        const li = document.createElement("li");
        li.style.marginBottom = "10px";
        li.style.lineHeight = "1.65";
        if (step.type === 'prep') {
            langkahCount++;
            li.innerHTML = `<span class="step-label-prep">Langkah ${langkahCount}:</span> <span style="color:#636e72">${step.text}</span>`;
        } else { // cook
            li.innerHTML = `<span class="cook-badge">Menit ke-${step.minute}</span> ${step.text}`;
        }
        list.appendChild(li);
    });
}

// ==========================================
// NAVIGASI PANEL
// ==========================================

function updatePanelPosition(animate) {
    const wrapper = document.getElementById('panelsWrapper');
    const track = document.getElementById('panelsTrack');

    if (!animate) {
        track.style.transition = 'none';
    } else {
        track.style.transition = 'transform 0.45s cubic-bezier(0.25, 0.8, 0.25, 1)';
    }

    const panelWidth = wrapper.offsetWidth;
    
    // Set width setiap panel agar slider tidak berantakan
    document.querySelectorAll('.recipe-panel').forEach(panel => {
        panel.style.width = panelWidth + 'px';
    });
    
    track.style.transform = `translateX(${-panelWidth * currentPanel}px)`;

    // Dot indicators
    document.querySelectorAll('.panel-dot').forEach((dot, i) => {
        dot.classList.toggle('active', i === currentPanel);
    });

    // Arrow button states
    const btnPrev = document.getElementById('btnPrevPanel');
    const btnNext = document.getElementById('btnNextPanel');
    if (btnPrev) btnPrev.disabled = (currentPanel === 0);
    if (btnNext) btnNext.disabled = (currentPanel === 1);

    // Panel label
    const label = document.getElementById('panelLabel');
    if (label) {
        label.innerText = currentPanel === 0 ? 'Marinasi' : 'Memasak';
    }

    // Restore transition after forced instant snap
    if (!animate) {
        setTimeout(() => {
            track.style.transition = 'transform 0.45s cubic-bezier(0.25, 0.8, 0.25, 1)';
        }, 50);
    }
}

function prevPanel() {
    if (currentPanel > 0) {
        currentPanel--;
        updatePanelPosition(true);
    }
}

function nextPanel() {
    if (currentPanel < 1) {
        currentPanel++;
        updatePanelPosition(true);
    }
}

// ==========================================
// TUTUP RESEP
// ==========================================

function closeRecipe(isManual = true) {
    document.getElementById("searchArea").style.display = "block";
    document.getElementById("resultArea").style.display = "block";
    document.getElementById("recipeDetail").style.display = "none";

    pauseTimer();
    pauseMarinateTimer();
    activeRecipe = null;
    searchRecipes();

    if (isManual && window.location.hash === "#detail") {
        history.back();
    }
}

function resetCookTimerButtons() {
    document.getElementById("btnMulai").style.display = "";
    document.getElementById("btnPause").style.display = "none";
    document.getElementById("btnReset").style.display = "none";
}

function resetMarinateTimerButtons() {
    document.getElementById("btnMarinateMulai").style.display = "";
    document.getElementById("btnMarinatePause").style.display = "none";
    document.getElementById("btnMarinateReset").style.display = "none";
}

window.onpopstate = function(event) {
    if (activeRecipe) {
        closeRecipe(false);
    }
};

// Re-calculate panel width on resize
window.addEventListener('resize', function() {
    if (activeRecipe) {
        updatePanelPosition(false);
    }
});