import json

data = json.load(open('database/data_recipes.json', encoding='utf-8'))
print('=== CEK SEMUA RESEP ===')
for r in data:
    zero_mins = [s for s in r['steps'] if s['minute'] == 0]
    has_zero = len(zero_mins)
    name = r['name']
    steps = len(r['steps'])
    print(f"{name}: {steps} steps, {has_zero} step dgn minute=0")
