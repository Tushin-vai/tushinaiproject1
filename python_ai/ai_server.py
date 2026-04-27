from flask import Flask, request, jsonify
import faiss
import pickle
from sentence_transformers import SentenceTransformer

app = Flask(__name__)

# Load the sentence transformer model
model = SentenceTransformer("all-MiniLM-L6-v2")

# Load FAISS index
index = faiss.read_index("books.index")

# Load the books data
books = pickle.load(open("books.pkl", "rb"))

# Root route for browser check
@app.route("/")
def home():
    return "AI Server is running! Use POST /search to query the model."

# Search route
@app.route("/search", methods=["POST"])
def search():
    try:
        data = request.json
        query = data.get("query", "").strip()

        if not query:
            return jsonify({"error": "Query is empty"}), 400

        # Encode query
        embedding = model.encode([query])

        # Search in FAISS index
        D, I = index.search(embedding, 10)

        # Collect results
        results = [books[idx] for idx in I[0]]

        return jsonify(results)

    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    # Run on port 5000, enable debug for development
    app.run(port=5000, debug=True)