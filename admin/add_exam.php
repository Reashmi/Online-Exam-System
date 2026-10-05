<?php

session_start();

require_once "../config/database.php";

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $exam_name = trim($_POST["exam_name"]);
    $subject = trim($_POST["subject"]);
    $duration = (int) $_POST["duration"];
    $description = trim($_POST["description"]);

    if (
        $exam_name === "" ||
        $subject === "" ||
        $duration <= 0
    ) {

        $message = "Please enter all required details.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO exams
            (exam_name, subject, duration, description)
            VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssis",
            $exam_name,
            $subject,
            $duration,
            $description
        );

        if ($stmt->execute()) {

            $message = "Exam added successfully.";

        } else {

            $message = "Failed to add exam.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Exam</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="container mt-4">

    <a
        href="dashboard.php"
        class="btn btn-secondary mb-3"
    >
        Back to Dashboard
    </a>

    <div class="card">

        <div class="card-body">

            <h2>Add New Exam</h2>

            <?php if ($message !== ""): ?>

                <div class="alert alert-info">
                    <?= htmlspecialchars($message) ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Exam Name
                    </label>

                    <input
                        type="text"
                        name="exam_name"
                        class="form-control"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Subject
                    </label>

                    <input
                        type="text"
                        name="subject"
                        class="form-control"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Duration (Minutes)
                    </label>

                    <input
                        type="number"
                        name="duration"
                        class="form-control"
                        min="1"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea
                        name="description"
                        class="form-control"
                        rows="4"
                    ></textarea>

                </div>

                <button class="btn btn-success">
                    Add Exam
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>
