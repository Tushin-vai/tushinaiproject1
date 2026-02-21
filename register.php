<?php include "db.php"; ?>

<link rel="stylesheet" href="style.css">

<h2>Register</h2>

<form method="POST">
    <input name="name" placeholder="Name"><br>
    <input name="email" placeholder="Email"><br>
    <input name="password" type="password" placeholder="Password"><br>
    <button>Register</button>
</form>

<?php
if ($_POST) {
    $pass = md5($_POST['password']);

    mysqli_query($conn, "INSERT INTO users (name, email, password)
                         VALUES ('$_POST[name]', '$_POST[email]', '$pass')");
}
?>
