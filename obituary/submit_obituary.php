<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "obituary_platform";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$name = $_POST['name'];
$date_of_birth = $_POST['date_of_birth'];
$date_of_death = $_POST['date_of_death'];
$content = $_POST['content'];
$author = $_POST['author'];
$slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($name)));

// Prepare SQL and bind parameters
$stmt = $conn->prepare("INSERT INTO obituaries (name, date_of_birth, date_of_death, content, author, slug) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $date_of_birth, $date_of_death, $content, $author, $slug);

// Execute the statement
if ($stmt->execute()) {
    echo "Obituary submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
