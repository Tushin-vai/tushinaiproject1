<?php
include "db.php";

if(isset($_POST['upload'])) {

    $file = $_FILES['csv']['tmp_name'];

    if($_FILES['csv']['size'] > 0) {

        $handle = fopen($file, "r");

        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            $title = mysqli_real_escape_string($conn, $data[0]);
            $author = mysqli_real_escape_string($conn, $data[1]);
            $genre = mysqli_real_escape_string($conn, $data[2]);
            $isbn = mysqli_real_escape_string($conn, $data[3]);
            $copies = intval($data[4]);

            mysqli_query($conn, "
                INSERT INTO books (title, author, genre, isbn, copies)
                VALUES ('$title', '$author', '$genre', '$isbn', '$copies')
            ");
        }

        fclose($handle);

        echo "<h3>✅ CSV Uploaded Successfully!</h3>";
    }
}
?>

<link rel="stylesheet" href="style.css">

<h2>📤 Upload Books CSV</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="csv" required>
    <button type="submit" name="upload">Upload CSV</button>
</form>