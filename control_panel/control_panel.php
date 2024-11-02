<?php
session_start();
require_once '../lib/db_connect.php';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user's name from the database
    $sql = "SELECT first_name, last_name FROM users WHERE user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Set user's name if found in database
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_name = $user['first_name'] . ' ' . $user['last_name'];
    } else {
        $user_name = "Guest"; // Fallback if user not found
    }

    $stmt->close();
} else {
    $user_name = "Guest"; // Default if not logged in
}

$connection->close();
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
    <title>BMCC Companion</title>
</head>

<body>

    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <div class="header-left d-flex">
                <a href="#" class="sidebarCollapse" data-toggle="collapse" aria-expanded="false" style="margin-right: 30px;">
                    <span class="fas fa-bars text-white" style="font-size: 1.5em;"></span>
                </a>

                <div class="logo text-white" style="margin-right: 40px;">
                    BMCC Companion
                </div>
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
                        <i class="fas fa-user-circle" style="font-size: 1.5em;"></i>
                        <span id="user-name" class="ml-2" style="margin-left: 10px;"><?php echo htmlspecialchars($user_name); ?></span>
                    </a>
                </li>
            </ul>
        </header>
    </div>

    <div class="sidebar show" id="sidebar">
        <a href="../mente/mente.html"><span class="fas fa-comment-alt"></span> Mental Health Chatbot</a>
        <a href="../tutor/tutor.html"><span class="fas fa-user-graduate"></span> Tutor AI</a>
        <a href="#"><span class="fas fa-ban"></span> Spam Detector</a>
        <a href="../files/uploader.php"><span class="fas fa-upload"></span> Upload Files</a>
    </div>

    <!-- Second Sidebar -->
    <!-- Dropdown Menu for Profile/Notifications -->
    <div class="dropdown-menu" id="dropdown-menu">
        <a href="#"><span class="fas fa-cog"></span> Settings</a>
        <a href="../profile/profile.php"><span class="fas fa-user"></span> Profile</a>
        <a href="../lib/logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
    </div>

    <!-- Second Sidebar -->
    <!-- Dropdown Menu for Profile/Notifications -->
    <!-- Dropdown Menu for Notifications -->
<div class="dropdown-menu" id="notification-menu" style="width: 300px;">
    <div class="dropdown-header">Notifications</div>
    <a href="#" class="dropdown-item">
        <i class="fas fa-exclamation-circle"></i> New assignment due tomorrow
    </a>
    <a href="#" class="dropdown-item">
        <i class="fas fa-calendar-alt"></i> Upcoming event: Workshop at 3 PM
    </a>
    <a href="#" class="dropdown-item">
        <i class="fas fa-info-circle"></i> Campus safety alert issued
    </a>
    <a href="#" class="dropdown-item text-center" style="font-weight: bold;">
        View All Notifications
    </a>
</div>

<!-- Dropdown Menu for Email -->
<div class="dropdown-menu" id="email-menu"  style="width: 400px;">
    <div class="dropdown-header">Messages</div>
    <a href="#" class="dropdown-item">
        <strong>Professor Smith:</strong> Remember to review...
        <span class="text-muted">10 mins ago</span>
    </a>
    <a href="#" class="dropdown-item">
        <strong>Career Services:</strong> Upcoming internship fair...
        <span class="text-muted">1 hr ago</span>
    </a>
    <a href="#" class="dropdown-item">
        <strong>BMCC Alerts:</strong> Important campus update...
        <span class="text-muted">2 hrs ago</span>
    </a>
    <a href="#" class="dropdown-item text-center" style="font-weight: bold;">
        View All Messages
    </a>
</div>

<div class="main-content" id="main-content" style="text-align: left; margin-top: 100px;">
    <h2>Welcome to BMCC Companion</h2>
    <p>Your dashboard for support and resources.</p>
    
    <!-- College News Section -->
    <div class="container mt-5" style="margin-left: 20px;">
        <h2>College News</h2>
        <div class="row">
            <div class="col-12">
                <div class="news-section">
                    <article class="news-item card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">BMCC Hosts First Annual Artificial Intelligence (AI) Innovation Challenge</h4>
                            <p class="card-text">
                                Around 65 Borough of Manhattan Community College (BMCC/CUNY) students from across various academic majors filled the main floor of the College gymnasium at 199 Chambers Street on May 4, for the first annual Artificial Intelligence (AI) Innovation Challenge for Social Good event. <a href="https://www.bmcc.cuny.edu/news/bmcc-hosts-first-annual-artificial-intelligence-ai-innovation-challenge/">Read More</a>
                            </p>
                        </div>
                    </article>
                    <article class="news-item card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">AI Machine Learning Boot Camp</h4>
                            <p class="card-text">
                                Artificial intelligence (AI) and machine learning (ML) are among the most in-demand skills in the world. With the growth in automation and robotics across industries, there are massive job opportunities in AI programming, data science, engineering, and research. <a href="https://www.bmcc.cuny.edu/ce/online-courses/online-it-bootcamp-training-courses/ai-machine-learning-bootcamp/"> Read More</a>
                            </p>
                        </div>
                    </article>
                    <article class="news-item card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Student Hub</h4>
                            <p class="card-text">
                                BMCC provides students with services to become successful both inside and outside of the classroom. These services, resources and opportunities assist in the personal, intellectual, and emotional development that complements a student’s academic experience in the classroom. <a href="https://www.bmcc.cuny.edu/students/">Read More</a>
                            </p>
                        </div>
                    </article>
                </div>
            </div>
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

    // Toggle dropdown for Profile icon
    document.querySelector(".fa-user-circle").addEventListener("click", function(event) {
        event.stopPropagation();
        document.getElementById("dropdown-menu").style.display = "block";
    });

    // Toggle dropdown for Notification icon
    document.querySelector(".fa-bell").addEventListener("click", function(event) {
        event.stopPropagation();
        document.getElementById("email-menu").style.display = "none"; 
        const notificationMenu = document.getElementById("notification-menu");
        notificationMenu.style.display = (notificationMenu.style.display === "block") ? "none" : "block";
    });

    // Toggle dropdown for Email icon
    document.querySelector(".fa-envelope").addEventListener("click", function(event) {
        event.stopPropagation();
        document.getElementById("notification-menu").style.display = "none"; 
        const emailMenu = document.getElementById("email-menu");
        emailMenu.style.display = (emailMenu.style.display === "block") ? "none" : "block";
    });

    // Close all dropdowns when clicking outside
    document.addEventListener("click", function() {
        document.getElementById("dropdown-menu").style.display = "none";
        document.getElementById("notification-menu").style.display = "none";
        document.getElementById("email-menu").style.display = "none";
    });
</script>

</body>
</html>
