<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['reservation'] = $_POST;
    echo "Reservation successful!";
}
?>
