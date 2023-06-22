<?php
include("db_conn.php");
session_start();

if (isset($_POST['delete_record'])) {
    $attendance_id = mysqli_real_escape_string($conn, $_POST['delete_record']);

    // Retrieve the student's teacher_id based on the attendance_id
    $query = "SELECT teacher_id FROM attendance WHERE attendance_id = '$attendance_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $teacherId = $row['teacher_id'];

    $deleteQuery = "DELETE FROM attendance WHERE attendance_id = '$attendance_id'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        $_SESSION['status2'] = "Student deleted successfully.";
        header("Location: teacher.php?EMP=$teacherId");
        exit();
    } else {
        $_SESSION['status2'] = "Student delete unsuccessful.";
        header("Location: teacher.php?EMP=$teacherId");
        exit();
    }
} else {
    
}
?>
