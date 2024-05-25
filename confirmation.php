<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the order details are available in the session
if (isset($_SESSION['order_id'])) {
    $order_id = $_SESSION['order_id'];

    // Fetch order details from the database
    $sql = "SELECT * FROM rental_orders WHERE order_id = $order_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        $row = $result->fetch_assoc();
        echo "<h1>Rental Confirmation</h1>";
        echo "<p>Order ID: " . $row['order_id'] . "</p>";
        echo "<p>Name: " . $row['user_name'] . "</p>";
        echo "<p>Mobile: " . $row['user_mobile'] . "</p>";
        echo "<p>Email: " . $row['user_email'] . "</p>";
        echo "<p>Driver's License: " . $row['user_license'] . "</p>";
        echo "<p>Car ID: " . $row['car_id'] . "</p>";
        echo "<p>Rent Start Date: " . $row['rent_start_date'] . "</p>";
        echo "<p>Rent End Date: " . $row['rent_end_date'] . "</p>";
        echo "<p>Quantity: " . $row['quantity'] . "</p>";
        echo "<p>Total Price: $" . $row['total_price'] . "</p>";
        echo "<h2>Thank you for your order!</h2>";
    } else {
        echo "No order found.";
    }

    // Clear the session data for this order
    session_unset();
    session_destroy();
} else {
    echo "No order found.";
}

$conn->close();
?>
