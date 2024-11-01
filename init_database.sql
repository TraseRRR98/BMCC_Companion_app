-- Database Creation Script for BMCC Student Companion Project

-- Create the database
DROP DATABASE IF EXISTS bmcc_student_companion;
CREATE DATABASE bmcc_student_companion;
USE bmcc_student_companion;

-- Create the courses table
CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(255) NOT NULL,
    course_code VARCHAR(50) UNIQUE NOT NULL,
    instructor_name VARCHAR(255),
    semester VARCHAR(50),
    description TEXT,
    online TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the files table
CREATE TABLE files (
    file_id INT AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    course_id INT,
    file_type ENUM('lecture_notes', 'textbook', 'syllabus', 'ppt', 'video', 'other') NOT NULL,
    description TEXT,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE SET NULL
);

-- Create the users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'instructor', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the course enrollment table
CREATE TABLE course_enrollment (
    enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    course_id INT,
    enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE
);

-- Create the AI tutor interaction logs table (optional)
CREATE TABLE ai_tutor_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    course_id INT,
    interaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    interaction_details TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE SET NULL
);

INSERT INTO `courses` (`course_id`, `course_name`, `course_code`, `instructor_name`, `semester`, `description`, `created_at`) VALUES
(1, 'Introduction to Programming', 'CSC111', 'Louise Yan', 'Fall 2024', 'This course is an introduction to the fundamental concepts and terms of computer science, including algorithms, problem solving techniques, data types, concept of loops, conditional statements, modular programming, pointers, arrays, strings, basic file processing, structures and simple classes. Students will use a high-level computer programming language to solve a variety of problems.', '2024-11-01 19:43:49'),
(2, 'Advanced Programming Techniques', 'CSC211', 'Mohammad Azhar', 'Fall 2024', 'This is a second course in programming which will further develop those skills gained in CSC 111 emphasizing reliability, maintainability, and reusability. Students will be introduced to applications of Pointers, Dynamic memory allocation, Arrays, Abstract data types, Objects, classes, and object-oriented design. Additional programming topics such as Inheritance, Polymorphism, Text Processing, Exception Handling, Recursion and Templates will also be covered.', '2024-11-01 19:43:49'),
(3, 'Fundamentals of Computer Systems', 'CSC215', 'Yan Chen', 'Fall 2024', 'This course covers the fundamentals of computer organization and digital logic. Topics include number systems and codes, Boolean algebra, digital circuits, combinational logic design principles, sequential logic design principles, functional components of computer systems, hardware description language, and assembly language. Students will use computer aided design (CAD) tools for digital logic design, analysis and simulation.', '2024-11-01 19:43:49'),
(4, 'Discrete Structures and Applications to Computer Science', 'CSC331', 'Jose Ramon Santos', 'Fall 2024', 'This course will introduce students to linear and non-linear data structures, their use and implementation, algorithms, and software engineering techniques. Topics will include: stacks, queues, lined lists, has tables, trees, graphs, searching and sorting techniques. Asymptotic analysis of algorithms and data structures will also be discussed.', '2024-11-01 19:43:49'),
(5, 'Software Development', 'CSC350', 'Maryam Vatankhah', 'Fall 2024', 'This course covers the fundamentals of software development, including software development life cycle, object-oriented paradigm, design patterns and event-driven programming working in teams. The students are required to develop software applications with graphic user interfaces and databases.', '2024-11-01 19:43:49');
