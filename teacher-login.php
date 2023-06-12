<?

$both_err = $notfound_err = $username_err = $password_err="";

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        if(empty($_POST['username']) && !empty($_POST['pswd'])) {
            $username_err = "<div class='alert alert-danger mt-2'><strong>Please enter a username.<strong></div>";
        } 
        if(empty($_POST['pswd']) && !empty($_POST['username'])) {
            $password_err = "<div class='alert alert-danger mt-2'><strong>Please enter a password.</strong></div>";
        }
        if(empty($_POST['username']) && empty($_POST['pswd'])) {
            $both_err = "<div class='alert alert-danger mt-2'><strong>This is a required field!</strong></div>";
        }

        $username = $_POST['username'];
        $pswd = $_POST['pswd'];

        $mysqli = new mysqli("localhost", "root", "", "admin_db");

        if ($mysqli->connect_errno) {
            $error_code = $mysqli->connect_errno;
            $error_message = $mysqli->connect_error;
            echo "The connection to the database failed with error code $error_code and error message $error_message";
        } else {
            $sql = "SELECT * FROM admin_user WHERE admin_name = ? AND password = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $username, $pswd);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                header("Location: admin-teacher.php");
                exit();
            } else {
                $notfound_err = "<div class='alert alert-danger mt-2'><strong>Cannot find the user.</strong></div>";
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
    </style>
    
    <title>Admin Log In Page</title>
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
                <form action="admin-login.php" method="POST">
                    <div class="card-title text-center mt-3 mb-2">
                        <h5 class="adminlogin">Admin Log In</h5>
                        <?php echo $notfound_err; ?>
                    </div>
                    <div class="mb-3 mt-3">
                      <label for="username" class="form-label"><strong>Username:</strong></label>
                      <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" autocomplete="off">
                        <?php echo $username_err; ?>
                        <?php echo $both_err; ?>
                    </div>
                    <div class="mb-4">
                      <label for="pwd" class="form-label"><strong>Password:</strong></label>
                        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd" autocomplete="off">
                        <?php echo $password_err; ?>
                        <?php echo $both_err; ?>
                        <!--<span class="input-group-text">
                            <button class="btn" id="eye">
                                <img src="eye-slash.svg">
                            </button>
                        </span>-->
                      
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" id="admnsbmt" class="btn btn-primary">Log In</button>
                    </div>
                  </form>
            </div>
        </div>
    </div>
    <a class="homebtn btn btn-floating text-white" href="home.php" role="button" id="homebtn">Back</a>

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        const password = document.getElementById("pwd");
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