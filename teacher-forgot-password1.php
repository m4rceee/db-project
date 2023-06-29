<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include("db_conn.php");

session_start();

$dynamicButton2 = $proceedButton = $status = $status1 = $status2 = "";

$dynamicButton1 = "<div class='d-flex justify-content-center'>
                    <button type='submit' id='admnsbmt' name='sendOtp' class='btn btn-primary'>Send OTP</button>
                </div>";

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-warning alert-dismissible fade show mt-2' style=\"font-family: 'Poppins', sans-serif;\"><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 

if (isset($_SESSION['status1'])) {
    $status1 = "<div class='alert alert-success alert-dismissible fade show mt-2' style=\"font-family: 'Poppins', sans-serif;\"><strong>{$_SESSION['status1']}</strong></div>";
    unset($_SESSION['status1']);
    $dynamicButton1 = "";
    $dynamicButton2 = "<div class='d-flex justify-content-center mt-3'>
    <button type='submit' id='otpsbmt' name='passRenew' class='btn w-100 text-white my-button' style='height: auto;
    margin-top: 15px;
    margin-bottom: 15px;
    font-size: 20px;
    background-color: #018100;
    border-style: none;
    border-radius: 41px;'>Proceed to Password Renewal</button>
    </div>";
} 

if (isset($_SESSION['status2'])) {
    $status2 = "<div class='alert alert-danger alert-dismissible fade show mt-2' style=\"font-family: 'Poppins', sans-serif;\"><strong>{$_SESSION['status2']}</strong></div>";
    unset($_SESSION['status2']);
}


if(isset($_POST['sendOtp'])) { 

    if(empty($_POST['email'])) {

        session_start();
        $_SESSION['status2'] = "Please enter an email.";
        header("Location: teacher-forgot-password1.php");
        exit();

    } else {

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $query = "SELECT * FROM teachers WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {

            $otp = mt_rand(100000, 999999);
            $query = "UPDATE teachers SET otp = '$otp' WHERE email = '$email'";
            $query_run = mysqli_query($conn, $query);

            session_start();
            $_SESSION['status1'] = "Your OTP was sent on your email. Please enter it on the OTP field provided.";
            $_SESSION['email'] = $email; // Store the email in session for later use

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

                $mail->Subject = 'OTP Request for Password Renewal';
                $mail->AddCustomHeader('List-Unsubscribe: <mailto:marcelinoryan.paul@gmail.com>');

                $mail->Body = "Your OTP is: <strong>$otp</strong>";

                $mail->send();

                header("Location: teacher-forgot-password1.php");
                exit();

        } else {

            session_start();
            $_SESSION['status2'] = "Email isn't registered.";
            header("Location: teacher-forgot-password1.php");
            exit();

        }
    }
}

if(isset($_POST['passRenew'])) {

    if(empty($_POST['otp'])) {

        session_start();
        $_SESSION['status2'] = "Please enter the OTP.";
        header("Location: teacher-forgot-password1.php");
        exit();

    } else {

        $otp = mysqli_real_escape_string($conn, $_POST['otp']);
        $email = $_SESSION['email']; // Retrieve the email from session

        $query = "SELECT * FROM teachers WHERE email = ? AND otp = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $email, $otp);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // OTP is correct, redirect to another page
            header("Location: teacher-forgot-password2.php");
            exit();
        } else {
            session_start();
            $_SESSION['status2'] = "Invalid OTP.";
            header("Location: teacher-forgot-password1.php");
            exit();
        }
    }
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

        .my-button {
            transition-duration: 0.4s;
        }
        .my-button:hover {
            background-color: #004500;
        }
    </style>
    
    <title>Forgot Password</title>
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
                <form action="teacher-forgot-password1.php" method="POST">
                    <div class="card-title text-center mt-3 mb-2">
                        <h5 class="adminlogin">Forgot Password?</h5>
                        <?php echo $status; ?>
                        <?php echo $status1; ?>
                        <?php echo $status2; ?>
                    </div>
                    <div class="mb-3 mt-3">
                        <p>Please enter your <strong>email</strong> so that we can send you an OTP for renewing your password.<p>
                        <!--<label for="email" class="form-label"><strong>Email:</strong></label>-->
                        <input type="email" class="form-control" id="email" placeholder="Enter e-mail" name="email" autocomplete="off">
                    </div>
                    <div class="d-flex justify-content-center">
                        <?php echo $dynamicButton1; ?>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="otp" class="form-label"><strong>OTP:</strong></label>
                            <input type="text" class="form-control" id="otp" placeholder="Enter OTP" name="otp" autocomplete="off">
                    </div>
                    <div class="d-flex justify-content-center">
                        <?php echo $dynamicButton2; ?>
                    </div>
                  </form>
            </div>
        </div>
    </div>
    <a class="homebtn btn btn-floating text-white" href="teacher-login.php" role="button" id="homebtn">Back</a>

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        const password = document.getElementById("newPass");
        const eye = document.getElementById("eye");
        eye.classList.add("custom-eye-icon");

        eye.addEventListener("click", () => {
        if (password.type === "password") {
            password.type = "text";
            eye.innerHTML = `<svg class="custom-eye-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>`;
        } else {
            password.type = "password";
            eye.innerHTML = `<svg class="custom-eye-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"/>
                            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                            <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                        </svg>`;
        }
        });
    </script>
</body>
</html>