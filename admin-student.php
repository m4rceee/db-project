<?php
session_start();

$status1 = $status = $emptyField = "";

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 

if (isset($_SESSION['status1'])) {
  $status1 = "<div class='alert alert-danger alert-dismissible fade show mt-2'><strong>{$_SESSION['status1']}</strong></div>";
  unset($_SESSION['status1']);
} 

  $con = mysqli_connect("localhost", "root", "", "students_db");

  if(!$con) {
    die("Connection Failed: ". mysqli_connect_error());
  }

  $con2 = mysqli_connect("localhost", "root", "", "courses_subj_db");

  if(!$con2) {
    die("Connection Failed: ". mysqli_connect_error());
  }

  // Fetch the dropdown options from the database
  $query = "SELECT DISTINCT course FROM courses_subj";
  $result = $con2->query($query);

  // Store the options in an array
  $options = array();
  while ($row = $result->fetch_assoc()) {
    $options[] = $row['course'];
  }

  // REGISTRATION PROCESS
  if(isset($_POST['save_student'])) {

    $fieldsToValidate = array('fullname', 'gender', 'birthdate', 'city', 'year', 'dropdown', 'contact', 'email');
    $allFieldsNotEmpty = true;

    // VALIDATION FOR EMPTY FIELDS
    foreach ($fieldsToValidate as $field) {
      if (empty($_POST[$field])) {
          $allFieldsNotEmpty = false;
          $emptyField = "<div class='alert alert-danger mt-2'><strong>Missing field/s.</strong></div>";
          break;
      }
    }

    if ($allFieldsNotEmpty) {

      // RANDOM PASSWORD GENERATION
      function generateRandomPassword($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()';
        $password = '';
    
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
      }

      // STUDENT NUMBER GENERATION
      $currentYear = date('Y');
      $random_number = mt_rand(10000, 99999);
      $studentNumber = $currentYear . $random_number;
      $studentNumber = str_pad($studentNumber, 9, '0', STR_PAD_LEFT);
 
        $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
        $gender = mysqli_real_escape_string($con, $_POST['gender']);
        $birthdate = mysqli_real_escape_string($con, $_POST['birthdate']);
        $city = mysqli_real_escape_string($con, $_POST['city']);
        $year = mysqli_real_escape_string($con, $_POST['year']);
        $course = mysqli_real_escape_string($con, $_POST['dropdown']);
        $contact = mysqli_real_escape_string($con, $_POST['contact']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = generateRandomPassword(8);

        // VALIDATION FOR EXISTING STUDENT
        $query = "SELECT email FROM students WHERE email = ?";
          $stmt = mysqli_prepare($con, $query);
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) > 0) {
            session_start();
            $_SESSION['status1'] = "Student already exists.";
            header("Location: admin-student.php");
            exit();
          } else {

            // REGISTER THE TEACHER IF THERE ISN'T EXISTING ONE ON THE DATABASE
            $query = "INSERT INTO students (student_number, full_name, gender, birthdate, city, year, course, contact, email, password) 
                  VALUES ('$studentNumber', '$fullname', '$gender', '$birthdate', '$city', '$year', '$course', '$contact', '$email', '$password')";
            $query_run = mysqli_query($con, $query);

            /*$query2 = "INSERT INTO students (course) VALUES ('$course')";

            $query_run2 = mysqli_query($con, $query2);*/

            if($query_run) {
              session_start();
              $_SESSION['status'] = "Student created successfully.";
              $redirectURL = 'admin-student.php?success=true&student_number=' . urlencode($studentNumber) . '&password=' . urlencode($password);
              header('Location: ' . $redirectURL);
              exit();
            } else {
              session_start();
              $_SESSION['status1'] = "Student creation unsuccessful.";
              header("Location: admin-student.php");
              exit();
            }
          }
      }
  }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="admin-student-style.css">

    <!-- fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    
    <title>Admin-Student</title>
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
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="admin-teacher.php" id="nav-item1">Teacher</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-student.php" id="nav-item2">Student</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-course&subj.php" id="nav-item3">Course & Subject</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin-attendance.html" id="nav-item4">Attendance</a>
            </li>
            </ul>
    </div>

    <div class="row">
        <!--REGISTER-->
        <div class="col-sm-4">
            <div class="card mt-3" id="regiscard">
                <div class="card-body">
                    <div class="card-title">
                        <h1 style="color: #fff;">REGISTER:</h1>
                        <?php echo $status1; ?>
                        <?php echo $status; ?>
                        <?php echo $emptyField; ?>
                    </div>
                    <form action="admin-student.php" method="POST">
                        <div class="mb-3 mt-3">
                            <label for="fullname" class="form-label">Full Name:</label>
                            <input type="text" class="form-control" id="fullname" placeholder="Enter full name" name="fullname" autocomplete="off"> 
                          </div>

                          <div class="mb-3">
                            <label for="gender" class="form-label">Gender:</label>
                            <input type="text" class="form-control" id="gender" placeholder="Enter gender" name="gender" autocomplete="off">
                          </div>

                          <div class="mb-3">
                            <label for="birthdate" class="form-label">Date of Birth:</label>
                            <input type="date" class="form-control" id="birthdate" placeholder="Enter birth date" name="birthdate" autocomplete="off">
                          </div>

                          <div class="mb-3">
                            <label for="city" class="form-label">City:</label>
                            <input type="text" class="form-control" id="city" placeholder="Enter city" name="city" autocomplete="off">
                          </div>

                          <div class="mb-3">
                            <label for="year" class="form-label">Year:</label>
                            <input type="number" class="form-control" id="year" placeholder="Enter year" name="year" autocomplete="off">
                          </div>

                          <div class="form- mb-3">
                            <label for="dropdown" style="color: #fff; margin-bottom: 7px;">Course:</label>
                            <select class="form-select" id="dropdown" name="dropdown">
                            <option selected disabled>Select a course</option> 
                              <?php foreach ($options as $option): ?>
                                <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          
                          <div class="mb-3">
                            <label for="contact" class="form-label">Contact Number:</label>
                            <input type="text" class="form-control" id="contact" placeholder="Enter contact number" name="contact" autocomplete="off">
                          </div>

                          <div class="mb-3">
                              <label for="email" class="form-label">E-mail:</label>
                              <input type="email" class="form-control" id="email" placeholder="Enter e-mail" name="email" autocomplete="off">
                            </div>

                          <div class="d-flex justify-content-center gap-2 mt-4 mb-2">
                            <button type="submit" name="save_student" id="studentsbmt" class="btn">Register</button>
                            <a class="btn text-white" href="admin-student.php" role="button" id="cancel">Cancel</a>
                          </div>
                          
                    </form>
        
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card mt-3" id="studentcard">
                <div class="card-body">
                    <div class="card-title">
                        <h1>STUDENTS:</h1>
                    </div>
                    <table class="table table-bordered table-striped" >
                        <thead>
                          <tr>
                            <th>Student Number</th>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Course</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php

                            $query = "SELECT * FROM students";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0) {
                              foreach($query_run as $student) {
                                ?>
                                  <tr>
                                    <td><?= $student['student_number']; ?></td>
                                    <td><?= $student['full_name']; ?></td>
                                    <td><?= $student['year']; ?></td>
                                    <td><?= $student['course']; ?></td>
                                    <td>
                                      <a href="student-view.php?student_number=<?= $student['student_number']; ?>" class="btn btn-sm">
                                        <img src="info.svg">
                                      </a>
                                      <a href="student-edit.php?student_number=<?= $student['student_number']; ?>" class="btn btn-sm">
                                      <img src="edit.svg">
                                      </a>
                                      <form action="student-delete.php" method="POST" class="d-inline">
                                          <button type="submit" name="delete_student" value="<?= $student['student_number']; ?>" class="btn btn-sm">
                                            <img src="delete.svg">
                                          </button>
                                      </form> 
                                    </td> 
                                  </tr>
                                <?php
                              }
                            } else {
                              echo "No records found.";
                            }
                          ?>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Student Registered!</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p>Here are the credentials needed for logging in:</p>
              <p>Student Number: <strong><span id="modalStudentNumber"></span></strong></p>
              <p>Password: <strong><span id="modalPassword"></span></strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #004500;">Close</button>
            </div>
          </div>
        </div>
      </div>

    <!-- script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        // When the document is ready
        $(document).ready(function() {
          // If the registration was successful, show the modal
          <?php if (isset($_GET['success']) && $_GET['success'] == 'true') { ?>
            $('#myModal').modal('show');
            var studentNumber = "<?php echo $_GET['student_number']; ?>";
            var password = "<?php echo $_GET['password']; ?>";
            $('#modalStudentNumber').text(studentNumber);
            $('#modalPassword').text(password);
          <?php } ?>
        });

        /*function updateDropdownButton(selectedCourse) {
          document.getElementById("dropdown").textContent = selectedCourse;
          document.getElementById("selectedCourse").value = selectedCourse;
        }*/

      </script>
  </body>
</html>