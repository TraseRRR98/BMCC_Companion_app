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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Set the user ID in session
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];

        // Redirect to the original page or profile page if none is provided
        $redirect_url = isset($_GET['redirect']) ? $_GET['redirect'] : 'profile.php';
        header("Location: " . $redirect_url);
        exit;
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
                <label for="email" class="form-label">Enter Email Address:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Log In</button>
        </form>
    </div>
</body>
</html>
