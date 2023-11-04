<?php

$conn = mysqli_connect("127.0.0.1:3308", "root", "MOHAmed.@98765", "patronvirtu");

if (!$conn) {
    echo "Connection Failed";
}