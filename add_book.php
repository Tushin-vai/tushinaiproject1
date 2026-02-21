<?php include "db.php"; ?>

<link rel="stylesheet" href="style.css">

<h2>Add Book</h2>

<form method="POST">
    <input type="text" name="title" placeholder="Title" required><br>
    <input type="text" name="author" placeholder="Author" required><br>
    <input type="text" name="genre" placeholder="Genre"><br>
    <input type="text" name="isbn" placeholder="ISBN"><br>
    <input type="number" name="copies" placeholder="Number of copies" value="1" min="1" required><br>
    <button type="submit">Add Book</button>

    <button>Add</button>
</form>

<?php
if($_POST){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $copies = intval($_POST['copies']); // Important: get numeric value

    mysqli_query($conn, "INSERT INTO books (title, author, genre, isbn, copies) 
                         VALUES ('$title','$author','$genre','$isbn',$copies)");

    header("Location: index.php");
}


?>
