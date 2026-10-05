<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "student") {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: student/available_exams.php");
    exit();
}

$exam_id = (int) $_GET["id"];

header("Location: student/take_exam.php?id=" . $exam_id);
exit();

?>
