<?php
session_start();
require_once '../lib/db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../lib/login.php?redirect=" . urlencode($_SERVER['PHP_SELF']));
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch user information
$sql = "SELECT first_name, last_name, email, gpa, role, created_at FROM users WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css"> <!-- Custom CSS -->
    <title>BMCC Companion - User Profile</title>
</head>

<body>

    <!-- Header -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <div class="header-left d-flex">
                <div class="logo text-white" style="margin-right: 40px;">
                    BMCC Companion
                </div>
                <a href="#" class="sidebarCollapse" data-toggle="collapse" aria-expanded="false">
                    <span class="fas fa-bars text-white" style="font-size: 1.5em;"></span>
                </a>
            </div>
            <ul class="navbar-item flex-row ml-auto" style="list-style: none; margin-left: auto; display: flex;">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-bell" style="font-size: 1.5em;"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-envelope" style="font-size: 1.5em;"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="fas fa-user-circle" style="font-size: 1.5em;"></i> <!-- Profile Icon -->
                    </a>
                </li>
            </ul>
        </header>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="#"><span class="fas fa-comment-alt"></span> Mental Health Chatbot</a>
        <a href="#"><span class="fas fa-user-graduate"></span> Tutor AI</a>
        <a href="#"><span class="fas fa-ban"></span> Spam Detector</a>
        <a href="#"><span class="fas fa-upload"></span> Upload Files</a>
    </div>

    <!-- Dropdown Menu for Profile/Notifications -->
    <div class="dropdown-menu" id="dropdown-menu">
        <a href="#"><span class="fas fa-cog"></span> Settings</a>
        <a href="#"><span class="fas fa-user"></span> Profile</a>
        <a href="../lib/logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
    </div>

    <!-- User Profile Content -->
    <div class="container mt-5 pt-5">
        <h2>User Profile</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p class="card-text"><strong>GPA:</strong> <?php echo htmlspecialchars($user['gpa'] ?? 'N/A'); ?></p>
                <p class="card-text"><strong>Role:</strong> <?php echo ucfirst(htmlspecialchars($user['role'])); ?></p>
                <p class="card-text"><strong>Account Created:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
                <a href="../lib/logout.php" class="btn btn-secondary mt-3">Logout</a>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".sidebarCollapse").click(function () {
                $("#sidebar").toggleClass("show");
                $("#main-content").toggleClass("shift");
            });
        });

        document.querySelector(".fa-user-circle").addEventListener("click", function (event) {
            event.stopPropagation();
            document.getElementById("dropdown-menu").style.display = "block";
        });

        document.addEventListener("click", function () {
            document.getElementById("dropdown-menu").style.display = "none";
        });
    </script>
</body>

</html>

<?php
$connection->close();
?>
