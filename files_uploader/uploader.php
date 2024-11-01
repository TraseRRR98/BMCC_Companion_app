<?php
require '../lib/db_connect.php';
include '../lib/css.php';
include('../lib/navbar.php');

// Fetch courses from the database
$courses_result = $conn->query("SELECT course_id, course_name FROM courses");
$courses = [];
if ($courses_result->num_rows > 0)
    while ($row = $courses_result->fetch_assoc()) 
        $courses[] = $row;

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $course_id = $_POST['course_id'];
    $file_type = $_POST['file_type'];
    $description = $_POST['description'];


    // File upload handling
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) 
        mkdir($target_dir, 0777, true); // Create the directory with proper permissions if it doesn't exist

    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) 
    {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 5000000) 
    { // Limit file size to 5MB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'mp4'];
    if (!in_array($fileType, $allowed_types)) 
    {
        echo "Sorry, only PDF, DOC, DOCX, PPT, PPTX, TXT, and MP4 files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) 
        echo "Sorry, your file was not uploaded.";
    else 
    {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Insert file info into the database
            $stmt = $conn->prepare("INSERT INTO files (file_name, file_path, course_id, file_type, description) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiss", $_FILES["file"]["name"], $target_file, $course_id, $file_type, $description);

            if ($stmt->execute()) 
                echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
            else 
                echo "Sorry, there was an error uploading your file.";
            

            $stmt->close();
        } else 
            echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Course Files</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Upload a File for a Course</h2>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="course_id">Select Course:</label>
                        <select class="form-control" name="course_id" id="course_id" required>
                            <option value="">Select a Course</option>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?php echo $course['course_id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="file_type">File Type:</label>
                        <select class="form-control" name="file_type" id="file_type" required>
                            <option value="lecture_notes">Lecture Notes</option>
                            <option value="textbook">Textbook</option>
                            <option value="syllabus">Syllabus</option>
                            <option value="ppt">PowerPoint</option>
                            <option value="video">Video</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">File Description:</label>
                        <textarea class="form-control" name="description" id="description" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="file">Select File to Upload:</label>
                        <input type="file" class="form-control-file" name="file" id="file" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-block" name="submit">Upload File</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
