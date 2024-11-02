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
    gpa DECIMAL(3, 2) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    major VARCHAR(55) DEFAULT NULL,
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

-- Create the grades table to track GPA over time
CREATE TABLE grades (
    grade_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    course_id INT,
    grade CHAR(2),  -- Letter grades (e.g., A, B, C)
    grade_points DECIMAL(3, 2),  -- GPA points for the grade
    semester VARCHAR(50),
    date_awarded DATE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE
);


INSERT INTO `courses` (`course_id`, `course_name`, `course_code`, `instructor_name`, `semester`, `description`, `created_at`) VALUES
(1, 'Introduction to Programming', 'CSC111', 'Louise Yan', 'Fall 2024', 'This course is an introduction to the fundamental concepts and terms of computer science, including algorithms, problem solving techniques, data types, concept of loops, conditional statements, modular programming, pointers, arrays, strings, basic file processing, structures and simple classes. Students will use a high-level computer programming language to solve a variety of problems.', '2024-11-01 19:43:49'),
(2, 'Advanced Programming Techniques', 'CSC211', 'Mohammad Azhar', 'Fall 2024', 'This is a second course in programming which will further develop those skills gained in CSC 111 emphasizing reliability, maintainability, and reusability. Students will be introduced to applications of Pointers, Dynamic memory allocation, Arrays, Abstract data types, Objects, classes, and object-oriented design. Additional programming topics such as Inheritance, Polymorphism, Text Processing, Exception Handling, Recursion and Templates will also be covered.', '2024-11-01 19:43:49'),
(3, 'Fundamentals of Computer Systems', 'CSC215', 'Yan Chen', 'Fall 2024', 'This course covers the fundamentals of computer organization and digital logic. Topics include number systems and codes, Boolean algebra, digital circuits, combinational logic design principles, sequential logic design principles, functional components of computer systems, hardware description language, and assembly language. Students will use computer aided design (CAD) tools for digital logic design, analysis and simulation.', '2024-11-01 19:43:49'),
(4, 'Discrete Structures and Applications to Computer Science', 'CSC331', 'Jose Ramon Santos', 'Fall 2024', 'This course will introduce students to linear and non-linear data structures, their use and implementation, algorithms, and software engineering techniques. Topics will include: stacks, queues, lined lists, has tables, trees, graphs, searching and sorting techniques. Asymptotic analysis of algorithms and data structures will also be discussed.', '2024-11-01 19:43:49'),
(5, 'Software Development', 'CSC350', 'Maryam Vatankhah', 'Fall 2024', 'This course covers the fundamentals of software development, including software development life cycle, object-oriented paradigm, design patterns and event-driven programming working in teams. The students are required to develop software applications with graphic user interfaces and databases.', '2024-11-01 19:43:49');

INSERT INTO users (first_name, last_name, email, password, role, gpa, major, created_at) 
VALUES 
('John', 'Doe', 'johndoe@example.com', 'hashed_password', 'student', 3.5, CS, '2024-11-01 19:43:49');

INSERT INTO course_enrollment (user_id, course_id, enrollment_date) 
VALUES 
(1, 2, NOW()),  -- CSC211
(1, 3, NOW());  -- CSC215
(1, 1, '2023-02-01'),  -- CSC101
(1, 6, '2023-02-01'),  -- MAT301
(1, 7, '2023-09-01'),  -- MAT302
(1, 8, '2023-09-01');  -- PHY215


-- Add additional courses
INSERT INTO courses (course_name, course_code, instructor_name, semester, description, created_at) VALUES
('Introduction to Computer Science', 'CSC101', 'Alan Turing', 'Spring 2023', 'Fundamental computer science principles including problem solving, algorithms, and programming basics.', '2024-11-01 19:43:49'),
('Calculus I', 'MAT301', 'Isaac Newton', 'Spring 2023', 'Introduction to calculus, covering limits, derivatives, and integrals.', '2024-11-01 19:43:49'),
('Calculus II', 'MAT302', 'Albert Einstein', 'Fall 2023', 'Continuation of Calculus I, focusing on integration techniques, applications, and series.', '2024-11-01 19:43:49'),
('Physics for Engineers', 'PHY215', 'Marie Curie', 'Fall 2023', 'Introduction to physics principles for engineering students, covering mechanics, thermodynamics, and wave motion.', '2024-11-01 19:43:49'),
('Data Structures', 'CSC231', 'Grace Hopper', 'Spring 2024', 'Introduction to data structures, including arrays, linked lists, stacks, and queues.', '2024-11-01 19:43:49'),
('Information Systems', 'CIS345', 'Ada Lovelace', 'Spring 2024', 'Overview of information systems and their role in business operations, data management, and systems analysis.', '2024-11-01 19:43:49'),
('Introduction to Statistics', 'MAT206', 'Florence Nightingale', 'Fall 2023', 'Foundational concepts of statistics, covering probability, distributions, and hypothesis testing.', '2024-11-01 19:43:49');


-- Insert grades for courses (example entries)
INSERT INTO grades (user_id, course_id, grade, grade_points, semester, date_awarded)
VALUES
(1, 1, 'A', 4.0, 'Spring 2023', '2023-06-01'),
(1, 6, 'B', 3.0, 'Spring 2023', '2023-06-01'),
(1, 7, 'B+', 3.3, 'Fall 2023', '2023-12-15'),
(1, 8, 'A-', 3.7, 'Fall 2023', '2023-12-15');
