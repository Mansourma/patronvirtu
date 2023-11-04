<?php
session_start();
include 'config.php';

if (!isset($_SESSION['SESSION_EMAIL']) && isset($_COOKIE['remember_token'])) {
    $remember_token = mysqli_real_escape_string($conn, $_COOKIE['remember_token']);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE remember_token='{$remember_token}'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['SESSION_EMAIL'] = $row['email'];
    }
}

if (isset($_SESSION['SESSION_EMAIL'])) {
    $email = $_SESSION['SESSION_EMAIL'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        echo "Welcome " . $row['email'] . " <a href='logout.php'>Logout</a>";
    }
}
?>
