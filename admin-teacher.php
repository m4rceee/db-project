<?php
session_start();

$status = $emptyField = "";

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-success alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 

if (isset($_SESSION['status'])) {
  $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
  unset($_SESSION['status']);
} 

  $con = mysqli_connect("localhost", "root", "", "teachers_db");

  if(!$con) {
    die("Connection Failed: ". mysqli_connect_error());
  }

  if(isset($_POST['save_teacher'])) {

    $fieldsToValidate = array('fullname', 'gender', 'birthdate', 'city', 'department', 'contact', 'email');
    $allFieldsNotEmpty = true;

    foreach ($fieldsToValidate as $field) {
      if (empty($_POST[$field])) {
          $allFieldsNotEmpty = false;
          $emptyField = "<div class='alert alert-danger mt-2'><strong>Missing field/s.</strong></div>";
          break;
      }
    }

    if ($allFieldsNotEmpty) {

      function generateRandomPassword($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()';
        $password = '';
    
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $password;
      }

        $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
        $gender = mysqli_real_escape_string($con, $_POST['gender']);
        $birthdate = mysqli_real_escape_string($con, $_POST['birthdate']);
        $city = mysqli_real_escape_string($con, $_POST['city']);
        $department = mysqli_real_escape_string($con, $_POST['department']);
        $contact = mysqli_real_escape_string($con, $_POST['contact']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = generateRandomPassword(8);

        $query = "INSERT INTO teachers (full_name, gender, birthdate, city, department, contact, email, password) 
                  VALUES ('$fullname', '$gender', '$birthdate', '$city', '$department', '$contact', '$email', '$password')";
        
        $query_run = mysqli_query($con, $query);

        if($query_run) {
          session_start();
          $_SESSION['status'] = "Teacher created successfully.";
          header("Location: admin-teacher.php");
          exit();
        } else {
          session_start();
          $_SESSION['status'] = "Teacher creation unsuccessful.";
          header("Location: admin-teacher.php");
          exit();
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
      
      <title>Admin-Teacher</title>
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
                  <a class="nav-link" href="admin-student.html" id="nav-item2">Student</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="admin-course&subj.html" id="nav-item3">Course & Subject</a>
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
                          <h1>REGISTER:</h1>
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
                          <h1 style="color: #004500;">TEACHERS:</h1>
                      </div>
                      <table class="table table-bordered table-striped" id="table-bg">
                          <thead>
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
                              $query_run = mysqli_query($con, $query);

                              if(mysqli_num_rows($query_run) > 0) {
                                foreach($query_run as $teacher) {
                                  ?>
                                    <tr>
                                      <td><?= $teacher['EMP']; ?></td>
                                      <td><?= $teacher['full_name']; ?></td>
                                      <td><?= $teacher['department']; ?></td>
                                      <td>
                                        <a href="teacher-view.php?EMP=<?= $teacher['EMP']; ?>" class="btn btn-primary btn-sm">View</a>
                                        <a href="teacher-edit.php?EMP=<?= $teacher['EMP']; ?>" class="btn btn-success btn-sm">Edit</a>
                                        <form action="teacher-delete.php" method="POST" class="d-inline">
                                            <button type="submit" name="delete_teacher" value="<?= $teacher['EMP']; ?>" class="btn btn-danger btn-sm">Delete</button>
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

          
      




      <!-- script -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
  </html>