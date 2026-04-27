<?php
session_start();
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library System</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .navbar {
            margin-bottom: 15px;
        }

        .navbar a {
            padding: 10px 15px;
            text-decoration: none;
            background: #3498db;
            color: white;
            border-radius: 5px;
            margin-right: 5px;
            display: inline-block;
        }

        .navbar a:hover {
            background: #2980b9;
        }

        .logout-btn {
            background: #e74c3c !important;
        }

        .logout-btn:hover {
            background: #c0392b !important;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>📚 Library System</h1>

    <!-- Navigation -->
    <div class="navbar">
        <a href="add_book.php">Add Book</a>
        <a href="upload_csv.php">Upload CSV</a>
        <a href="issue_book.php">Issue Book</a>
        <a href="history.php">Borrowing History</a>

        <?php if(isset($_SESSION['user'])): ?>
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>

    <hr>

    <!-- Normal Search -->
    <form method="GET">
        <input 
            type="text" 
            name="search" 
            placeholder="🔎 Search by title, author, genre"
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        >
        <button type="submit">Search</button>
    </form>

    <hr>

    <!-- AI Smart Library -->
    <h2>🤖 AI Smart Library</h2>

    <input type="text" id="aiQuery" placeholder="Ask about books...">
    <button onclick="aiSearch()">Ask AI</button>

    <div id="aiResult" style="margin-top:20px;"></div>

    <hr>

    <!-- Book Table -->
    <table border="1" cellpadding="8">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>ISBN</th>
            <th>Status / Copies</th>
            <th>Action</th>
        </tr>

        <?php
        $search = $_GET['search'] ?? '';
        $search = mysqli_real_escape_string($conn, $search);

        $query = "SELECT * FROM books 
                  WHERE title LIKE '%$search%' 
                     OR author LIKE '%$search%' 
                     OR genre LIKE '%$search%'";

        $result = mysqli_query($conn, $query);

        while($row = mysqli_fetch_assoc($result)):
        ?>
        <tr>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td><?= htmlspecialchars($row['genre']) ?></td>
            <td><?= htmlspecialchars($row['isbn']) ?></td>
            <td>
                <?php
                if($row['copies'] > 0)
                    echo "<span style='color:green;'>✅ Available ({$row['copies']})</span>";
                else
                    echo "<span style='color:red;'>❌ Out of stock</span>";
                ?>
            </td>
            <td>
                <a href="edit_book.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_book.php?id=<?= $row['id'] ?>" 
                   onclick="return confirm('Are you sure?')">
                   Delete
                </a>
            </td>
        </tr>
        <?php endwhile; ?>

    </table>

</div>

<!-- AI SEARCH SCRIPT -->
<script>
async function aiSearch() {
    const query = document.getElementById("aiQuery").value;

    if(query.trim() === ""){
        alert("Please type a question");
        return;
    }

    const res = await fetch("ai_search.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ query: query })
    });

    const data = await res.json();
    document.getElementById("aiResult").innerHTML = data.html;
}
</script>

</body>
</html>