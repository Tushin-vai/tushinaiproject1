import pandas as pd
import faiss
import pickle
from sentence_transformers import SentenceTransformer

print("Loading dataset...")

df = pd.read_csv("books.csv")

texts = df["title"] + " " + df["author"] + " " + df["genre"]

model = SentenceTransformer("all-MiniLM-L6-v2")

print("Generating embeddings...")

embeddings = model.encode(texts.tolist())

dimension = embeddings.shape[1]

index = faiss.IndexFlatL2(dimension)
index.add(embeddings)

faiss.write_index(index, "books.index")

pickle.dump(df.to_dict("records"), open("books.pkl","wb"))

print("Model trained successfully")