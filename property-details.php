<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'real_estate';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the slug from the query string
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Fetch property details from the database
$sql = "SELECT * FROM properties WHERE slug = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $property = $result->fetch_assoc();
} else {
    echo "Property not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($property['name']); ?></title>
</head>
<body>
  <h1><?php echo htmlspecialchars($property['name']); ?></h1>
  <p><strong>Property Description:</strong> Luxury Villa with all modern amenities.</p>
  <!-- Add more property details here -->
</body>
</html>
