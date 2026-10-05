<?php
session_start();

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: admin/dashboard.php");
        exit();
    }

    if ($_SESSION["role"] === "student") {
        header("Location: student/dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Examination System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            Online Examination System
        </a>

        <div>
            <a href="login.php" class="btn btn-light me-2">Student Login</a>
            <a href="register.php" class="btn btn-warning">Register</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="hero-section text-center">

        <h1>Online Examination System</h1>

        <p class="lead">
            A simple web-based system for conducting online examinations,
            managing questions and automatically generating results.
        </p>

        <a href="login.php" class="btn btn-primary btn-lg">
            Start Examination
        </a>

        <a href="admin/login.php" class="btn btn-dark btn-lg">
            Admin Login
        </a>

    </div>
</div>

</body>
</html>
