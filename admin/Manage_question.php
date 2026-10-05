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

/* Delete question */
if (isset($_GET["delete"])) {

    $question_id = (int) $_GET["delete"];

    if ($question_id > 0) {

        $stmt = $conn->prepare(
            "DELETE FROM questions WHERE id = ?"
        );

        $stmt->bind_param("i", $question_id);
        $stmt->execute();
    }

    header("Location: manage_questions.php");
    exit();
}

/* Get questions with exam name */
$sql = "
    SELECT
        questions.id,
        questions.question,
        questions.option_a,
        questions.option_b,
        questions.option_c,
        questions.option_d,
        questions.correct_answer,
        exams.exam_name
    FROM questions
    INNER JOIN exams
        ON questions.exam_id = exams.id
    ORDER BY questions.id DESC
";

$questions = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Questions</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>Manage Questions</h2>

        <div>

            <a
                href="add_question.php"
                class="btn btn-primary"
            >
                Add Question
            </a>

            <a
                href="dashboard.php"
                class="btn btn-secondary"
            >
                Dashboard
            </a>

        </div>

    </div>

    <?php if ($questions && $questions->num_rows > 0): ?>

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Exam</th>
                        <th>Question</th>
                        <th>Options</th>
                        <th>Correct</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                <?php while ($q = $questions->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= $q["id"] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($q["exam_name"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($q["question"]) ?>
                        </td>

                        <td>

                            A.
                            <?= htmlspecialchars($q["option_a"]) ?><br>

                            B.
                            <?= htmlspecialchars($q["option_b"]) ?><br>

                            C.
                            <?= htmlspecialchars($q["option_c"]) ?><br>

                            D.
                            <?= htmlspecialchars($q["option_d"]) ?>

                        </td>

                        <td>
                            <strong>
                                <?= htmlspecialchars($q["correct_answer"]) ?>
                            </strong>
                        </td>

                        <td>

                            <a
                                href="manage_questions.php?delete=<?= $q["id"] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this question?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    <?php else: ?>

        <div class="alert alert-info">
            No questions have been added yet.
        </div>

    <?php endif; ?>

</div>

</body>

</html>
