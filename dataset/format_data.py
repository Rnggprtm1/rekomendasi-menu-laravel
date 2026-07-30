import json
import re
import os
import shutil

# Read the raw recipes.json
with open('recipes.json', 'r', encoding='utf-8') as f:
    raw_recipes = json.load(f)

structured_recipes = []

for i, raw in enumerate(raw_recipes):
    # Flatten the content by splitting on newlines
    flat_content = []
    for c in raw['content']:
        flat_content.extend(c.split('\n'))
        
    # Remove empty lines
    flat_content = [line.strip() for line in flat_content if line.strip()]
    
    name = flat_content[0] if len(flat_content) > 0 else f"Recipe {i+1}"
    
    # Heuristics for ingredients and steps
    ingredients = []
    steps = []
    
    is_step = False
    for line in flat_content[1:]:
        # If line contains many words and doesn't start with bullet, it might be a step
        if line.startswith('•') or line.startswith('*') or line.startswith('-') or line.lower().startswith('bahan'):
            ingredients.append(line.lstrip('•*-').strip())
        elif re.match(r'^\d+\.', line) or (len(line) > 60 and not line.lower().startswith('bahan')):
            is_step = True
            steps.append(line)
        else:
            if is_step:
                steps.append(line)
            else:
                ingredients.append(line)
                
    # Extract time
    time = 30
    time_match = re.search(r'(\d+)\s*(mins?|menit)', '\n'.join(flat_content), re.IGNORECASE)
    if time_match:
        time = int(time_match.group(1))
        
    # Image name
    img_ext = '.jpg'
    for ext in ['.jpg', '.png', '.webp', '.jpeg']:
        if os.path.exists(f"images ({raw['id']}){ext}"):
            img_ext = ext
            break
            
    final_img_name = f"images ({raw['id']}){img_ext}"
    dest_img = f"images/{final_img_name}"
    
    # Copy image to public/images
    src_img = final_img_name
    dst_img = f"../public/images/{final_img_name}"
    if os.path.exists(src_img):
        shutil.copy(src_img, dst_img)

    recipe = {
        "name": name,
        "ingredients": ingredients,
        "steps": steps,
        "time": time,
        "difficulty": "Sedang" if time > 30 else "Mudah",
        "portion": 2,
        "image": dest_img
    }
    
    structured_recipes.append(recipe)
    
with open('../database/data_recipes.json', 'w', encoding='utf-8') as f:
    json.dump(structured_recipes, f, indent=4, ensure_ascii=False)

print("Data formatted and images copied.")
