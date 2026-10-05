<?php

session_start();

require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($name === "" || $email === "" || $password === "") {
        $message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Enter a valid email address.";
    } else {

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "Email already registered.";

        } else {

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, role)
                 VALUES (?, ?, ?, 'student')"
            );

            $stmt->bind_param(
                "sss",
                $name,
                $email,
                $hashed_password
            );

            if ($stmt->execute()) {
                header("Location: login.php?registered=1");
                exit();
            } else {
                $message = "Registration failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <div class="form-container">

        <h2 class="text-center mb-4">
            Student Registration
        </h2>

        <?php if ($message !== ""): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Name</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Confirm Password
                </label>

                <input
                    type="password"
                    name="confirm_password"
                    class="form-control"
                    required
                >
            </div>

            <button class="btn btn-primary w-100">
                Register
            </button>

        </form>

        <p class="text-center mt-3">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>

</div>

</body>
</html>
