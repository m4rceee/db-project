<?php
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

    $con = mysqli_connect("localhost", "root", "", "teachers_db");

    if(!$con) {
    die("Connection Failed: ". mysqli_connect_error());
    }

    if(isset($_POST['delete_teacher'])) {
        $teacher_id = mysqli_real_escape_string($con, $_POST['delete_teacher']);

        $query = "DELETE FROM teachers where EMP='$teacher_id'";
        $query_run = mysqli_query($con, $query);

        if($query_run) {
            session_start();
            $_SESSION['status'] = "Teacher deleted successfully.";
            header("Location: admin-teacher.php");
            exit();
        } else {
            session_start();
            $_SESSION['status'] = "Teacher deleted unsuccessfully.";
            header("Location: admin-teacher.php");
            exit();
        }
    } else {

    }

?>