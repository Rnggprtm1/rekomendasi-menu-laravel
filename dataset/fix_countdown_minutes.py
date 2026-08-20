import json

# Setiap resep: time (total menit countdown) dan step_minutes (descending, sisa menit saat step tampil)
# Logika: menit 30 = mulai masak (timer baru jalan), menit 15 = saat 15 menit tersisa, dst.
recipe_fixes = {
    "Creamy Garlic Butter King Prawn Jacket Potato": {
        "time": 80,
        "step_minutes": [80, 79, 78, 77, 15, 14, 8, 5, 1]
    },
    "AYAM UDANG RICE PAPER HIGH PROTEIN": {
        "time": 20,
        "step_minutes": [20, 10, 2]
    },
    "Pempek Sutra": {
        "time": 15,
        "step_minutes": [15, 3]
    },
    "Udang Nori": {
        "time": 20,
        "step_minutes": [20, 5]
    },
    "Arwah Ayam": {
        "time": 30,
        "step_minutes": [30, 25, 15, 5]
    },
    "Tahu Saus Tiram": {
        "time": 25,
        "step_minutes": [25, 8]
    },
    "Soup Ayam Simple": {
        "time": 30,
        "step_minutes": [30, 25, 20, 10, 2]
    },
    "Shakshuka": {
        "time": 20,
        "step_minutes": [20, 3]
    },
    "Bola Telur - 2 BAHAN AJA!": {
        "time": 20,
        "step_minutes": [20, 17, 14, 12, 5, 1]
    },
    "Chicken Roll": {
        "time": 75,
        "step_minutes": [75, 15, 10, 5, 2]
    },
    "Sop Sengkel": {
        "time": 60,
        "step_minutes": [60, 58, 55, 15, 12, 8, 2]
    },
    "Cheese and ham toastie dippers": {
        "time": 12,
        "step_minutes": [12, 5]
    },
    "Rolade ayam": {
        "time": 35,
        "step_minutes": [35, 30, 22, 18, 15, 5, 1]
    },
    "Slow cooker beef brisket pasta": {
        "time": 280,
        "step_minutes": [280, 275, 270, 30, 15, 2]
    },
    "Chicken Mayo": {
        "time": 45,
        "step_minutes": [45, 15]
    },
    "Tumis poleng bawang putih": {
        "time": 8,
        "step_minutes": [8, 5, 2]
    },
    "Potato pizza": {
        "time": 40,
        "step_minutes": [40, 20, 17, 5]
    },
    "Tahu bakso ayam tanpa tepung": {
        "time": 30,
        "step_minutes": [30, 18, 5]
    },
    "Caramelized garlic butter chicken bite": {
        "time": 60,
        "step_minutes": [60, 30, 25, 15, 10, 5, 2]
    },
    "Tangsuyuk pancake": {
        "time": 40,
        "step_minutes": [40, 10, 5, 2]
    },
    "Mini korean corn dog hack~": {
        "time": 20,
        "step_minutes": [20, 18, 15, 10, 2]
    },
    "Creamy chicken lemon": {
        "time": 60,
        "step_minutes": [60, 55, 30, 25, 12, 10, 7, 4, 1]
    },
    "Tahu Kukus": {
        "time": 25,
        "step_minutes": [25, 20, 5]
    },
}

with open('database/data_recipes.json', encoding='utf-8') as f:
    data = json.load(f)

ok = 0
skip = 0
for recipe in data:
    name = recipe['name']
    if name not in recipe_fixes:
        print(f"NOT FOUND in fixes: {name}")
        skip += 1
        continue

    fix = recipe_fixes[name]
    steps = recipe['steps']
    minutes = fix['step_minutes']

    if len(steps) != len(minutes):
        print(f"MISMATCH [{name}]: {len(steps)} steps vs {len(minutes)} minutes defined")
        skip += 1
        continue

    # Apply minutes
    for i, step in enumerate(steps):
        step['minute'] = minutes[i]

    # Update total time
    recipe['time'] = fix['time']
    ok += 1
    print(f"OK: {name} ({len(steps)} steps, time={fix['time']} min)")

with open('database/data_recipes.json', 'w', encoding='utf-8') as f:
    json.dump(data, f, ensure_ascii=False, indent=4)

print(f"\nDone! Fixed: {ok}, Skipped: {skip}")

# Verify order is descending
print("\n=== VERIFIKASI DESCENDING ORDER ===")
errors = 0
for r in data:
    mins = [s['minute'] for s in r['steps']]
    is_desc = all(mins[i] > mins[i+1] for i in range(len(mins)-1))
    name = r['name']
    t = r['time']
    if not is_desc:
        print(f"ERROR not descending [{name}]: {mins}")
        errors += 1
    else:
        print(f"OK [{name}] t={t}: {mins}")

if errors == 0:
    print("\nSemua resep sudah dalam urutan descending yang benar!")
