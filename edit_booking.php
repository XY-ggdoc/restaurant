<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "restaurant";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch booking details for editing
$id = $_GET['id'];
$sql = "SELECT * FROM booking WHERE id = $id";
$result = $conn->query($sql);
$booking = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update booking details
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date_&_time = $_POST['date_&_time'];
    $people = $_POST['people'];
    $special_request = $_POST['special_request'];

    $update_sql = "UPDATE booking SET name='$name', email='$email', date_&_time='$date_&_time', people=$people, special_request='$special_request' WHERE id=$id";

    if ($conn->query($update_sql) === TRUE) {
        echo "Booking updated successfully!";
        header("Location: admin.php");
        exit();
    } else {
        echo "Error updating booking: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
</head>
<body>
    <h2>Edit Booking</h2>
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo $booking['name']; ?>" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo $booking['email']; ?>" required><br>
        <label>Date & Time:</label><br>
        <input type="datetime-local" name="date_&_time" value="<?php echo date('Y-m-d\TH:i', strtotime($booking['date_&_time'])); ?>" required><br>
        <label>No of People:</label><br>
        <input type="number" name="people" value="<?php echo $booking['people']; ?>" required><br>
        <label>Special Request:</label><br>
        <textarea name="special_request"><?php echo $booking['special_request']; ?></textarea><br>
        <input type="submit" value="Update">
    </form>
    <a href="admin.php">Back</a>
</body>
</html>
