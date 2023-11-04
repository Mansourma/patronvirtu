<?php
session_start();

// Destroy the session and redirect to the homepage
session_destroy();
header('Location: newhome.php');
exit();
?>
