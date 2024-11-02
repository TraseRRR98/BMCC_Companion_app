<?php
require_once '../lib/db_connect.php'; // Include your database connection

// Fetch all courses for the dropdown
$courseQuery = "SELECT course_id, course_code FROM courses";
$result = $connection->query($courseQuery);

// Check for errors
if (!$result) {
    die("Error retrieving courses: " . $connection->error);
}

// Store courses in an array
$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

// Check if the upload form was submitted
if (isset($_POST['upload'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Sanitize and collect other input data
    $fileTypeField = $_POST['file_type'];
    $description = htmlspecialchars($_POST['description']);
    $course_id = (int)$_POST['course_id'];

    // Check if the file type is allowed
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx', 'txt'];
    if (in_array($fileType, $allowedTypes)) {
        // Upload the file to the server
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            // Insert file info into the database
            $stmt = $connection->prepare("
                INSERT INTO files (file_name, file_path, course_id, file_type, description, upload_date) 
                VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssiss", $fileName, $targetFilePath, $course_id, $fileTypeField, $description);
            
            if ($stmt->execute()) {
                echo "The file " . htmlspecialchars($fileName) . " has been uploaded and saved successfully.";
            } else {
                echo "Error saving file data to the database.";
            }
            
            $stmt->close();
        } else {
            echo "Error uploading your file.";
        }
    } else {
        echo "File type not allowed.";
    }
}
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload - BMCC Companion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/bootstrap.min.css"> <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="../css/style.css"> <!-- Custom CSS -->
</head>
<body>

    <!-- Navbar -->
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
                        <span id="user-name" class="ml-2" style="margin-left: 10px;">Guest</span>
                    </a>
                </li>
            </ul>
        </header>
    </div>

    <!-- Sidebar -->
    <div class="sidebar show" id="sidebar">
        <a href = "../control_panel/control_panel.php"><span class="fas fa-tachometer-alt"></span> Dashboard</a>
        <a href="../mente/mente.html"><span class="fas fa-comment-alt"></span> Mental Health Chatbot</a>
        <a href="../tutor/tutor.html"><span class="fas fa-user-graduate"></span> Tutor AI</a>
        <a href="#"><span class="fas fa-ban"></span> Spam Detector</a>
        <a href="../files/uploader.php"><span class="fas fa-upload"></span> Upload Files</a>
    </div>

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
    <div class="dropdown-menu" id="email-menu" style="width: 400px;">
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

    <!-- Main Content -->
    <div class="main-content" id="main-content" style="margin-top: 100px;">
        <div class="container mt-5">
            <h2 class="text-center">Upload a File</h2>
            <form action="upload.php" method="post" enctype="multipart/form-data" class="p-4 border rounded">
                <div class="mb-3">
                    <label for="file" class="form-label">Choose File:</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label for="file_type" class="form-label">File Type:</label>
                    <select name="file_type" id="file_type" class="form-select" required>
                        <option value="lecture_notes">Lecture Notes</option>
                        <option value="textbook">Textbook</option>
                        <option value="syllabus">Syllabus</option>
                        <option value="ppt">PowerPoint</option>
                        <option value="video">Video</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="course_id" class="form-label">Course Code:</label>
                    <select name="course_id" id="course_id" class="form-select" required>
                        <option value="" disabled selected>Select a Course</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['course_id']; ?>">
                                <?php echo htmlspecialchars($course['course_code']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" name="upload" class="btn btn-primary w-100">Upload File</button>
            </form>
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

        // Update the user name in the navbar
        function updateUserName(userName) {
            if (userName) {
                document.getElementById("user-name").textContent = userName;
            }
        }

        // Example: Replace "Guest" with the actual user's name
        const loggedInUserName = "Bryan Tikhonov"; // Replace this with backend data
        updateUserName(loggedInUserName);
    </script>
</body>
</html>
