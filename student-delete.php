<?php
include("db_conn.php");

session_start();

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-success alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 
if (isset($_SESSION['status'])) {
  $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
  unset($_SESSION['status']);
} 

$status="";

    if(isset($_POST['delete_student'])) {
        $student_id = mysqli_real_escape_string($conn, $_POST['delete_student']);

        $query = "DELETE FROM students where student_number='$student_id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            session_start();
            $_SESSION['status'] = "Student deleted successfully.";
            header("Location: admin-student.php");
            $query = "ALTER TABLE students AUTO_INCREMENT = 1";
            $query_run = mysqli_query($conn, $query);
            exit();
        } else {
            session_start();
            $_SESSION['status'] = "Student delete unsuccessful.";
            header("Location: admin-student.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid request.";
    }

?>