<?php
include("db_conn.php");

session_start();

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-success alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} elseif (isset($_SESSION['error'])) {
    $status = "<div class='alert alert-danger alert-dismissible fade show mt-2'><strong>{$_SESSION['error']}</strong></div>";
    unset($_SESSION['error']);
} else {
    $status = "";
}

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['delete_teacher'])) {
    $teacher_id = mysqli_real_escape_string($conn, $_POST['delete_teacher']);

    $query = "DELETE FROM teachers WHERE EMP='$teacher_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['status'] = "Teacher deleted successfully.";
        header("Location: admin-teacher.php");
        $query = "ALTER TABLE teachers AUTO_INCREMENT = 1";
        $query_run = mysqli_query($conn, $query);
    } else {
        $_SESSION['error'] = "Teacher deletion unsuccessful.";
        header("Location: admin-teacher.php");
    }
} else {
    $_SESSION['error'] = "Invalid request.";
}

header("Location: admin-teacher.php");
exit();
?>
