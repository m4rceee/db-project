<?php
include("db_conn.php")

    /* UPDATE RECORD
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
    }*/
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
      
      <title>Teacher View</title>
  </head>

  <body>
      <div class="header">
        <div class="container-fluid p-3">
                <div class="d-flex align-items-center mb-3">
                <a href="admin-teacher.php">
                  <img src="logo.svg" alt="Logo" width="85">
                </a>
                    <h1 class="title" style="font-size: 37px; margin-bottom: 0px;">STUDENT ATTENDANCE MANAGEMENT SYSTEM</h1>
                    <a id="logout" href="logout.php" class="ms-auto me-0">Logout</a>
                </div>
            </div>
          </div>
      </div>
            <!-- FORM -->
              <div class="card mt-5 mx-auto" id="regiscard">
                  <div class="card-body">
                    <div class="card-title">
                            <h1>TEACHER DETAILS:</h1>
                    </div>
                    <?php
                        if(isset($_GET['EMP'])) {
                            $teacher_id = mysqli_real_escape_string($conn, $_GET['EMP']);
                            $query = "SELECT * FROM teachers WHERE EMP='$teacher_id'";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0) {
                                $teacher = mysqli_fetch_array($query_run);
                                ?>
                                    <form action="teacher-view.php" method="POST">
                                        <input type="hidden" name="teacher_id" value="<?= $teacher_id?>">

                                            <div class="mb-3 mt-3">
                                            <label for="fullname" class="form-label">Full Name:</label>
                                            <p class="form-control"><?=$teacher['full_name'];?></p>        
                                            </div>

                                            <div class="mb-3">
                                            <label for="gender" class="form-label">Gender:</label>
                                            <p class="form-control"><?=$teacher['gender'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="birthdate" class="form-label">Date of Birth:</label>
                                            <p class="form-control"><?=$teacher['birthdate'];?></p> 
                                             </div>

                                            <div class="mb-3">
                                            <label for="city" class="form-label">City:</label>
                                            <p class="form-control"><?=$teacher['city'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="department" class="form-label">Department:</label>
                                            <p class="form-control"><?=$teacher['department'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="contact" class="form-label">Contact Number:</label>
                                            <p class="form-control"><?=$teacher['contact'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="email" class="form-label">E-mail:</label>
                                            <span style="color: #004500; font-size: 12px;"><p><strong>*Credential for user logging in.</strong></p></span>
                                            <p class="form-control"><?=$teacher['email'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="password" class="form-label">Password:</label>
                                            <span style="color: #004500; font-size: 12px;"><p><strong>*Credential for user logging in.</strong></p></span>
                                            <p class="form-control"><?=$teacher['password'];?></p>
                                            </div>

                                            <a class="btn text-white pull-right" href="admin-teacher.php" role="button" id="cancel">Back</a>
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
    </body>
  </html>