// ==========================================
// TIMER MEMASAK (Panel 2)
// ==========================================

let timer = null;
let totalSeconds = 0;
let isTimerRunning = false;

function updateDisplay() {
    let minutes = Math.floor(totalSeconds / 60);
    let seconds = totalSeconds % 60;

    document.getElementById("minutes").innerText = minutes < 10 ? "0" + minutes : minutes;
    document.getElementById("seconds").innerText = seconds < 10 ? "0" + seconds : seconds;

    // Cek instruksi step berdasarkan menit saat ini
    if (isTimerRunning && activeRecipe && seconds === 0) {
        let cookStep = (activeRecipe.steps || []).find(
            s => s.minute > 0 && s.minute === minutes
        );
        if (cookStep) {
            document.getElementById("instructionText").innerHTML =
                "<i class='fas fa-bell fa-shake'></i> \uD83D\uDC49 <strong>Instruksi:</strong> " + cookStep.text;
            playStepSound();
        }
    }
}

function startTimer() {
    if (timer !== null) return;

    document.getElementById("btnMulai").style.display = "none";
    document.getElementById("btnPause").style.display = "";
    document.getElementById("btnReset").style.display = "";

    isTimerRunning = true;
    playStartSound();

    // Tampilkan instruksi yang sesuai menit awal timer
    if (activeRecipe) {
        const startMinutes = Math.floor(totalSeconds / 60);
        const firstCookStep = (activeRecipe.steps || []).find(s => s.minute > 0 && s.minute === startMinutes)
            || (activeRecipe.steps || []).find(s => s.minute > 0); // fallback: step pertama yang ada menit-nya
        if (firstCookStep) {
            document.getElementById("instructionText").innerHTML =
                "<i class='fas fa-bell fa-shake'></i> \uD83D\uDC49 <strong>Instruksi:</strong> " + firstCookStep.text;
        }
    }

    timer = setInterval(function () {
        if (totalSeconds > 0) {
            totalSeconds--;
            updateDisplay();
        } else {
            clearInterval(timer);
            timer = null;
            isTimerRunning = false;

            document.getElementById("btnMulai").style.display = "";
            document.getElementById("btnPause").style.display = "none";
            document.getElementById("btnReset").style.display = "none";
            document.getElementById("instructionText").innerHTML =
                "<i class='fas fa-party-horn'></i> Waktu memasak selesai! Sajikan selagi hangat! \uD83C\uDF89";
            playFinishSound();
        }
    }, 1000);
}

function pauseTimer() {
    clearInterval(timer);
    timer = null;
    isTimerRunning = false;

    document.getElementById("btnMulai").style.display = "";
    document.getElementById("btnPause").style.display = "none";
    document.getElementById("btnReset").style.display = "";

    playPauseSound();
}

function resetTimer() {
    clearInterval(timer);
    timer = null;
    isTimerRunning = false;

    totalSeconds = activeRecipe ? activeRecipe.time * 60 : 0;

    document.getElementById("btnMulai").style.display = "";
    document.getElementById("btnPause").style.display = "none";
    document.getElementById("btnReset").style.display = "none";
    document.getElementById("instructionText").innerText = "Tekan 'Mulai' untuk menjalankan timer pintar";
    updateDisplay();

    playResetSound();
}

// ==========================================
// TIMER MARINASI (Panel 1)
// ==========================================

let marinateTimer = null;
let marinateTotalSeconds = 0;
let isMarinateRunning = false;

function updateMarinateDisplay() {
    let minutes = Math.floor(marinateTotalSeconds / 60);
    let seconds = marinateTotalSeconds % 60;

    document.getElementById("marinateMinutes").innerText = minutes < 10 ? "0" + minutes : minutes;
    document.getElementById("marinateSeconds").innerText = seconds < 10 ? "0" + seconds : seconds;
}

