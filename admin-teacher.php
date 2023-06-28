<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include("db_conn.php");
date_default_timezone_set('Asia/Manila');

session_start();

$status2 = $status1 = $status = $emptyField = "";

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 

if (isset($_SESSION['status1'])) {
  $status1 = "<div class='alert alert-danger alert-dismissible fade show mt-2'><strong>{$_SESSION['status1']}</strong></div>";
  unset($_SESSION['status1']);
} 

if (isset($_SESSION['status2'])) {
  $status2 = "<div class='alert alert-danger alert-dismissible fade show mt-2'><strong>{$_SESSION['status2']}</strong></div>";
  unset($_SESSION['status2']);
} 

  //$con = mysqli_connect("localhost", "root", "", "teachers_db");

  if(!$conn) {
    die("Connection Failed: ". mysqli_connect_error());
  }

  // REGISTRATION PROCESS
  if(isset($_POST['save_teacher'])) {

    $fieldsToValidate = array('fullname', 'gender', 'birthdate', 'city', 'department', 'contact', 'email');
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

        $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = generateRandomPassword(8);
        $currentDate = date('Y-m-d'); // get current date

        // VALIDATION FOR EXISTING TEACHER
        $query = "SELECT email FROM teachers WHERE email = ?";
          $stmt = mysqli_prepare($conn, $query);
          mysqli_stmt_bind_param($stmt, "s", $email);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) > 0) {
            session_start();
            $_SESSION['status1'] = "Teacher already exists.";
            header("Location: admin-teacher.php");
            exit();
          } else {

            // VALIDATION FOR WHEN IT IS A REGISTERED STUDENT
            $query = "SELECT email FROM students WHERE email = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {

              session_start();
              $_SESSION['status1'] = "Profile you are trying to register is already registered as a student.";
              header("Location: admin-teacher.php");
              exit();

            } else {

              // REGISTER THE TEACHER IF THERE ISN'T EXISTING ONE ON THE DATABASE
              $query = "INSERT INTO teachers (full_name, gender, birthdate, city, department, contact, email, password, date_added) 
              VALUES ('$fullname', '$gender', '$birthdate', '$city', '$department', '$contact', '$email', '$password', '$currentDate')";
              
              $query_run = mysqli_query($conn, $query);

              if($query_run) {

                session_start();
                $_SESSION['status'] = "Teacher created successfully.";
                $redirectURL = 'admin-teacher.php?success=true&email=' . urlencode($email) . '&password=' . urlencode($password);
                header('Location: ' . $redirectURL);

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

                $mail->Subject = 'Registration Details';
                $mail->AddCustomHeader('List-Unsubscribe: <mailto:marcelinoryan.paul@gmail.com>');

                $mail->Body = "Dear <em>$fullname</em>, <br>";
                $mail->Body .= "<br>We have successfully registered you. Here are your registration details: <br>";
                $mail->Body .= "<br>";
                $mail->Body .= "<strong>Full Name:</strong> $fullname <br>";
                $mail->Body .= "<strong>Gender:</strong> $gender <br>";
                $mail->Body .= "<strong>Birthdate:</strong> $birthdate <br>";
                $mail->Body .= "<strong>City:</strong> $city <br>";
                $mail->Body .= "<strong>Department:</strong> $department <br>";
                $mail->Body .= "<strong>Contact:</strong> $contact <br>";
                $mail->Body .= "<strong>* Email:</strong> $email <br>";
                $mail->Body .= "<strong>* Password:</strong> $password <br>";
                $mail->Body .= "<br>* <em>Required for logging in</em> <br>";
                $mail->Body .= "<br>";
                $mail->Body .= "It would be appreciated if you kept this information confidential.<br>";
                $mail->Body .= "With best wishes,<br><em>Your School</em>";

                $mail->send();

                exit();

              } else {
                session_start();
                $_SESSION['status1'] = "Teacher creation unsuccessful.";
                header("Location: admin-teacher.php");
                exit();
              }
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
      <link rel="stylesheet" href="admin-style.css">

      <!-- fonts -->
      <style>
          @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
          @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
      </style>
      
      <title>Admin Teacher</title>
  </head>

  <body>
      <div class="header">
          <div class="headercontainer container-fluid p-3">
            <div class="d-flex align-items-center mb-3">
              <a href="admin-teacher.php">
                <img src="logo.svg" alt="Logo" width="85">
              </a>
              <h1 class="title" style="font-size: 37px; margin-bottom: 0px;">STUDENT ATTENDANCE MANAGEMENT SYSTEM</h1>
            </div>
          </div>
          
          <div class="container-fluid mt-3 mb-3">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                  <h1 class="text-white mb-0">Hello, Admin!</h1>
                  <div class="d-flex align-items-center">
                    <button id="logout" onclick="window.location.href='logout.php'" class="btn text-white ms-auto me-0">Logout</button>
                  </div>
                </div>    
              </div>
              <div class="card-body">
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
                  <a class="nav-link" href="admin-attendance.php" id="nav-item4">Attendance</a>
              </li>
              </ul>
        </div>

      <div class="row">
          <!--REGISTER-->
          <div class="col-sm-4">
              <div class="card mt-3" id="regiscard">
                  <div class="card-body">
                      <div class="card-title">
                          <h1>REGISTER:</h1>
                          <?php echo $status1; ?>
                          <?php echo $status; ?>
                          <?php echo $emptyField; ?>
                      </div>
                      <form action="admin-teacher.php" method="POST">
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
                              <label for="department" class="form-label">Department:</label>
                              <input type="text" class="form-control" id="department" placeholder="Enter department" name="department" autocomplete="off">
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
                              <button type="submit" name="save_teacher" id="teachersbmt" class="btn">Register</button>
                              <a class="btn text-white" href="admin-teacher.php" role="button" id="cancel">Cancel</a>
                            </div>
                            
                      </form>
          
                  </div>
              </div>
          </div>

          <div class="col-sm-8">
              <div class="card mt-3" id="teachercard">
                  <div class="card-body">
                      <div class="card-title">
                        <div class="d-flex justify-content-between align-items-center">
                          <h1 class="mb-0" style="color: #004500;">TEACHERS: </h1>
                          <div class="d-flex align-items-center">
                            <input type="text" id="search-input" class="form-control me-2" placeholder="Search">
                            <button class="btn btn-sm text-white mt-2 mb-2 me-0" id="search-button" style="background-color: #004500;">
                              <img src="search.svg">
                            </button>
                          </div>
                        </div>
                      </div>
                      <table id="teacher-table" class="table table-borderless table-striped table-hover">
                          <thead class="table-success">
                            <tr>
                              <th>EMP</th>
                              <th>Name</th>
                              <th>Department</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php

                              $query = "SELECT * FROM teachers";
                              $query_run = mysqli_query($conn, $query);

                              if(mysqli_num_rows($query_run) > 0) {
                                foreach($query_run as $teacher) {
                                  ?>
                                    <tr>
                                      <td><?= $teacher['EMP']; ?></td>
                                      <td><?= $teacher['full_name']; ?></td>
                                      <td><?= $teacher['department']; ?></td>
                                      <td>
                                        <a href="teacher-view.php?EMP=<?= $teacher['EMP']; ?>" class="btn btn-sm">
                                          <img src="view.svg">
                                        </a>
                                        <a href="teacher-edit.php?EMP=<?= $teacher['EMP']; ?>" class="btn btn-sm">
                                          <img src="user-edit.svg">
                                        </a>
                                        <form action="teacher-delete.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                                          <button type="submit" name="delete_teacher" value="<?= $teacher['EMP']; ?>" class="btn btn-sm">
                                              <img src="user-remove.svg">
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
              </div>
            </div>
          </div>

          

      <!-- Bootstrap modal -->
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
            var email = "<?php echo $_GET['email']; ?>";
            var password = "<?php echo $_GET['password']; ?>";
            $('#modalEmail').text(email);
            $('#modalPassword').text(password);
          <?php } ?>
        });

        // Function to handle search button click
        function fetchSearchResults() {
            // Get the search input value
            var searchInput = document.getElementById("search-input").value;

            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Prepare the request
            xhr.open("GET", "search_teacher.php?search=" + encodeURIComponent(searchInput), true);

            // Send the request
            xhr.send();

            // Handle the response from the server
            xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Response received, update the table with search results
                var table = document.getElementById("teacher-table");
                table.innerHTML = xhr.responseText;
            }
            };
        }

        // Add event listener to the search button
        var searchButton = document.getElementById("search-button");
        searchButton.addEventListener("click", function(e) {
            e.preventDefault();
            fetchSearchResults();
        });
        
      </script>
    </body>
</html>