<?php
session_start();
include 'db.php';

$login = $_POST['login'];
$pass = $_POST['pass'];

$sql = "SELECT * FROM users WHERE login = ? AND pass = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $login, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['login'] = $login;
    header('Location: index.php');
} else {
    echo "Invalid login or password.";
}
$stmt->close();
$conn->close();
?>