function startMarinateTimer() {
    if (marinateTimer !== null) return;

    document.getElementById("btnMarinateMulai").style.display = "none";
    document.getElementById("btnMarinatePause").style.display = "";
    document.getElementById("btnMarinateReset").style.display = "";

    isMarinateRunning = true;
    playStartSound();

    document.getElementById("marinateInstructionText").innerHTML =
        "<i class='fas fa-hourglass-start'></i> Marinasi sedang berjalan... ⏳";

    marinateTimer = setInterval(function () {
        if (marinateTotalSeconds > 0) {
            marinateTotalSeconds--;
            updateMarinateDisplay();
        } else {
            clearInterval(marinateTimer);
            marinateTimer = null;
            isMarinateRunning = false;

            document.getElementById("btnMarinateMulai").style.display = "";
            document.getElementById("btnMarinatePause").style.display = "none";
            document.getElementById("btnMarinateReset").style.display = "none";

            // Notifikasi 3x sesuai permintaan
            document.getElementById("marinateInstructionText").innerHTML =
                "<i class='fas fa-party-horn'></i> Marinasi Selesai! Marinasi Selesai! Marinasi Selesai! \uD83C\uDF89";
            playFinishSound();

            // Auto-pindah ke panel memasak setelah 2 detik
            setTimeout(function() { nextPanel(); }, 2000);
        }
    }, 1000);
}

function pauseMarinateTimer() {
    clearInterval(marinateTimer);
    marinateTimer = null;
    isMarinateRunning = false;

    document.getElementById("btnMarinateMulai").style.display = "";
    document.getElementById("btnMarinatePause").style.display = "none";
    document.getElementById("btnMarinateReset").style.display = "";

    playPauseSound();
}

function resetMarinateTimer() {
    clearInterval(marinateTimer);
    marinateTimer = null;
    isMarinateRunning = false;

    marinateTotalSeconds = activeRecipe ? (activeRecipe.marinate_time || 0) * 60 : 0;

    document.getElementById("btnMarinateMulai").style.display = "";
    document.getElementById("btnMarinatePause").style.display = "none";
    document.getElementById("btnMarinateReset").style.display = "none";
    document.getElementById("marinateInstructionText").innerText = "Tekan 'Mulai' untuk memulai timer marinasi";
    updateMarinateDisplay();

    playResetSound();
}

// ==========================================
// SISTEM SUARA (Web Audio API)
// ==========================================

function getAudioContext() {
    if (!window._audioCtx) {
        window._audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
    return window._audioCtx;
}

function playTone(freq, type, volume, startOffset, duration) {
    const ctx = getAudioContext();
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();

    osc.connect(gain);
    gain.connect(ctx.destination);

    osc.type = type;
    osc.frequency.setValueAtTime(freq, ctx.currentTime + startOffset);
    gain.gain.setValueAtTime(0, ctx.currentTime + startOffset);
    gain.gain.linearRampToValueAtTime(volume, ctx.currentTime + startOffset + 0.01);
    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + startOffset + duration);

    osc.start(ctx.currentTime + startOffset);
    osc.stop(ctx.currentTime + startOffset + duration + 0.02);
}

function playStartSound() {
    try {
        playTone(523.25, "sine", 0.4, 0.0, 0.12);
        playTone(659.25, "sine", 0.4, 0.13, 0.14);
    } catch(e) { console.warn("Audio error:", e); }
}

function playPauseSound() {
    try {
        playTone(440, "sine", 0.35, 0.0, 0.12);
        playTone(349.23, "sine", 0.25, 0.13, 0.14);
    } catch(e) { console.warn("Audio error:", e); }
}

function playResetSound() {
    try {
        playTone(392, "sine", 0.3, 0.0, 0.18);
    } catch(e) { console.warn("Audio error:", e); }
}

function playStepSound() {
    try {
        playTone(880, "sine", 0.5, 0.00, 0.14);
        playTone(880, "sine", 0.5, 0.18, 0.14);
    } catch(e) { console.warn("Audio error:", e); }
}

function playFinishSound() {
    try {
        const notes = [
            [0.0,  523.25, 0.18],
            [0.2,  659.25, 0.18],
            [0.4,  783.99, 0.18],
            [0.65, 1046.5, 0.4 ],
        ];
        notes.forEach(([start, freq, dur]) => playTone(freq, "triangle", 0.45, start, dur));
    } catch(e) { console.warn("Audio error:", e); }
}