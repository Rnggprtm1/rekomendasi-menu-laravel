import docx
import json
import re

def parse_docx(file_path):
    doc = docx.Document(file_path)
    recipes = []
    current_recipe = None
    
    for para in doc.paragraphs:
        text = para.text.strip()
        if not text:
            continue
            
        # Match '1. Resep 1' or '2. Resep 2' etc.
        match = re.match(r'^(\d+)\.\s+Resep', text, re.IGNORECASE)
        if match:
            if current_recipe:
                recipes.append(current_recipe)
            current_recipe = {
                'id': int(match.group(1)),
                'header': text,
                'content': []
            }
        elif current_recipe is not None:
            current_recipe['content'].append(text)
            
    if current_recipe:
        recipes.append(current_recipe)
        
    with open('recipes.json', 'w', encoding='utf-8') as f:
        json.dump(recipes, f, indent=4, ensure_ascii=False)

if __name__ == '__main__':
    parse_docx('tugas ndut.docx')
