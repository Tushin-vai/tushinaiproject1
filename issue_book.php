<?php
session_start();
include "db.php";

// ✅ Make sure user is logged in
if(!isset($_SESSION['user'])){
    echo "❌ You must login first!";
    exit;
}

$user_id = $_SESSION['user']; // Logged-in user ID
?>

<link rel="stylesheet" href="style.css">

<h2>📚 Issue Book</h2>

<!-- Issue Book Form -->
<form method="POST">
    <label>Select Book:</label><br>
    <select name="book_id" required>
        <?php
        // ✅ Fetch all books with copies > 0
        $books = mysqli_query($conn, "SELECT * FROM books WHERE copies > 0");
        while($b = mysqli_fetch_assoc($books)){
            echo "<option value='{$b['id']}'>{$b['title']} (Available: {$b['copies']})</option>";
        }
        ?>
    </select><br><br>

    <button type="submit">Issue Book</button>
</form>

<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $book_id = intval($_POST['book_id']);

    // ✅ Get current copies
    $book_query = mysqli_query($conn, "SELECT copies FROM books WHERE id=$book_id");
    $book = mysqli_fetch_assoc($book_query);

    if(!$book){
        echo "<p style='color:red;'>❌ Book not found!</p>";
        exit;
    }

    if($book['copies'] > 0){
        // ✅ Set due date 7 days from today
        $due = date("Y-m-d", strtotime("+7 days"));

        // ✅ Insert issue record
        $insert = mysqli_query($conn, "INSERT INTO issues (book_id, user_id, due_date) VALUES ($book_id, $user_id, '$due')");

        if($insert){
            // ✅ Decrease copies by 1
            mysqli_query($conn, "UPDATE books SET copies = copies - 1 WHERE id=$book_id");

            echo "<p style='color:green;'>✅ Book issued successfully! Due Date: $due</p>";
        } else {
            echo "<p style='color:red;'>❌ Failed to issue book. Try again.</p>";
        }
    } else {
        echo "<p style='color:red;'>❌ No copies available!</p>";
    }
}
?>
