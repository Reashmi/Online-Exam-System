<?php

session_start();

require_once "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT id, name, password
         FROM users
         WHERE email = ? AND role = 'student'"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["role"] = "student";

            header("Location: student/dashboard.php");
            exit();

        } else {
            $message = "Invalid email or password.";
        }

    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Login</title>

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
            Student Login
        </h2>

        <?php if (isset($_GET["registered"])): ?>
            <div class="alert alert-success">
                Registration successful. Please login.
            </div>
        <?php endif; ?>

        <?php if ($message !== ""): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

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

            <button class="btn btn-primary w-100">
                Login
            </button>

        </form>

        <p class="text-center mt-3">
            New student?
            <a href="register.php">Create account</a>
        </p>

        <p class="text-center">
            <a href="admin/login.php">Admin Login</a>
        </p>

    </div>

</div>

</body>
</html>
