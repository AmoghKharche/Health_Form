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
  $name = $_POST['name'];
  $age = $_POST['age'];
  $weight = $_POST['weight'];
  $email = $_POST['email'];

  // Handle the uploaded PDF file
  $targetDir = 'uploads/'; // Directory to store the uploaded files
  $targetFile = $targetDir . basename($_FILES['healthReport']['name']);
  $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Check if the uploaded file is a PDF
  if ($fileType !== 'pdf') {
    die('Invalid file format. Only PDF files are allowed.');
  }

  // Move the uploaded file to the target directory
  if (move_uploaded_file($_FILES['healthReport']['tmp_name'], $targetFile)) {
    // Insert user details and PDF file path into the database
    $sql = "INSERT INTO users (name, age, weight, email, health_report) VALUES ('$name', '$age', '$weight', '$email', '$targetFile')";
    if ($conn->query($sql) === true) {
      echo 'User details and health report inserted successfully.';
    } else {
      echo 'Error: ' . $sql . '<br>' . $conn->error;
    }
  } else {
    echo 'Error occurred while uploading the file.';
  }

  // Close the database connection
  $conn->close();
}
?>
