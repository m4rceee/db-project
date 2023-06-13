<?php
session_start();

$status = "";

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-success alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 

if (isset($_SESSION['status'])) {
  $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
  unset($_SESSION['status']);
} 

$notfound_err = "";

    $con = mysqli_connect("localhost", "root", "", "teachers_db");

    if(!$con) {
      die("Connection Failed: ". mysqli_connect_error());
    }

    if(isset($_POST['update_teacher'])) {

        $teacher_id = mysqli_real_escape_string($con, $_POST['teacher_id']);
        $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
        $gender = mysqli_real_escape_string($con, $_POST['gender']);
        $birthdate = mysqli_real_escape_string($con, $_POST['birthdate']);
        $city = mysqli_real_escape_string($con, $_POST['city']);
        $department = mysqli_real_escape_string($con, $_POST['department']);
        $contact = mysqli_real_escape_string($con, $_POST['contact']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        //if(isset($_GET['EMP'])) {

            $sql = "SELECT password FROM teachers WHERE full_name = ? AND password = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ss", $fullname, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $query = "UPDATE teachers SET full_name='$fullname', gender='$gender', birthdate='$birthdate', 
                                city='$city', department='$department', contact='$contact', email='$email' 
                                WHERE EMP='$teacher_id'";
                    $query_run = mysqli_query($con, $query);

                    if($query_run) {
                        session_start();
                        $_SESSION['status'] = "Teacher updated successfully.";
                        header("Location: admin-teacher.php");
                        exit();
                      } else {
                        session_start();
                        $_SESSION['status'] = "Teacher update unsuccessful.";
                        header("Location: admin-teacher.php");
                        exit();
                      }
                } else {
                    $notfound_err = "<div class='alert alert-danger mt-2'><strong>Incorrect username or password.</strong></div>";
                }
        }
?>


<!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <link rel="stylesheet" href="teacher-edit.css">

      <!-- fonts -->
      <style>
          @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
          @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
      </style>
      
      <title>Teacher-Edit</title>
  </head>

  <body>
      <div class="header">
          <div class="container-fluid p-3">
              <div class="d-flex align-items-center mb-3">
                  <img src="logo.svg" alt="Logo" width="85">
                  <h1 class="title" style="font-size: 37px;">STUDENT ATTENDANCE MANAGEMENT SYSTEM</h1>
                  <a id="logout" href="logout.php">Logout</a>
                </div>
              
          </div>
      </div>
            <!-- FORM -->
              <div class="card mt-5 mx-auto" id="regiscard">
                  <div class="card-body">
                    <div class="card-title">
                            <h1>EDIT TEACHER:</h1>
                            <?php echo $notfound_err; ?>
                    </div>
                    <?php
                        if(isset($_GET['EMP'])) {
                            $teacher_id = mysqli_real_escape_string($con, $_GET['EMP']);
                            $query = "SELECT * FROM teachers WHERE EMP='$teacher_id'";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0) {
                                $teacher = mysqli_fetch_array($query_run);
                                ?>
                                    <form action="teacher-edit.php" method="POST">
                                        <input type="hidden" name="teacher_id" value="<?= $teacher_id?>">

                                            <div class="mb-3 mt-3">
                                            <label for="fullname" class="form-label">Full Name:</label>
                                            <input type="text" class="form-control" id="fullname" placeholder="Enter full name" value="<?=$teacher['full_name'];?>" name="fullname" autocomplete="off"> 
                                            </div>

                                            <div class="mb-3">
                                            <label for="gender" class="form-label">Gender:</label>
                                            <input type="text" class="form-control" id="gender" placeholder="Enter gender" value="<?=$teacher['gender'];?>" name="gender" autocomplete="off">
                                            </div>

                                            <div class="mb-3">
                                            <label for="birthdate" class="form-label">Date of Birth:</label>
                                            <input type="date" class="form-control" id="birthdate" placeholder="Enter birth date" value="<?=$teacher['birthdate'];?>" name="birthdate" autocomplete="off">
                                            </div>

                                            <div class="mb-3">
                                            <label for="city" class="form-label">City:</label>
                                            <input type="text" class="form-control" id="city" placeholder="Enter city" value="<?=$teacher['city'];?>" name="city" autocomplete="off">
                                            </div>

                                            <div class="mb-3">
                                            <label for="department" class="form-label">Department:</label>
                                            <input type="text" class="form-control" id="department" placeholder="Enter department" value="<?=$teacher['department'];?>" name="department" autocomplete="off">
                                            </div>

                                            <div class="mb-3">
                                            <label for="contact" class="form-label">Contact Number:</label>
                                            <input type="text" class="form-control" id="contact" placeholder="Enter contact number" value="<?=$teacher['contact'];?>" name="contact" autocomplete="off">
                                            </div>

                                            <div class="mb-3">
                                            <label for="email" class="form-label">E-mail:</label>
                                            <input type="email" class="form-control" id="email" placeholder="Enter e-mail" value="<?=$teacher['email'];?>" name="email" autocomplete="off">
                                            </div>

                                            <div class="mb-3">
                                            <label for="password" class="form-label">Password:</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" autocomplete="off">
                                                        <div class="input-group-text">
                                                            <button class="btn" type="button" id="eye">
                                                                <img src="eye-slash.svg">
                                                            </button>
                                                        </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center gap-2 mt-4 mb-2">
                                            <button type="submit" name="update_teacher" id="teachersbmt" class="btn">Update</button>
                                            <a class="btn text-white" href="#admin-teacher.php" role="button" id="cancel">Cancel</a>
                                            </div>
                                    </form>
                                <?php
                            } else {
                                echo "No such teacher found!.";
                            }
                        }
                    ?>
                      
                  </div>
              </div>
          </div>

                <!-- script -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script>
        const password = document.getElementById("password");
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