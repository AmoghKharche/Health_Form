<?php
// Establish a database connection (replace with your own database details)
$host = 'localhost';
$dbUsername = 'username';
$dbPassword = 'password';
$dbName = 'database_name';

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

// Process the submitted form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];

  // Fetch the user's health report from the database
  $sql = "SELECT health_report FROM users WHERE email='$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $healthReport = $row['health_report'];

    // Download the health report file
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="health_report.pdf"');
    readfile($healthReport);
  } else {
    echo 'No health report found for the given email ID.';
  }

  // Close the database connection
  $conn->close();
}
?>
