<?php
include("db_conn.php");
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
      
      <title>Student View</title>
  </head>

  <body>
      <div class="header">
        <div class="container-fluid p-3">
                <div class="d-flex align-items-center mb-3">
                    <img src="logo.svg" alt="Logo" width="85">
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
                            <h1>STUDENT DETAILS:</h1>
                    </div>
                    <?php
                        if(isset($_GET['student_number'])) {
                            $student_id = mysqli_real_escape_string($conn, $_GET['student_number']);
                            $query = "SELECT * FROM students WHERE student_number='$student_id'";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0) {
                                $student = mysqli_fetch_array($query_run);
                                ?>
                                    <form action="student-view.php" method="POST">
                                        <input type="hidden" name="student_id" value="<?= $student_id?>">

                                            <div class="mb-3 mt-3">
                                            <label for="fullname" class="form-label">Student Number:</label>
                                            <span style="color: #004500; font-size: 12px;"><p><strong>*Please use this as a credential for logging in the user.</strong></p></span>
                                            <p class="form-control"><?=$student['student_number'];?></p>        
                                            </div>

                                            <div class="mb-3 mt-3">
                                            <label for="fullname" class="form-label">Full Name:</label>
                                            <p class="form-control"><?=$student['full_name'];?></p>        
                                            </div>

                                            <div class="mb-3">
                                            <label for="gender" class="form-label">Gender:</label>
                                            <p class="form-control"><?=$student['gender'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="birthdate" class="form-label">Date of Birth:</label>
                                            <p class="form-control"><?=$student['birthdate'];?></p> 
                                             </div>

                                            <div class="mb-3">
                                            <label for="city" class="form-label">City:</label>
                                            <p class="form-control"><?=$student['city'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="department" class="form-label">Year:</label>
                                            <p class="form-control"><?=$student['year'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="department" class="form-label">Course:</label>
                                            <p class="form-control"><?=$student['course'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="contact" class="form-label">Contact Number:</label>
                                            <p class="form-control"><?=$student['contact'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="email" class="form-label">E-mail:</label>
                                            <p class="form-control"><?=$student['email'];?></p>
                                            </div>

                                            <div class="mb-3">
                                            <label for="password" class="form-label">Password:</label>
                                            <span style="color: #004500; font-size: 12px;"><p><strong>*Please use this as a credential for logging in the user.</strong></p></span>
                                            <p class="form-control"><?=$student['password'];?></p>
                                            </div>

                                            <a class="btn text-white pull-right" href="admin-student.php" role="button" id="cancel">Back</a>
                                            </div>
                                    </form>
                                <?php
                            } else {
                                echo "No such student found!.";
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