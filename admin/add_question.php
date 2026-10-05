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

$exams = $conn->query(
    "SELECT id, exam_name
     FROM exams
     ORDER BY id DESC"
);

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $exam_id = (int) $_POST["exam_id"];
    $question = trim($_POST["question"]);
    $a = trim($_POST["option_a"]);
    $b = trim($_POST["option_b"]);
    $c = trim($_POST["option_c"]);
    $d = trim($_POST["option_d"]);
    $correct = $_POST["correct_answer"];

    if (
        $exam_id <= 0 ||
        $question === "" ||
        $a === "" ||
        $b === "" ||
        $c === "" ||
        $d === "" ||
        !in_array($correct, ["A", "B", "C", "D"], true)
    ) {

        $message = "Please fill all fields correctly.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO questions
            (
                exam_id,
                question,
                option_a,
                option_b,
                option_c,
                option_d,
                correct_answer
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "issssss",
            $exam_id,
            $question,
            $a,
            $b,
            $c,
            $d,
            $correct
        );

        if ($stmt->execute()) {

            $message = "Question added successfully.";

        } else {

            $message = "Failed to add question.";
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

    <title>Add Question</title>

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

            <h2>Add Question</h2>

            <?php if ($message !== ""): ?>

                <div class="alert alert-info">
                    <?= htmlspecialchars($message) ?>
                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Select Exam
                    </label>

                    <select
                        name="exam_id"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Select Exam
                        </option>

                        <?php while ($exam = $exams->fetch_assoc()): ?>

                            <option value="<?= $exam["id"] ?>">
                                <?= htmlspecialchars($exam["exam_name"]) ?>
                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Question
                    </label>

                    <textarea
                        name="question"
                        class="form-control"
                        rows="3"
                        required
                    ></textarea>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Option A
                        </label>

                        <input
                            type="text"
                            name="option_a"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Option B
                        </label>

                        <input
                            type="text"
                            name="option_b"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Option C
                        </label>

                        <input
                            type="text"
                            name="option_c"
                            class="form-control"
                            required
                        >

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Option D
                        </label>

                        <input
                            type="text"
                            name="option_d"
                            class="form-control"
                            required
                        >

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Correct Answer
                    </label>

                    <select
                        name="correct_answer"
                        class="form-select"
                        required
                    >

                        <option value="">Select Answer</option>

                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>

                    </select>

                </div>

                <button class="btn btn-primary">
                    Add Question
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>
