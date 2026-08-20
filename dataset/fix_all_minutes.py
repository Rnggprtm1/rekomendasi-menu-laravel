import json

# Load current data
with open('database/data_recipes.json', encoding='utf-8') as f:
    data = json.load(f)

# Fix semua resep dengan minute=0 berdasarkan urutan dan logika masak
# Format: nama resep -> list menit per step (harus sama jumlahnya dengan steps yang ada)
fixes = {
    "Creamy Garlic Butter King Prawn Jacket Potato": [
        0,   # deskripsi crispy buttery potato (skip/0 = bukan instruksi masak)
        0,   # cook book link (bukan instruksi)
        0,   # header "Potato" (bukan instruksi)
        71,  # pierce microwave 6min + airfry 55min + unwrap 10min = 71
        71,  # header "Prawns"
        73,  # fry prawns 2 min
        73,  # header "Sauce"
        80,  # cook garlic sauce ~5-7 min
        85,  # finish & plate ~5 min
    ],
    "AYAM UDANG RICE PAPER HIGH PROTEIN": [
        5,   # chopper bahan (sekitar 5 menit)
        7,   # wrap pakai rice paper + nori
        23,  # airfryer 170°C 14-16 menit (7+16=23)
    ],
    "Pempek Sutra": [
        3,   # campur adonan dan tuang ke cetakan
        13,  # kukus 10 menit
        18,  # dinginkan, potong, goreng (5 menit)
    ],
    "Udang Nori": [
        10,  # cincang udang + sayuran + tepung maizena
        20,  # balur nori, goreng golden brown
    ],
    "Tahu Saus Tiram": [
        5,   # potong tahu, baluri telur + tepung, goreng
        15,  # tumis bawang + cabai + saus + masukkan tahu
    ],
    "Shakshuka": [
        5,   # tumis bawang bombay + bawang putih
        10,  # masukkan tomat + bumbu
        18,  # masukkan telur, keju, parsley, tunggu matang
        20,  # sajikan dengan sourdough/roti
    ],
    "Chicken Roll": [
        60,  # chopper ayam + seasoning + tepung, diamkan 1 jam di kulkas
        65,  # campurkan bumbu BBQ sauce, tumis perbawangan
        68,  # buat lava filling, campur keju spread + saus BBQ
        75,  # bentuk ayam panjang, baluri tepung roti, goreng
        78,  # masukkan filling ke dalam chicken roll, sajikan
    ],
    "Sop Sengkel": [
        2,   # panaskan air, masukkan daging sengkel
        3,   # didihkan sebentar, buang air
        45,  # ganti air, presto selama 30-40 menit
        48,  # goreng bawang merah + bawang putih terpisah
        50,  # tiriskan setelah kecokelatan
        52,  # buka presto, masukkan bahan 2 + wortel
        55,  # masak hingga wortel matang, koreksi rasa, sajikan
    ],
    "Cheese and ham toastie dippers": [
        5,   # potong kulit roti, oles mentega, susun keju + ham, buat sandwich, slice
        12,  # balur dalam campuran telur + susu, panggang di pan tiap sisi hingga golden brown
    ],
    "Rolade ayam": [
        5,   # tumis bawang putih + daun bawang
        10,  # chopper ayam + bumbu tumis hingga halus, seasoning, masukkan tepung + wortel parut
        12,  # campurkan 3 telur + 3 sdm tapioka + sedikit air untuk kulit
        14,  # masak kulit telur sebentar jangan terlalu kering
        16,  # masukkan adonan ayam ke kulit, gulung
        31,  # bungkus daun pisang, kukus 15 menit
        32,  # angkat, sajikan
    ],
    "Chicken Mayo": [
        5,   # campur semua bumbu + mayonnaise, marinasi
        35,  # marinasi 15-30 menit
        45,  # panggang tanpa minyak hingga kecoklatan
        48,  # tambahkan daun parsley, sajikan
    ],
    "Tahu bakso ayam tanpa tepung": [
        10,  # chopper ayam + telur + daun bawang + seasoning + wortel parut + air
        15,  # potong tahu menjadi dua, isi dengan adonan ayam
        30,  # kukus tahu hingga matang (~15 menit)
    ],
    "Tangsuyuk pancake": [
        30,  # potong ayam, marinasi 30 menit
        33,  # endapkan tepung kentang + air, campur dengan ayam
        38,  # potong daun kucai, mix dengan adonan, goreng di minyak panas
        42,  # buat saus: campurkan semua bahan saus, tuangkan ke ayam
    ],
    "Creamy chicken lemon": [
        3,   # potong kentang panjang, baluri minyak + dry rub, aduk rata
        28,  # air fryer 180°C 25 menit
        43,  # marinasi ayam dengan dry rub 15 menit, masak api kecil hingga matang
        48,  # lelehkan unsalted butter di pan
        50,  # tumis bawang putih + 1 sdm tepung terigu
        52,  # tuangkan susu 250-300ml
        55,  # seasoning: dry rub, kaldu jamur, lada putih, garam, parsley, perasan lemon
        58,  # aduk hingga matang, masukkan ayam, sajikan
    ],
    "Tahu Kukus": [
        8,   # chopper tahu + udang + telur + daun bawang + seasoning
        12,  # tuang adonan ke mangkuk, lapisi kulit gyoza (metode sandwich)
        25,  # kukus hingga matang (~15 menit)
        28,  # sajikan dengan chili oil
    ],
}

# Apply fixes
for recipe in data:
    name = recipe['name']
    if name in fixes:
        minutes = fixes[name]
        steps = recipe['steps']
        if len(minutes) == len(steps):
            for i, step in enumerate(steps):
                step['minute'] = minutes[i]
            print(f"FIXED: {name} ({len(steps)} steps)")
        else:
            print(f"SKIP (mismatch): {name} - {len(steps)} steps vs {len(minutes)} minutes defined")

# Save
with open('database/data_recipes.json', 'w', encoding='utf-8') as f:
    json.dump(data, f, ensure_ascii=False, indent=4)

print("\nDone! JSON saved.")

# Verify
print("\n=== VERIFIKASI AKHIR ===")
for r in data:
    zero = sum(1 for s in r['steps'] if s['minute'] == 0)
    name = r['name']
    steps = len(r['steps'])
    print(f"{name}: {steps} steps, {zero} step dgn minute=0")
