<?php
require_once 'libs/load.php';

echo "<h2>Login Debug Test</h2>";

// Test database connection
$conn = Database::getConnection();
echo "<p>✅ Database connection: OK</p>";

// Check if users table exists
$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result->num_rows > 0) {
    echo "<p>✅ Users table: EXISTS</p>";

    // Check users table structure
    $result = $conn->query("DESCRIBE users");
    echo "<p>Users table structure:</p><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['Field']} - {$row['Type']}</li>";
    }
    echo "</ul>";

    // Check if there are any users
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    echo "<p>Total users: {$row['count']}</p>";

    // Show sample users (without passwords)
    $result = $conn->query("SELECT id, username, email FROM users LIMIT 5");
    echo "<p>Sample users:</p><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>ID: {$row['id']}, Username: {$row['username']}, Email: {$row['email']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>❌ Users table: NOT FOUND</p>";
}

// Check if session table exists
$result = $conn->query("SHOW TABLES LIKE 'session'");
if ($result->num_rows > 0) {
    echo "<p>✅ Session table: EXISTS</p>";

    // Check session table structure
    $result = $conn->query("DESCRIBE session");
    echo "<p>Session table structure:</p><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>{$row['Field']} - {$row['Type']}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>❌ Session table: NOT FOUND</p>";
}

// Test User::login function
if (isset($_POST['test_username']) && isset($_POST['test_password'])) {
    $username = $_POST['test_username'];
    $password = $_POST['test_password'];

    echo "<h3>Testing Login</h3>";
    echo "<p>Username: $username</p>";

    $userId = User::login($username, $password);
    if ($userId) {
        echo "<p>✅ Login successful! User ID: $userId</p>";

        // Test UserSession::authenticate
        $token = UserSession::authenticate($username, $password);
        if ($token) {
            echo "<p>✅ Authentication successful! Token: $token</p>";
        } else {
            echo "<p>❌ Authentication failed!</p>";
        }
    } else {
        echo "<p>❌ Login failed!</p>";
    }
}
?>

<form method="post">
    <h3>Test Login</h3>
    <p>Username: <input type="text" name="test_username" required></p>
    <p>Password: <input type="password" name="test_password" required></p>
    <p><input type="submit" value="Test Login"></p>
</form>