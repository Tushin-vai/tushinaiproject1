<?php include "db.php";

$id = $_GET['id'];
$book = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM books WHERE id=$id"));
?>

<link rel="stylesheet" href="style.css">

<h2>Edit Book</h2>

<form method="POST">
    <input name="title" value="<?= $book['title'] ?>"><br>
    <input name="author" value="<?= $book['author'] ?>"><br>
    <input name="genre" value="<?= $book['genre'] ?>"><br>
    <input name="isbn" value="<?= $book['isbn'] ?>"><br>
    <button>Update</button>
</form>

<?php
if ($_POST) {
    mysqli_query($conn, "UPDATE books SET
        title='$_POST[title]',
        author='$_POST[author]',
        genre='$_POST[genre]',
        isbn='$_POST[isbn]'
        WHERE id=$id");

    header("Location: index.php");
}
?>
