<?php

$conn = mysqli_connect("127.0.0.1:3308", "root", "your_password", "patronvirtu");

if (!$conn) {
    echo "Connection Failed";
}
