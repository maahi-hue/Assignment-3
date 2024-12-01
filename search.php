<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'real_estate';

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search query from the request
$query = isset($_GET['q']) ? $_GET['q'] : '';

// Prepare SQL statement with wildcard search
$sql = "SELECT name, detail_page FROM properties WHERE name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = '%' . $query . '%';
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = [];
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row; // Include name and detail_page
}

header('Content-Type: application/json');
echo json_encode($suggestions);


// Close connection
$conn->close();
?>
