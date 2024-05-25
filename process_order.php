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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $user_mobile = $_POST['user_mobile'];
    $user_email = $_POST['user_email'];
    $user_license = $_POST['user_license'];
    $car_id = $_POST['car_id'];
    $rent_start_date = $_POST['rent_start_date'];
    $rent_end_date = $_POST['rent_end_date'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    // Insert data into rental_orders table
    $sql = "INSERT INTO rental_orders (user_name, user_mobile, user_email, user_license, car_id, rent_start_date, rent_end_date, quantity, total_price)
    VALUES ('$user_name', '$user_mobile', '$user_email', '$user_license', '$car_id', '$rent_start_date', '$rent_end_date', '$quantity', '$total_price')";

    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Store order details in session variables
        $_SESSION['order_id'] = $order_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_mobile'] = $user_mobile;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['user_license'] = $user_license;
        $_SESSION['car_id'] = $car_id;
        $_SESSION['rent_start_date'] = $rent_start_date;
        $_SESSION['rent_end_date'] = $rent_end_date;
        $_SESSION['quantity'] = $quantity;
        $_SESSION['total_price'] = $total_price;

        header("Location: confirm_order.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
    