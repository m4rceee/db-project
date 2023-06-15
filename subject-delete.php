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

    $con = mysqli_connect("localhost", "root", "", "courses_subj_db");

    if(!$con) {
    die("Connection Failed: ". mysqli_connect_error());
    }

    if(isset($_POST['delete_course_subj'])) {
        $subj_id = mysqli_real_escape_string($con, $_POST['delete_course_subj']);

        $query = "DELETE FROM courses_subj where subj_id='$subj_id'";
        $query_run = mysqli_query($con, $query);

        if($query_run) {
            session_start();
            $_SESSION['status'] = "Subject deleted successfully.";
            header("Location: admin-course&subj.php");
            exit();
        } else {
            session_start();
            $_SESSION['status'] = "Subject delete unsuccessful.";
            header("Location: admin-course&subj.php");
            exit();
        }
    } else {

    }

?>