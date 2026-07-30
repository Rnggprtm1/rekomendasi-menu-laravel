import json
import pymongo

# Connect to MongoDB
client = pymongo.MongoClient("mongodb://localhost:27017/")
db = client["rekomendasiMenu"]
collection = db["recipes"]

# Clear existing recipes if needed, or maybe drop
collection.drop()

from datetime import datetime
# Load formatted recipes
with open('../database/data_recipes.json', 'r', encoding='utf-8') as f:
    recipes = json.load(f)

for recipe in recipes:
    recipe['created_at'] = datetime.utcnow()
    recipe['updated_at'] = datetime.utcnow()


# Insert to collection
result = collection.insert_many(recipes)
print(f"Successfully inserted {len(result.inserted_ids)} recipes into MongoDB 'rekomendasiMenu.recipes'.")
