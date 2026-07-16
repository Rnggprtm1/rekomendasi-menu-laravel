// ==========================================
// LOGIKA MESIN TIMER
// ==========================================

let timer = null;
let totalSeconds = 0;
let isTimerRunning = false; // Flag: timer sedang aktif berjalan atau tidak

function updateDisplay() {
    let minutes = Math.floor(totalSeconds / 60);
    let seconds = totalSeconds % 60;

    let displayM = minutes < 10 ? "0" + minutes : minutes;
    let displayS = seconds < 10 ? "0" + seconds : seconds;

    document.getElementById("minutes").innerText = displayM;
    document.getElementById("seconds").innerText = displayS;

    // Hanya cek instruksi + bunyi kalau timer SEDANG berjalan (bukan saat buka resep)
    if (isTimerRunning && activeRecipe && seconds === 0) {
        let currentStep = activeRecipe.steps.find(step => step.minute === minutes);
        if (currentStep) {
            document.getElementById("instructionText").innerHTML = `<i class='fas fa-bell fa-shake'></i> 👉 <strong>Instruksi:</strong> ${currentStep.text}`;
            playStepSound();
        }
    }
}

function startTimer() {
    if (timer !== null) return;

    // Tampilkan Pause & Reset, sembunyikan Mulai
    document.getElementById("btnMulai").style.display = "none";
    document.getElementById("btnPause").style.display = "";
    document.getElementById("btnReset").style.display = "";

    isTimerRunning = true;
    playStartSound();

    timer = setInterval(function () {
        if (totalSeconds > 0) {
            totalSeconds--;
            updateDisplay();
        } else {
            clearInterval(timer);
            timer = null;
            isTimerRunning = false;

            // Kembalikan tombol ke state awal saat timer selesai
            document.getElementById("btnMulai").style.display = "";
            document.getElementById("btnPause").style.display = "none";
            document.getElementById("btnReset").style.display = "none";
            document.getElementById("instructionText").innerHTML = "<i class='fas fa-party-horn'></i> Waktu memasak selesai! Sajikan selagi hangat! 🎉";
            playFinishSound();
        }
    }, 1000);
}

function pauseTimer() {
    clearInterval(timer);
    timer = null;
    isTimerRunning = false;

    // Kembalikan tombol Mulai (sebagai resume), sembunyikan Pause
    document.getElementById("btnMulai").style.display = "";
    document.getElementById("btnPause").style.display = "none";
    // Reset tetap terlihat saat pause
    document.getElementById("btnReset").style.display = "";

    playPauseSound();
}

function resetTimer() {
    clearInterval(timer);
    timer = null;
    isTimerRunning = false;

    if (activeRecipe) {
        totalSeconds = activeRecipe.time * 60;
    } else {
        totalSeconds = 0;
    }

    // Kembalikan ke state awal: hanya Mulai
    document.getElementById("btnMulai").style.display = "";
    document.getElementById("btnPause").style.display = "none";
    document.getElementById("btnReset").style.display = "none";

    document.getElementById("instructionText").innerText = "Tekan 'Mulai' untuk menjalankan timer pintar";
    updateDisplay();

    playResetSound();
}

// ==========================================
// SISTEM SUARA (Web Audio API)
// ==========================================

// Lazy-init AudioContext (harus setelah user gesture)
function getAudioContext() {
    if (!window._audioCtx) {
        window._audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    }
    return window._audioCtx;
}

// Helper: main 1 nada
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

// 🟢 Suara MULAI: nada naik pendek (do-mi)
function playStartSound() {
    try {
        playTone(523.25, "sine", 0.4, 0.0, 0.12); // C5
        playTone(659.25, "sine", 0.4, 0.13, 0.14); // E5
    } catch(e) { console.warn("Audio error:", e); }
}

// ⏸ Suara PAUSE: satu nada pendek turun
function playPauseSound() {
    try {
        playTone(440, "sine", 0.35, 0.0, 0.12); // A4
        playTone(349.23, "sine", 0.25, 0.13, 0.14); // F4
    } catch(e) { console.warn("Audio error:", e); }
}

// ⏹ Suara RESET: satu beep pendek netral
function playResetSound() {
    try {
        playTone(392, "sine", 0.3, 0.0, 0.18); // G4
    } catch(e) { console.warn("Audio error:", e); }
}

// 🔔 Suara PERGANTIAN LANGKAH: 2 beep pendek & nyaring
function playStepSound() {
    try {
        playTone(880, "sine", 0.5, 0.00, 0.14); // A5 beep 1
        playTone(880, "sine", 0.5, 0.18, 0.14); // A5 beep 2
    } catch(e) { console.warn("Audio error:", e); }
}

// 🎉 Suara SELESAI MEMASAK: fanfare 4 nada naik
function playFinishSound() {
    try {
        const notes = [
            [0.0,  523.25, 0.18], // C5
            [0.2,  659.25, 0.18], // E5
            [0.4,  783.99, 0.18], // G5
            [0.65, 1046.5, 0.4 ], // C6 (panjang di akhir)
        ];
        notes.forEach(([start, freq, dur]) => playTone(freq, "triangle", 0.45, start, dur));
    } catch(e) { console.warn("Audio error:", e); }
}