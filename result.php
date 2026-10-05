<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "student") {
    header("Location: login.php");
    exit();
}

if (isset($_GET["id"])) {
    $result_id = (int) $_GET["id"];

    header("Location: student/result.php?id=" . $result_id);
    exit();
}

header("Location: student/dashboard.php");
exit();

?>
