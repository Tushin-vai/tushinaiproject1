<?php
session_start();
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library System</title>
    <link rel="stylesheet" href="style.css">
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
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>

    <hr>

    <!-- Search Form -->
    <form method="GET">
        <input 
            type="text" 
            name="search" 
            placeholder="🔎 Search by title, author, genre"
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        >
        <button type="submit">Search</button>
    </form>

    <!-- Book Table -->
    <table>
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
                    echo "<span class='available'>✅ Available ({$row['copies']})</span>";
                else
                    echo "<span class='out'>❌ Out of stock</span>";
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

</body>
</html>