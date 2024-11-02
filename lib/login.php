<?php
session_start();
include 'db_connect.php';

// Display logout message if it exists
$logout_message = "";
if (isset($_SESSION['logout_message'])) {
    $logout_message = $_SESSION['logout_message'];
    unset($_SESSION['logout_message']); // Clear the message after displaying it
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email exists in the database and retrieve the plaintext password
    $sql = "SELECT user_id, password FROM users WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Plaintext password check
        if ($password === $user['password']) {
            // Password is correct, set the user ID in session
            $_SESSION['user_id'] = $user['user_id'];

            // Redirect to control panel
            header("Location: ../control_panel/control_panel.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid email address.";
    }

    $stmt->close();
}
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Login</h2>

        <!-- Display the logout message if it exists -->
        <?php if ($logout_message): ?>
            <div class="alert alert-success"><?php echo $logout_message; ?></div>
        <?php endif; ?>

        <!-- Display error message if the login fails -->
        <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email Address:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Log In</button>
        </form>
    </div>
</body>
</html>
