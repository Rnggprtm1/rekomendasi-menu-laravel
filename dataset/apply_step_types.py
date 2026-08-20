import json

# Complete step types + minute values for all 23 recipes
# type: "marinate" = Panel 1, "prep" = Panel 2 no menit, "cook" = Panel 2 dengan menit timer
# minute: countdown remaining saat step muncul (hanya untuk cook type)
recipe_data = {
    "Creamy Garlic Butter King Prawn Jacket Potato": {
        "marinate_time": 0, "time": 80,
        "steps": [
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 77},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 14},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 5},
            {"type": "prep",    "minute": 0},
        ]
    },
    "AYAM UDANG RICE PAPER HIGH PROTEIN": {
        "marinate_time": 0, "time": 20,
        "steps": [
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 16},  # airfryer = metode masak utama
        ]
    },
    "Pempek Sutra": {
        "marinate_time": 0, "time": 15,
        "steps": [
            {"type": "cook",    "minute": 12},
            {"type": "cook",    "minute": 2},
        ]
    },
    "Udang Nori": {
        "marinate_time": 0, "time": 20,
        "steps": [
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 5},
        ]
    },
    "Arwah Ayam": {
        "marinate_time": 15, "time": 15,
        "steps": [
            {"type": "marinate","minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 5},
        ]
    },
    "Tahu Saus Tiram": {
        "marinate_time": 0, "time": 25,
        "steps": [
            {"type": "cook",    "minute": 18},
            {"type": "cook",    "minute": 5},
        ]
    },
    "Soup Ayam Simple": {
        "marinate_time": 0, "time": 30,
        "steps": [
            {"type": "cook",    "minute": 30},
            {"type": "cook",    "minute": 23},
            {"type": "cook",    "minute": 18},
            {"type": "cook",    "minute": 8},
            {"type": "prep",    "minute": 0},
        ]
    },
    "Shakshuka": {
        "marinate_time": 0, "time": 20,
        "steps": [
            {"type": "cook",    "minute": 18},
            {"type": "prep",    "minute": 0},
        ]
    },
    "Bola Telur - 2 BAHAN AJA!": {
        "marinate_time": 0, "time": 20,
        "steps": [
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 15},
            {"type": "prep",    "minute": 0},
        ]
    },
    "Chicken Roll": {
        "marinate_time": 60, "time": 20,
        "steps": [
            {"type": "marinate","minute": 0},
            {"type": "cook",    "minute": 15},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 5},
            {"type": "prep",    "minute": 0},
        ]
    },
    "Sop Sengkel": {
        "marinate_time": 0, "time": 60,
        "steps": [
            {"type": "cook",    "minute": 60},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 55},
            {"type": "cook",    "minute": 15},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 8},
            {"type": "prep",    "minute": 0},
        ]
    },
    "Cheese and ham toastie dippers": {
        "marinate_time": 0, "time": 12,
        "steps": [
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 5},
        ]
    },
    "Rolade ayam": {
        "marinate_time": 0, "time": 35,
        "steps": [
            {"type": "cook",    "minute": 35},
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 22},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 15},
            {"type": "prep",    "minute": 0},
        ]
    },
    "Slow cooker beef brisket pasta": {
        "marinate_time": 0, "time": 280,
        "steps": [
            {"type": "cook",    "minute": 280},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 270},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 15},
            {"type": "prep",    "minute": 0},
        ]
    },
    "Chicken Mayo": {
        "marinate_time": 30, "time": 15,
        "steps": [
            {"type": "marinate","minute": 0},
            {"type": "cook",    "minute": 12},
        ]
    },
    "Tumis poleng bawang putih": {
        "marinate_time": 0, "time": 8,
        "steps": [
            {"type": "cook",    "minute": 7},
            {"type": "cook",    "minute": 4},
            {"type": "cook",    "minute": 1},
        ]
    },
    "Potato pizza": {
        "marinate_time": 0, "time": 40,
        "steps": [
            {"type": "cook",    "minute": 38},
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 12},
        ]
    },
    "Tahu bakso ayam tanpa tepung": {
        "marinate_time": 0, "time": 30,
        "steps": [
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 15},
        ]
    },
    "Caramelized garlic butter chicken bite": {
        "marinate_time": 30, "time": 20,
        "steps": [
            {"type": "marinate","minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 18},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 8},
            {"type": "cook",    "minute": 5},
            {"type": "cook",    "minute": 2},
        ]
    },
    "Tangsuyuk pancake": {
        "marinate_time": 30, "time": 10,
        "steps": [
            {"type": "marinate","minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 8},
            {"type": "prep",    "minute": 0},
        ]
    },
    "Mini korean corn dog hack~": {
        "marinate_time": 0, "time": 20,
        "steps": [
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 10},
            {"type": "prep",    "minute": 0},
        ]
    },
    "Creamy chicken lemon": {
        "marinate_time": 30, "time": 20,
        "steps": [
            {"type": "prep",    "minute": 0},   # potong kentang
            {"type": "prep",    "minute": 0},   # airfryer kentang (sudah punya timer sendiri)
            {"type": "marinate","minute": 0},   # marinasi ayam
            {"type": "cook",    "minute": 18},  # masak ayam api kecil
            {"type": "cook",    "minute": 12},  # lelehkan butter
            {"type": "cook",    "minute": 10},  # tumis bawang + tepung
            {"type": "cook",    "minute": 7},   # tuang susu
            {"type": "prep",    "minute": 0},   # seasoning
            {"type": "cook",    "minute": 2},   # aduk + masukkan ayam
        ]
    },
    "Tahu Kukus": {
        "marinate_time": 0, "time": 25,
        "steps": [
            {"type": "prep",    "minute": 0},
            {"type": "prep",    "minute": 0},
            {"type": "cook",    "minute": 15},
        ]
    },
}

# Load JSON
with open('database/data_recipes.json', encoding='utf-8') as f:
    data = json.load(f)

ok = 0
skip = 0
for recipe in data:
    name = recipe['name']
    if name not in recipe_data:
        print(f"NOT FOUND: {name}")
        skip += 1
        continue

    fix = recipe_data[name]
    steps = recipe['steps']
    step_fixes = fix['steps']

    if len(steps) != len(step_fixes):
        print(f"MISMATCH [{name}]: {len(steps)} steps vs {len(step_fixes)} defined")
        skip += 1
        continue

    for i, (step, sf) in enumerate(zip(steps, step_fixes)):
        step['type'] = sf['type']
        step['minute'] = sf['minute']

    recipe['marinate_time'] = fix['marinate_time']
    recipe['time'] = fix['time']
    ok += 1
    mt = fix['marinate_time']
    print(f"OK: {name} | marinate={mt}min | cook={fix['time']}min")

with open('database/data_recipes.json', 'w', encoding='utf-8') as f:
    json.dump(data, f, ensure_ascii=False, indent=4)

print(f"\nDone! Fixed: {ok}, Skipped: {skip}")

# Summary
print("\n--- Resep dengan marinasi (2 panel) ---")
for r in data:
    if r.get('marinate_time', 0) > 0:
        print(f"  {r['name']} -> {r['marinate_time']} menit marinasi")

print("\n--- Resep tanpa marinasi (1 panel) ---")
for r in data:
    if r.get('marinate_time', 0) == 0:
        print(f"  {r['name']}")
