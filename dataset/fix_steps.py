import json
import re

def is_cooking_process(text):
    cooking_verbs = ['cook', 'rebus', 'goreng', 'panggang', 'fry', 'masak', 'oven', 'microwave', 'kukus', 'bakar', 'tumis', 'simmer', 'boil', 'bake']
    text_lower = text.lower()
    return any(verb in text_lower for verb in cooking_verbs)

def extract_minutes(text):
    # match patterns like "10 menit", "5 mins", "15-20 menit" (takes the max)
    matches = re.findall(r'(\d+)\s*(?:-|to)?\s*(\d+)?\s*(?:min|menit|m|mins)', text.lower())
    if matches:
        last_match = matches[-1]
        if last_match[1]:
            return int(last_match[1])
        return int(last_match[0])
    return 0

with open('../database/data_recipes.json', 'r', encoding='utf-8') as f:
    recipes = json.load(f)

for recipe in recipes:
    new_steps = []
    # If it's already a dict, it might have been partially fixed, but let's assume it's list of strings based on what we saw
    for step in recipe.get('steps', []):
        if isinstance(step, dict):
            text = step.get('text', '')
        else:
            text = step
            
        if not text.strip():
            continue
            
        minute = 0
        if is_cooking_process(text):
            minute = extract_minutes(text)
            
        new_steps.append({
            "text": text,
            "minute": minute
        })
    recipe['steps'] = new_steps

with open('../database/data_recipes.json', 'w', encoding='utf-8') as f:
    json.dump(recipes, f, indent=4, ensure_ascii=False)

print("Steps structured with minutes!")
