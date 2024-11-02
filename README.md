# BMCC_Companion_app
<<<<<<< HEAD
CS Project for the AI Innovation Challenge

## Overview
The **BMCC Companion App** aims to enhance the college experience for all students by providing a central hub where they can access academic resources, connect with events and opportunities, and utilize additional tools to support their journey. Being a college student is challenging, and we hope our Companion App eases the load by providing meaningful support.

### Key Features
- **AI Chatbot**: An AI-powered chatbot for students to test their knowledge, gain feedback, and improve their learning.
- **Mental Health Support**: A dedicated mental health chat feature to help students manage stress and challenges associated with academic life.

## Folder Structure

### `control_panel`
- **control_panel.php**: This is the home page where users can access various features of the application.

### `tutor`
- The tutoring component guides students through problem-solving processes instead of providing direct answers. By leveraging input from the user, it offers recommendations for study resources and strategies.
- Utilizes Bootstrap CSS to ensure a responsive design across devices.
- Includes jQuery commands for dynamic user experience and tailored study outlines.

### `profile`
- Contains the main profile page, displaying relevant student information in a read-only format. Connected to MySQL to fetch and present necessary details.

### `mente`
- Houses the AI chatbot, "Mente+." Currently under development, this component is open for contributions to improve its guidance, logic-based responses, and adaptability.

## Technology Stack
- **PHP**: Server-side scripting.
- **JavaScript**: For interactivity and front-end logic.
- **HTML/CSS**: For structure and styling.
- **Bootstrap**: To ensure a responsive layout.
- **MySQL**: Database management.

## Installation Instructions

### Step 1: Download and Install XAMPP
- Download XAMPP from the [official website](https://www.apachefriends.org/index.html) and install it on your local machine.

### Step 2: Set Up the Database
1. Start XAMPP and activate the Apache and MySQL modules.
2. Open [phpMyAdmin](http://localhost/phpmyadmin) and create a new database named `bmcc_student_companion`.
3. Import the provided SQL script (if available) to set up the required tables.

### Step 3: Clone the Repository
- Clone the repository to your local machine using:
  ```bash
  git clone <repository-url>
=======
BMCC_Companion_app
CS Project for the AI Innovation Challenge

Overview
The BMCC Companion App aims to enhance the college experience for all students by providing a central hub where they can access academic resources, connect with events and opportunities, and utilize additional tools to support their journey. Being a college student is challenging, and we hope our Companion App eases the load by providing meaningful support.

Key Features:
AI Chatbot: An AI-powered chatbot for students to test their knowledge, gain feedback, and improve their learning.
Mental Health Support: A dedicated mental health chat feature to help students manage stress and challenges associated with academic life.
Folder Structure
control_panel
control_panel.php: This is the home page where users can access various features of the application.
tutor
The tutoring component guides students through problem-solving processes instead of providing direct answers. By leveraging input from the user, it offers recommendations for study resources and strategies.
Utilizes Bootstrap CSS to ensure a responsive design across devices.
Includes jQuery commands for dynamic user experience and tailored study outlines.
profile
Contains the main profile page, displaying relevant student information in a read-only format. Connected to MySQL to fetch and present necessary details.
mente
Houses the AI chatbot, "Mente+." Currently under development, this component is open for contributions to improve its guidance, logic-based responses, and adaptability.
Technology Stack
PHP: Server-side scripting.
JavaScript: For interactivity and front-end logic.
HTML/CSS: For structure and styling.
Bootstrap: To ensure a responsive layout.
MySQL: Database management.
Installation Instructions
Step 1: Download and Install XAMPP
Download XAMPP from the official website and install it on your local machine.
Step 2: Set Up the Database
Start XAMPP and activate the Apache and MySQL modules.
Open phpMyAdmin and create a new database named bmcc_student_companion.
Import the provided SQL script (if available) to set up the required tables.
Step 3: Clone the Repository
Clone the repository to your local machine using:
bash
Copy code
git clone <repository-url>
Step 4: Place Files in the Correct Directory
Move the cloned project folder to the htdocs directory of your XAMPP installation (typically found at C:\xampp\htdocs).
Step 5: Access the Application
Open your web browser and navigate to http://localhost/BMCC_Companion_app/lib/login.php to view the login page.
Step 6: Login
Use the credentials stored in your database to log in and access the control panel.
Contribution
You can contribute to the development of this application by providing feedback and suggestions in ISSUESFEEDBACK.md
>>>>>>> 3a9988e96e999e4a9364e77c60a21bcfad7d3bb5
