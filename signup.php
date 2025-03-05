<?php
// Include database connection
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all fields are set
    if (!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format!";
            exit;
        }

        // Hash password for security
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $check_email = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Email already exists!";
        } else {
            // Insert user into database
            $insert_query = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sss", $full_name, $email, $hashed_password);

            if ($stmt->execute()) {
                header("Location: dashboard.php"); // Redirect to dashboard
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    } else {
        echo "All fields are required!";
    }
}
?>
