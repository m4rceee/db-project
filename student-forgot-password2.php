<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include("db_conn.php");

session_start();

$updateSuccess = $notMatch = $emptyFields = $status = $status1 = $status2 = "";

$dynamicButton = "<div class='d-flex justify-content-center'>
                <button type='submit' id='admnsbmt' name='renewPass' class='btn btn-primary'>Reset Password</button>
                </div>";

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-warning alert-dismissible fade show mt-2' style=\"font-family: 'Poppins', sans-serif;\"><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 

if (isset($_SESSION['status1'])) {
    $status1 = "<div class='alert alert-success alert-dismissible fade show mt-2' style=\"font-family: 'Poppins', sans-serif;\"><strong>{$_SESSION['status1']}</strong></div>";
    unset($_SESSION['status1']);
    $dynamicButton = "<div class='d-flex justify-content-center mt-3'>
    <button type='submit' id='admnsbmt' name='success' class='btn w-100 text-white' style='height: auto;
    margin-top: 15px;
    margin-bottom: 15px;
    font-size: 20px;
    background-color: #018100;
    border-style: none;
    border-radius: 41px;'>Ready to Log In, Again?</button>
    </div>";
} 

if (isset($_SESSION['status2'])) {
    $status2 = "<div class='alert alert-danger alert-dismissible fade show mt-2' style=\"font-family: 'Poppins', sans-serif;\"><strong>{$_SESSION['status2']}</strong></div>";
    unset($_SESSION['status2']);
}

$email = $_SESSION['email'];

if(isset($_POST['renewPass'])) { 

    $fieldsToValidate = array('new_password', 'confirm_password',);
        $allFieldsNotEmpty = true;

        // VALIDATION FOR EMPTY FIELDS
        foreach ($fieldsToValidate as $field) {
            if (empty($_POST[$field])) {
                $allFieldsNotEmpty = false;
                $emptyFields = "<div class='alert alert-danger mt-2' style=\"font-family: 'Poppins', sans-serif;\"><strong>Missing field/s.</strong></div>";
                break;
            }
        }
    
    if ($allFieldsNotEmpty) {

        $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        if ($newPassword !== $confirmPassword) {

            $_SESSION['status2'] = "Passwords do not match!";
            header("Location: student-forgot-password2.php");
            exit();

        } else {
            
            $query = "UPDATE students SET password = '$newPassword' WHERE email = '$email'";
            if (mysqli_query($conn, $query)) {
                
                session_start();
                $_SESSION['status1'] = "Password Reset Successful! Check your email for your new password.";

                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host =  'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'marcelinoryan.paul@gmail.com';
                $mail->Password = 'dfkoqclatjaxczbp';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('marcelinoryan.paul@gmail.com');

                $mail->addAddress($email);

                $mail->isHTML(true);

                $mail->Subject = 'Password Reset';
                $mail->AddCustomHeader('List-Unsubscribe: <mailto:marcelinoryan.paul@gmail.com>');

                $mail->Body = "Password Reset Successful! <br>";
                $mail->Body = "<br>";
                $mail->Body = "Your new password is: <strong>$newPassword</strong>";

                $mail->send();

                $query = "UPDATE students SET otp = NULL WHERE email = '$email'";
                $query_run = mysqli_query($conn, $query);

                header("Location: student-forgot-password2.php");
                exit();

            } else {

                $_SESSION['status2'] = "Password Update Unuccessfully!";
                header("Location: student-forgot-password2.ph");
                exit();

            }

        }

    }
}

if(isset($_POST['success'])) { 

    header("Location: student-login.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <!-- fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    
    <title>Student Forgot Password Page 2</title>
</head>

<body>
    <!-- header -->
    <div class="header bg-transparent">
        <div class="container-fluid p-3 white text-center">
            <img src="logo.svg" alt="logo" width="175">
            <h1 class="title text-center text-uppercase text-white">Student Attendance Management System</h1>
        </div>
    </div>

    <!-- identification -->
    <div class="cn-1 container">
        <div class="card mx-auto">
            <div class="card-body">
                <form action="student-forgot-password2.php" method="POST">
                    <div class="card-title text-center mt-3 mb-2">
                        <h5 class="adminlogin">Forgot Password?</h5>
                        <?php echo $emptyFields; ?>
                        <?php echo $status1; ?>
                        <?php echo $status2; ?>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" placeholder="Enter new password" name="new_password" autocomplete="off">
                            <div class="input-group-text">
                                <button class="btn toggle-password" type="button" data-target="new_password">
                                    <img src="eye-slash.svg">
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" placeholder="Re-enter New Password" name="confirm_password" autocomplete="off">
                            <div class="input-group-text">
                                <button class="btn toggle-password" type="button" data-target="confirm_password">
                                    <img src="eye-slash.svg">
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class='d-flex justify-content-center'>
                        <?php echo $dynamicButton; ?>
                    </div>
                  </form>
            </div>
        </div>
    </div>
    <a class="homebtn btn btn-floating text-white" href="student-login.php" role="button" id="homebtn">Back</a>

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        const toggleButtons = document.querySelectorAll('.toggle-password');

        toggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const icon = button.querySelector('img');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.src = 'eye.svg';
                } else {
                    passwordInput.type = 'password';
                    icon.src = 'eye-slash.svg';
                }
            });
        });

    </script>
</body>
</html>