<?php
session_start();

if (!isset($_SESSION['order_id'])) {
    echo "No order found.";
    exit();
}

$order_id = $_SESSION['order_id'];
$user_name = $_SESSION['user_name'];
$user_mobile = $_SESSION['user_mobile'];
$user_email = $_SESSION['user_email'];
$user_license = $_SESSION['user_license'];
$car_id = $_SESSION['car_id'];
$rent_start_date = $_SESSION['rent_start_date'];
$rent_end_date = $_SESSION['rent_end_date'];
$quantity = $_SESSION['quantity'];
$total_price = $_SESSION['total_price'];

echo "<h1>Review Your Order</h1>";
echo "<p>Name: $user_name</p>";
echo "<p>Mobile: $user_mobile</p>";
echo "<p>Email: $user_email</p>";
echo "<p>Driver's License: $user_license</p>";
echo "<p>Car ID: $car_id</p>";
echo "<p>Rent Start Date: $rent_start_date</p>";
echo "<p>Rent End Date: $rent_end_date</p>";
echo "<p>Quantity: $quantity</p>";
echo "<p>Total Price: $$total_price</p>";
echo "<a href='confirmation.php'>Confirm Order</a>";
?>
