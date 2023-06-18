<?php
session_start();

$fullname_err = $subjcode_err = $status1 = $status = $both_err = $emptyField = "";

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 

if (isset($_SESSION['status1'])) {
  $status1 = "<div class='alert alert-danger alert-dismissible fade show mt-2'><strong>{$_SESSION['status1']}</strong></div>";
  unset($_SESSION['status1']);
}

$con = mysqli_connect("localhost", "root", "", "teachers_db");
    if(!$con) {
      die("Connection Failed: ". mysqli_connect_error());
    }

$con2 = mysqli_connect("localhost", "root", "", "students_db");
    if(!$con2) {
      die("Connection Failed: ". mysqli_error($con2));
}

$con3 = mysqli_connect("localhost", "root", "", "courses_subj_db");
    if(!$con3) {
      die("Connection Failed: ". mysqli_error($con3));
}

$con4 = mysqli_connect("localhost", "root", "", "attendance_db");
    if(!$con4) {
      die("Connection Failed: ". mysqli_error($con4));
}

if(isset($_POST['submit_student'])) {

  /*if(!empty($_POST['fullname']) && !empty($_POST['subjectcode'])) {
    $teacherId = mysqli_real_escape_string($con, $_GET['EMP']);
    $studentName = mysqli_real_escape_string($con2, $_POST['fullname']);
    $subjectCode = mysqli_real_escape_string($con3, $_POST['subjectcode']);

    // Get the current date
    $currentDate = date('Y-m-d');

    $studentQuery = "SELECT * FROM students WHERE full_name = '$studentName'";
    $subjectQuery = "SELECT * FROM courses_sbj WHERE subj_code = '$subjectCode'";

    $con4 = mysqli_connect("localhost", "root", "", "attendance_db");
      if(!$con4) {
        die("Connection Failed: ". mysqli_error($con4));
      } else {
        
        // VALIDATION FOR EXISTING STUDENT
        $query = "SELECT full_name FROM students WHERE full_name = ?";
          $stmt = mysqli_prepare($con2, $query);
          mysqli_stmt_bind_param($stmt, "s", $studentName);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) > 0 && mysqli_stmt_num_rows($stmt2) > 0) {
            
            // FETCH THE REQUIRED ROWS
            $query = "SELECT student_number, full_name, year, course FROM students WHERE full_name = '$studentName'";
            $result = mysqli_query($con, $query);

            $query2 = "SELECT subj_code FROM courses_subj WHERE subj_code = '$subjectCode'";
            $result2 = mysqli_query($con, $query2);

            if ($result && $result2) {

                // FETCH THE ROWS FROM THE RESULT
                while ($row = mysqli_fetch_assoc($result && $result2)) {

                    // STORE THE VALUES INTO THE VARIABLES
                    $column1Value = $row['student_number'];
                    $column2Value = $row['full_name'];
                    $column3Value = $row['year'];
                    $column4Value = $row['course'];
                    $column5Value = $row['subj_code'];

                    // INSERT INTO THE ATTENDANCE DATABASE
                    $con4 = mysqli_connect("localhost", "root", "", "attendance_db");

                    $query = "INSERT INTO attendance (student_number, full_name, year, course, subj_code, date)
                              VALUES ('$column1Value', '$column2Value', '$column3Value', '$column4Value', '$column5Value', '$currentDate')";
                    
                    $query_run = mysqli_query($con4, $query);

                    if($query_run) {
                      session_start();
                      $_SESSION['status'] = "Student added successfully.";
                      header("Location: teacher.php?EMP=".$teacher_id);
                      exit();
                    } else {
                      session_start();
                      $_SESSION['status1'] = "Adding student error.";
                      header("Location: teacher.php?EMP=".$teacher_id);
                      exit();
                  }
                } 
            }
          } else {
            session_start();
            $_SESSION['status1'] = "Student or Subject doesn't exist.";
            header("Location: teacher.php?EMP=".$teacher_id);
            exit();
          }
        }
  } else if(empty($_POST['fullname']) && !empty($_POST['subjectcode'])) {
      $fullname_err = "<div class='alert alert-danger mt-2'><strong>Please enter an e-mail.<strong></div>";
  } 
  else if(empty($_POST['subjectcode']) && !empty($_POST['fullname'])) {
      $subjcode_err = "<div class='alert alert-danger mt-2'><strong>Please enter a password.</strong></div>";
  }
  else if(empty($_POST['fullname']) && empty($_POST['subjectcode'])) {
      $both_err = "<div class='alert alert-danger mt-2'><strong>This is a required field!</strong></div>";
  }
}*/

if (!empty($_POST['fullname']) && !empty($_POST['subjectcode'])) {

  $teacherId = mysqli_real_escape_string($con, $_GET['EMP']);
  $studentName = mysqli_real_escape_string($con, $_POST['fullname']);
  $subjectCode = mysqli_real_escape_string($con, $_POST['subjectcode']);

  // Get the current date
  $currentDate = date('Y-m-d');

  // VALIDATION FOR EXISTING STUDENT
  $query = "SELECT full_name FROM students WHERE full_name = ?";
  $stmt = mysqli_prepare($con, $query);
  mysqli_stmt_bind_param($stmt, "s", $studentName);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);

  // VALIDATION FOR EXISTING SUBJECT
  $query2 = "SELECT subj_code FROM courses_subj WHERE subj_code = ?";
  $stmt2 = mysqli_prepare($con, $query2);
  mysqli_stmt_bind_param($stmt2, "s", $subjectCode);
  mysqli_stmt_execute($stmt2);
  mysqli_stmt_store_result($stmt2);

  if (mysqli_stmt_num_rows($stmt) > 0 && mysqli_stmt_num_rows($stmt2) > 0) {
      // FETCH THE REQUIRED ROWS
      $query = "SELECT student_number, full_name, year, course FROM students WHERE full_name = ?";
      $stmt = mysqli_prepare($con, $query);
      mysqli_stmt_bind_param($stmt, "s", $studentName);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      $query2 = "SELECT subj_code FROM courses_subj WHERE subj_code = ?";
      $stmt2 = mysqli_prepare($con, $query2);
      mysqli_stmt_bind_param($stmt2, "s", $subjectCode);
      mysqli_stmt_execute($stmt2);
      $result2 = mysqli_stmt_get_result($stmt2);

      if ($result && $result2) {
          // FETCH THE ROWS FROM THE RESULT
          while ($row = mysqli_fetch_assoc($result)) {
              // STORE THE VALUES INTO THE VARIABLES
              $column1Value = $row['student_number'];
              $column2Value = $row['full_name'];
              $column3Value = $row['year'];
              $column4Value = $row['course'];
              $column5Value = $subjectCode;

              // INSERT INTO THE ATTENDANCE DATABASE
              $query = "INSERT INTO attendance (student_number, full_name, year, course, subj_code, date)
                        VALUES (?, ?, ?, ?, ?, ?)";
              $stmt = mysqli_prepare($con4, $query);
              mysqli_stmt_bind_param($stmt, "ssssss", $column1Value, $column2Value, $column3Value, $column4Value, $column5Value, $currentDate);
              mysqli_stmt_execute($stmt);

              if (mysqli_stmt_affected_rows($stmt) > 0) {
                  session_start();
                  $_SESSION['status'] = "Student added successfully.";
                  header("Location: teacher.php?EMP=<?php echo $teacherId; ?>");
                  exit();
              } else {
                  session_start();
                  $_SESSION['status1'] = "Adding student error.";
                  header("Location: teacher.php?EMP=<?php echo $teacherId; ?>");
                  exit();
              }
          }
      }
  } else {
      session_start();
      $_SESSION['status1'] = "Student or Subject doesn't exist.";
      header("Location: teacher.php?EMP=<?php echo $teacherId; ?>");
      exit();
  }
} else if (empty($_POST['fullname']) && !empty($_POST['subjectcode'])) {
  $fullname_err = "<div class='alert alert-danger mt-2'><strong>Please enter an e-mail.<strong></div>";
} else if (!empty($_POST['fullname']) && empty($_POST['subjectcode'])) {
  $subjcode_err = "<div class='alert alert-danger mt-2'><strong>Please enter a password.</strong></div>";
} else if (empty($_POST['fullname']) && empty($_POST['subjectcode'])) {
  $both_err = "<div class='alert alert-danger mt-2'><strong>This is a required field!</strong></div>";
}
}

