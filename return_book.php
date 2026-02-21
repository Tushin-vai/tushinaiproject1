<?php
session_start();
include "db.php";

// ✅ Check if user is logged in
if(!isset($_SESSION['user'])){
    echo "<p style='color:red;'>❌ You must login first!</p>";
    exit;
}

// ✅ Check if issue ID is provided
if(!isset($_GET['id'])){
    echo "<p style='color:red;'>❌ Invalid request!</p>";
    exit;
}

$issue_id = intval($_GET['id']);

// ✅ Fetch the issue record
$issue_query = mysqli_query($conn, "SELECT * FROM issues WHERE id=$issue_id");
$issue = mysqli_fetch_assoc($issue_query);

if(!$issue){
    echo "<p style='color:red;'>❌ Issue record not found!</p>";
    exit;
}

// ✅ Increase copies of the book
$book_id = $issue['book_id'];
mysqli_query($conn, "UPDATE books SET copies = copies + 1 WHERE id=$book_id");

// ✅ Delete the issue record
mysqli_query($conn, "DELETE FROM issues WHERE id=$issue_id");

// ✅ Redirect back to borrowing history
header("Location: history.php");
exit;
?>
