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

$student_count = 0;
$exam_count = 0;
$question_count = 0;
$result_count = 0;

$query = $conn->query(
    "SELECT COUNT(*) AS total
     FROM users
     WHERE role = 'student'"
);

if ($query) {
    $student_count = $query->fetch_assoc()["total"];
}

$query = $conn->query(
    "SELECT COUNT(*) AS total
     FROM exams"
);

if ($query) {
    $exam_count = $query->fetch_assoc()["total"];
}

$query = $conn->query(
    "SELECT COUNT(*) AS total
     FROM questions"
);

if ($query) {
    $question_count = $query->fetch_assoc()["total"];
}

$query = $conn->query(
    "SELECT COUNT(*) AS total
     FROM results"
);

if ($query) {
    $result_count = $query->fetch_assoc()["total"];
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

    <title>Admin Dashboard</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand" href="dashboard.php">
            Admin Panel
        </a>

        <div>

            <span class="text-white me-3">
                Welcome,
                <?= htmlspecialchars($_SESSION["name"]) ?>
            </span>

            <a href="../logout.php" class="btn btn-danger">
                Logout
            </a>

        </div>

    </div>

</nav>

<div class="container mt-4">

    <h2>
        Admin Dashboard
    </h2>

    <div class="row mt-4">

        <div class="col-md-3">

            <div class="card dashboard-card">

                <div class="card-body text-center">

                    <h5>Students</h5>

                    <h2>
                        <?= $student_count ?>
                    </h2>

                    <a
                        href="view_students.php"
                        class="btn btn-primary"
                    >
                        View Students
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card dashboard-card">

                <div class="card-body text-center">

                    <h5>Exams</h5>

                    <h2>
                        <?= $exam_count ?>
                    </h2>

                    <a
                        href="add_exam.php"
                        class="btn btn-success"
                    >
                        Add Exam
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card dashboard-card">

                <div class="card-body text-center">

                    <h5>Questions</h5>

                    <h2>
                        <?= $question_count ?>
                    </h2>

                    <a
                        href="manage_questions.php"
                        class="btn btn-warning"
                    >
                        Manage
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card dashboard-card">

                <div class="card-body text-center">

                    <h5>Results</h5>

                    <h2>
                        <?= $result_count ?>
                    </h2>

                    <a
                        href="view_results.php"
                        class="btn btn-info"
                    >
                        View Results
                    </a>

                </div>

            </div>

        </div>

    </div>

    <div class="card mt-4">

        <div class="card-body">

            <h4>Quick Actions</h4>

            <a
                href="add_exam.php"
                class="btn btn-success me-2"
            >
                Add Exam
            </a>

            <a
                href="add_question.php"
                class="btn btn-primary me-2"
            >
                Add Question
            </a>

            <a
                href="manage_questions.php"
                class="btn btn-warning me-2"
            >
                Manage Questions
            </a>

            <a
                href="view_students.php"
                class="btn btn-secondary me-2"
            >
                Students
            </a>

            <a
                href="view_results.php"
                class="btn btn-info"
            >
                Results
            </a>

        </div>

    </div>

</div>

</body>

</html>