?>

<!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <link rel="stylesheet" href="teacher-style.css">

      <!-- fonts -->
      <style>
          @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
          @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
      </style>
      
      <title>Teacher</title>
  </head>

  <body>
      <div class="header">
          <div class="header-container container-fluid p-3">
              <div class="d-flex align-items-center mb-3">
                  <img src="logo.svg" alt="Logo" width="85">
                  <h1 class="title" style="font-size: 37px; margin-bottom: 0px;">STUDENT ATTENDANCE MANAGEMENT SYSTEM</h1>
                  <a id="logout" href="logout.php" class="ms-auto me-0">Logout</a>
              </div>
          </div>
      </div>

      <div class="container-fluid">
        <?php
          if(isset($_GET['EMP'])) {
          $teacher_id = mysqli_real_escape_string($con, $_GET['EMP']);
          $query = "SELECT * FROM teachers WHERE EMP='$teacher_id'";
          $query_run = mysqli_query($con, $query);

            if(mysqli_num_rows($query_run) > 0) {
              $teacher = mysqli_fetch_array($query_run);
              ?>
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center mb-3">
                    <img src="user.svg">
                    <h1 class="teachername" style="font-size: 50px; margin-top: 0px; margin-bottom: 0px; margin-left: 10px;">Teacher Profile: <strong><?php echo $teacher['full_name'];?></strong>
                    </h1> 
                    <a href="#" class="chgpass btn btn-sm text-white ms-auto me-0">Change Password</a>
                  </div>
                </div>

                <div class="card-body">
                  <div class="p-container">
                    <div class="line1">
                      <p>Full name: <span style="text-decoration: underline;"><?php echo $teacher['full_name'];?></span></p>
                      <p>Gender: <span style="text-decoration: underline;"><?php echo $teacher['gender'];?></span></p>
                      <p>Date of Birth: <span style="text-decoration: underline;"><?php echo $teacher['birthdate'];?></span></p>
                      <p>City: <span style="text-decoration: underline;"><?php echo $teacher['city'];?></span></p>
                    </div>
                    <div class="line2">
                      <p>Department: <span style="text-decoration: underline;"><?php echo $teacher['department'];?></span></p>
                      <p>Contact Number: <span style="text-decoration: underline;"><?php echo $teacher['contact'];?></span></p>
                      <p>E-mail: <span style="text-decoration: underline;"><?php echo $teacher['email'];?></span></p>
                    </div>
                  </div>
                </div>

              </div>
              <?php
            }  
          }
        ?>
      </div> 
      
      <div class="container mt-3">
          <div class="col-auto">
            <?php echo $status1; ?>
            <?php echo $status; ?>
            <?php echo $emptyField; ?>
            <h1 style="color: #004500; margin-right: 20px;">Select a Student:</h1>
          </div>
          <div class="col">
            <?php
              if(isset($_GET['EMP'])) {
              $teacher_id = mysqli_real_escape_string($con, $_GET['EMP']);
              $query = "SELECT * FROM teachers WHERE EMP='$teacher_id'";
              $query_run = mysqli_query($con, $query);

              if(mysqli_num_rows($query_run) > 0) {
                $teacher = mysqli_fetch_array($query_run);
                ?>
                <form action="teacher.php?EMP=<?php echo $teacherId; ?>" method="POST">
                <input type="hidden" name="teacher_id" value="<?= $teacher_id?>">
                    <div class="row">
                      <div class="col">
                        <div>
                          <!--<label for="fullname" class="form-label">Student Name:</label>-->
                          <input type="text" class="form-control" id="fullname" placeholder="Enter student full name" name="fullname" autocomplete="off"> 
                        </div>
                      </div>
                      <div class="col">
                        <div>
                          <!--<label for="subjectcode" class="form-label">Subject Code:</label>-->
                          <input type="text" class="form-control" id="subjectcode" placeholder="Enter subject code" name="subjectcode" autocomplete="off"> 
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn mt-3 text-white" name="submit_student" id="studentsbmt">Submit</button>
                </form>
              <?php
                } else {
                  echo "No such teacher found!.";
                }
            }
            ?>
          </div>
      </div>

      <div class="container mt-3">
        <h1 style="color: #004500; margin-right: 20px;">Mark Attendance</h1>
        <a href="#" class="chgpass btn btn-sm text-white mt-3 mb-2 me-0">Attendance Record</a>
        <table class="table table-hover table-striped">
          <thead class="table-success">
            <tr>
              <th>Student ID</th>
              <th>Name</th>
              <th>Year</th>
              <th>Course</th>
              <th>Subject</th>
              <th>Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php
              
                $query = "SELECT * FROM attendance";
                $query_run = mysqli_query($con4, $query);

                if(mysqli_num_rows($query_run) > 0) {
                  foreach($query_run as $student) {
                    ?>
                      <tr>
                          <td><?= $student['student_number']; ?></td>
                          <td><?= $student['full_name']; ?></td>
                          <td><?= $student['year']; ?></td>
                          <td><?= $student['course']; ?></td>
                          <td><?= $student['subj_code']; ?></td>
                          <td><?= $student['date']; ?></td>
                          <td>
                              <a href="#?>" class="btn btn-sm">
                                  <img src="view.svg">
                              </a>
                              <a href="#" class="btn btn-sm">
                                  <img src="user-edit.svg">
                              </a>
                              <form action="#" method="POST" class="d-inline">
                                  <button type="submit" name="delete_teacher" value="#" class="btn btn-sm delete-row-btn">
                                      <img src="user-remove.svg">
                                  </button>
                              </form>
                          </td>
                      </tr>
                      <?php
                  }
              } else {
                  echo "No student record/Subject found.";
              }
              ?>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Bootstrap modal
      <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Teacher Registered!</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p>Here are the credentials needed for logging in:</p>
              <p>Email: <strong><span id="modalEmail"></span></strong></p>
              <p>Password: <strong><span id="modalPassword"></span></strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #004500;">Close</button>
            </div>
          </div>
        </div>
      </div> -->

      <!-- script -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script>

        /* When the document is ready
        $(document).ready(function() {
          // If the registration was successful, show the modal
          <?php if (isset($_GET['success']) && $_GET['success'] == 'true') { ?>
            $('#myModal').modal('show');
            var email = "<?php echo $_GET['email']; ?>";
            var password = "<?php echo $_GET['password']; ?>";
            $('#modalEmail').text(email);
            $('#modalPassword').text(password);
          <?php } ?>
        });

        /*$(document).ready(function() {
          $('.delete-row-btn').click(function() {
            $(this).closest('tr').remove();
          });
        });*/

      </script>
    </body>
</html>