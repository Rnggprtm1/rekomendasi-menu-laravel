import json

with open('database/data_recipes.json', encoding='utf-8') as f:
    data = json.load(f)

# Fix per-resep yang mismatch atau masih ada minute=0
for recipe in data:
    name = recipe['name']
    steps = recipe['steps']

    if name == "Pempek Sutra":
        # 2 steps: kukus 10 menit, dinginkan+goreng
        steps[0]['minute'] = 10
        steps[1]['minute'] = 15
        print(f"FIXED: {name}")

    elif name == "Shakshuka":
        # 2 steps: tumis bawang+tomat+bumbu, sajikan
        steps[0]['minute'] = 15
        steps[1]['minute'] = 16
        print(f"FIXED: {name}")

    elif name == "Chicken Mayo":
        # 2 steps: marinasi 15-30 menit, panggang hingga matang
        steps[0]['minute'] = 30
        steps[1]['minute'] = 45
        print(f"FIXED: {name}")

    elif name == "Tahu bakso ayam tanpa tepung":
        # 3 steps
        steps[0]['minute'] = 10  # chopper semua
        steps[1]['minute'] = 15  # isi tahu
        steps[2]['minute'] = 30  # kukus 15 menit
        print(f"FIXED: {name}")

    elif name == "Creamy chicken lemon":
        # 9 steps - fix semua yang 0
        minutes_map = [3, 28, 43, 48, 50, 52, 55, 57, 60]
        for i, m in enumerate(minutes_map):
            steps[i]['minute'] = m
        print(f"FIXED: {name}")

    elif name == "Tahu Kukus":
        # 3 steps: chopper, tuang+lapisi gyoza, kukus
        steps[0]['minute'] = 8
        steps[1]['minute'] = 12
        steps[2]['minute'] = 27
        print(f"FIXED: {name}")

    elif name == "Creamy Garlic Butter King Prawn Jacket Potato":
        # 9 steps - step dengan minute=0 adalah deskripsi/header, set ke nilai yg masuk akal
        # step[0]=deskripsi, step[2]=header Potato, step[4]=header Prawns, step[6]=header Sauce
        # steps yang sudah punya nilai non-0 biarkan, yang 0 (deskripsi) biarkan 0 juga
        # Tapi karena 0 bikin undefined di display, set header jadi menit sebelumnya
        steps[0]['minute'] = 1    # intro/deskripsi
        steps[1]['minute'] = 1    # cook book link - jadi info saja
        steps[2]['minute'] = 1    # header Potato
        steps[4]['minute'] = 71   # header Prawns (setelah potato selesai 71 menit)
        steps[6]['minute'] = 74   # header Sauce
        steps[8]['minute'] = 82   # to finish (setelah sauce)
        print(f"FIXED: {name}")

with open('database/data_recipes.json', 'w', encoding='utf-8') as f:
    json.dump(data, f, ensure_ascii=False, indent=4)

print("\nDone!")

# Final check
print("\n=== FINAL VERIFIKASI ===")
for r in data:
    zero = sum(1 for s in r['steps'] if s['minute'] == 0)
    name = r['name']
    steps_count = len(r['steps'])
    status = "✅" if zero == 0 else f"⚠️  {zero} steps masih 0"
    print(f"{status} {name}: {steps_count} steps")
