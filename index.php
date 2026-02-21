<?php
session_start();
include "db.php";
?>

<link rel="stylesheet" href="style.css">

<h1>📚 Library System</h1>

<!-- Navigation -->
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

<hr>

<!-- Search Form -->
<form method="GET">
    <input name="search" placeholder="Search by title, author, genre" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    <button>Search</button>
</form>

<!-- Book Table -->
<table border="1" cellpadding="5" cellspacing="0">
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
            echo "✅ Available ({$row['copies']})";
        else
            echo "❌ Out of stock";
        ?>
    </td>
    <td>
        <a href="edit_book.php?id=<?= $row['id'] ?>">Edit</a> |
        <a href="delete_book.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
