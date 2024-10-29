<?php
// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "possystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle search
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Query to fetch data from the database (modify to match your table columns)
$sql = "SELECT * FROM userreg WHERE uid LIKE '$searchTerm%' OR name LIKE '$searchTerm%' OR email LIKE '$searchTerm%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $tableBody = "";
  while ($row = $result->fetch_assoc()) {
    $tableBody .= '<tr>';
    $tableBody .= '<td>' . $row['uid'] . '</td>';
    $tableBody .= '<td>' . $row['name'] . '</td>';
    $tableBody .= '<td>' . $row['email'] . '</td>';
    $tableBody .= '</tr>';
  }
  echo $tableBody;
} else {
  echo '<tr><td colspan="3">No results found.</td></tr>';
}

$conn->close();
?>
