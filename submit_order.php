<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array('status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error)));
}

// Get form data
$user_name = $_POST['user_name'];
$user_mobile = $_POST['user_mobile'];
$user_email = $_POST['user_email'];
$user_license = $_POST['user_license'];
$car_id = $_POST['car_id'];
$rent_start_date = $_POST['rent_start_date'];
$rent_end_date = $_POST['rent_end_date'];
$quantity = $_POST['quantity'];

// Load cars.json
$cars = json_decode(file_get_contents('cars.json'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(array('status' => 'error', 'message' => 'Error reading cars.json: ' . json_last_error_msg())));
}

// Find the car by ID
$car = array_filter($cars, function($c) use ($car_id) {
    return $c['id'] == $car_id;
});

if (count($car) == 0) {
    die(json_encode(array('status' => 'error', 'message' => 'Car not found')));
}

$car = array_values($car)[0];

// Check availability
if ($car['availability'] == 'No') {
    die(json_encode(array('status' => 'error', 'message' => 'Car is not available for rental')));
}

// Calculate total price
$days = (strtotime($rent_end_date) - strtotime($rent_start_date)) / (60 * 60 * 24) + 1;
$total_price = $days * $car['price_per_day'] * $quantity;

// Insert order into database
$sql = "INSERT INTO orders (user_name, user_mobile, user_email, user_license, car_id, rent_start_date, rent_end_date, quantity, total_price)
        VALUES ('$user_name', '$user_mobile', '$user_email', '$user_license', '$car_id', '$rent_start_date', '$rent_end_date', '$quantity', '$total_price')";

if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id;
    $confirmation_link = "http://yourdomain.com/confirm_order.php?order_id=$order_id";
    
    echo json_encode(array(
        'status' => 'success',
        'confirmation_link' => $confirmation_link
    ));
    // Update car availability in cars.json
    foreach ($cars as &$car) {
        if ($car['id'] == $car_id) {
            $car['availability'] = 'No';
            break;
        }
    }
    file_put_contents('cars.json', json_encode($cars));
    
    echo json_encode(array(
        'status' => 'success',
        'order_id' => $order_id,
        'total_price' => $total_price,
        'car_make' => $car['make'],
        'car_model' => $car['model'],
        'quantity' => $quantity,
        'rent_start_date' => $rent_start_date,
        'rent_end_date' => $rent_end_date
    ));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Error creating order: ' . $conn->error));
}

$conn->close();
?>
