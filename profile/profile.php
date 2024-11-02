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
$sql = "SELECT first_name, last_name, email, gpa, major, role, created_at FROM users WHERE user_id = ?";
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

// Fetch course counts for online vs in-person specific to the logged-in user
$courseCountQuery = "
    SELECT courses.online, COUNT(*) as count 
    FROM courses 
    JOIN course_enrollment ON courses.course_id = course_enrollment.course_id 
    WHERE course_enrollment.user_id = ? 
    GROUP BY courses.online";
$stmt = $connection->prepare($courseCountQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$courseCountResult = $stmt->get_result();

$courseCounts = ['online' => 0, 'in_person' => 0];
while ($row = $courseCountResult->fetch_assoc()) {
    if ($row['online'] == 1) {
        $courseCounts['online'] = (int)$row['count'];
    } else {
        $courseCounts['in_person'] = (int)$row['count'];
    }
}
$stmt->close();

// Fetch enrolled courses for the user
$enrolledCoursesQuery = "
    SELECT courses.course_name, courses.course_code, courses.instructor_name, courses.semester 
    FROM courses 
    JOIN course_enrollment ON courses.course_id = course_enrollment.course_id 
    WHERE course_enrollment.user_id = ?";
$stmt = $connection->prepare($enrolledCoursesQuery);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$enrolledCoursesResult = $stmt->get_result();
$enrolledCourses = $enrolledCoursesResult->fetch_all(MYSQLI_ASSOC);

$stmt->close();
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>BMCC Companion - User Profile</title>
</head>

<body>

    <!-- Header -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <div class="header-left d-flex">
                <a href="#" class="sidebarCollapse" data-toggle="collapse" aria-expanded="false" style="margin-right: 30px">
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
                        <i class="fas fa-user-circle" style="font-size: 1.5em;"></i> <!-- Profile Icon -->
                    </a>
                </li>
            </ul>
        </header>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href = "../control_panel/control_panel.html"><span class="fas fa-tachometer-alt"></span> Dashboard</a>
        <a href="#"><span class="fas fa-comment-alt"></span> Mental Health Chatbot</a>
        <a href="#"><span class="fas fa-user-graduate"></span> Tutor AI</a>
        <a href="#"><span class="fas fa-ban"></span> Spam Detector</a>
        <a href="#"><span class="fas fa-upload"></span> Upload Files</a>
    </div>

    <!-- Second Sidebar -->
    <!-- Dropdown Menu for Profile/Notifications -->
    <div class="dropdown-menu" id="dropdown-menu">
        <a href="#"><span class="fas fa-cog"></span> Settings</a>
        <a href="../profile/profile.php"><span class="fas fa-user"></span> Profile</a>
        <a href="../lib/logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
    </div>

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

    <!-- User Profile Content -->
    <div class="container mt-5 pt-5">
        <h2 class="mt-3">User Profile</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p class="card-text"><strong>GPA:</strong> <?php echo htmlspecialchars($user['gpa'] ?? 'N/A'); ?></p>
                <p class="card-text"><strong>Role:</strong> <?php echo ucfirst(htmlspecialchars($user['role'])); ?></p>
                <p class="card-text"><strong>Major:</strong> <?php echo htmlspecialchars($user['major'] ?? 'N/A'); ?></p>
            </div>
        </div>

        <!-- Donut Chart for Course Format Distribution -->
        <div class="container mt-5">
            <h4>Course Format Distribution</h4>
            <canvas id="courseChart" class="small-chart"></canvas>
        </div>

        <!-- Enrolled Courses Table -->
        <h3 class="mt-5">Enrolled Courses</h3>
        <?php if (count($enrolledCourses) > 0): ?>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Course Code</th>
                        <th>Instructor</th>
                        <th>Semester</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrolledCourses as $course): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($course['course_code']); ?></td>
                            <td><?php echo htmlspecialchars($course['instructor_name']); ?></td>
                            <td><?php echo htmlspecialchars($course['semester']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="mt-3">You are not enrolled in any courses.</p>
        <?php endif; ?>

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

        // Data for the chart from PHP
        const courseCounts = <?php echo json_encode($courseCounts); ?>;

        // Create the donut chart
        const ctx = document.getElementById('courseChart').getContext('2d');
        const courseChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Online', 'In-Person'],
                datasets: [{
                    data: [courseCounts.online, courseCounts.in_person],
                    backgroundColor: ['#36A2EB', '#FF6384'],
                    hoverBackgroundColor: ['#36A2EB', '#FF6384']
                }]
            },
            options: {
                responsive: false,  // Disable responsiveness
                maintainAspectRatio: true, // Maintain aspect ratio
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });


          // Toggle dropdown for Profile icon
document.querySelector(".fa-user-circle").addEventListener("click", function(event) {
    event.stopPropagation();
    document.getElementById("dropdown-menu").style.display = "block";
});

        // Toggle dropdown for Notification icon
document.querySelector(".fa-bell").addEventListener("click", function(event) {
    event.stopPropagation();
    // Close any open dropdowns first
    document.getElementById("email-menu").style.display = "none"; // Close email menu if open
    const notificationMenu = document.getElementById("notification-menu");
    notificationMenu.style.display = (notificationMenu.style.display === "block") ? "none" : "block";
});

// Toggle dropdown for Email icon
document.querySelector(".fa-envelope").addEventListener("click", function(event) {
    event.stopPropagation();
    // Close any open dropdowns first
    document.getElementById("notification-menu").style.display = "none"; // Close notification menu if open
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
