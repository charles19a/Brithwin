<?php
// Database connection parameters
$servername = "localhost";
$username = "root";  // default MySQL username
$password = "";      // default MySQL password
$dbname = "university";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query to check if the username and password match
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the query returns a row, the credentials are valid
    if ($result->num_rows > 0) {
        // Start a session and store user information
        session_start();
        $_SESSION['username'] = $user;

        // Redirect to the success page or dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid credentials
        echo "Invalid username or password.";
    }
}

// Close connection
$conn->close();
?>
