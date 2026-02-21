<?php include "db.php"; ?>

<link rel="stylesheet" href="style.css">

<h2>Borrowing History</h2>

<table>
<tr>
    <th>Book</th>
    <th>User</th>
    <th>Due Date</th>
    <th>Action</th>
</tr>

<?php
$query = "SELECT issues.id, books.title, users.name, issues.due_date
          FROM issues
          JOIN books ON books.id = issues.book_id
          JOIN users ON users.id = issues.user_id";

$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <td><?= $row['title'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['due_date'] ?></td>
    <td><a href="return_book.php?id=<?= $row['id'] ?>">Return</a></td>
</tr>
<?php } ?>
</table>
