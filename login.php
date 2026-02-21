<?php include "db.php";
session_start();
?>

<link rel="stylesheet" href="style.css">

<h2>Login</h2>

<form method="POST">
    <input name="email"><br>
    <input name="password" type="password"><br>
    <button>Login</button>
</form>

<?php
if ($_POST) {
    $pass = md5($_POST['password']);

    $user = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT * FROM users WHERE email='$_POST[email]' AND password='$pass'"
    ));

    if ($user) {
        $_SESSION['user'] = $user['id'];
        echo "Login Success";
    }
}
?>
