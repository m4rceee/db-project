<?php
include("db_conn.php");

session_start();

$status3 = "";

if (isset($_SESSION['status3'])) {
  $status3 = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status3']}</strong></div>";
  unset($_SESSION['status3']);
} 

/*session_start();

$fullname_err = $subjcode_err = $status1 = $status = $both_err = $emptyField = "";

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 

if (isset($_SESSION['status1'])) {
  $status1 = "<div class='alert alert-danger alert-dismissible fade show mt-2'><strong>{$_SESSION['status1']}</strong></div>";
  unset($_SESSION['status1']);
}

if(isset($_POST['submit_student'])) {

  if (!empty($_POST['fullname']) && !empty($_POST['subjectcode'])) {

    $teacherId = mysqli_real_escape_string($conn, $_GET['EMP']);
    $studentName = mysqli_real_escape_string($conn, $_POST['fullname']);
    $subjectCode = mysqli_real_escape_string($conn, $_POST['subjectcode']);
    $currentDate = date('Y-m-d'); // get current date
  
    // VALIDATION FOR EXISTING STUDENT
    $query = "SELECT student_number, full_name, year, course FROM students WHERE full_name = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $studentName);
    mysqli_stmt_execute($stmt);
    $studentResult = mysqli_stmt_get_result($stmt);
  
    // VALIDATION FOR EXISTING SUBJECT
    $query2 = "SELECT subj_code FROM subjects WHERE subj_code = ?";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "s", $subjectCode);
    mysqli_stmt_execute($stmt2);
    $subjectResult = mysqli_stmt_get_result($stmt2);
  
    if (mysqli_num_rows($studentResult) > 0 && mysqli_num_rows($subjectResult) > 0) {

      $studentRow = mysqli_fetch_assoc($studentResult);
      $subjectRow = mysqli_fetch_assoc($subjectResult);

                // STORE THE VALUES INTO THE VARIABLES
                $column1Value = $studentRow['student_number'];
                $column2Value = $studentRow['full_name'];
                $column3Value = $studentRow['year'];
                $column4Value = $studentRow['course'];
                $column5Value = $subjectRow['subj_code'];
  
                // INSERT INTO THE ATTENDANCE DATABASE
                $query = "INSERT INTO attendance (teacher_id, student_number, full_name, year, course, subj_code, date)
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "sssssss", $teacherId, $column1Value, $column2Value, $column3Value, $column4Value, $column5Value, $currentDate);
                mysqli_stmt_execute($stmt);
  
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    session_start();
                    $_SESSION['status'] = "Student added successfully.";
                    header("Location: teacher.php?EMP=$teacherId");
                    exit();
                } else {
                    session_start();
                    $_SESSION['status1'] = "Adding student error.";
                    header("Location: teacher.php?EMP=$teacherId");
                    exit();
                }
    } else {
        session_start();
        $_SESSION['status1'] = "Student or Subject doesn't exist.";
        header("Location: teacher.php?EMP=$teacherId");
        exit();
    }
  } else if (empty($_POST['fullname']) && !empty($_POST['subjectcode'])) {
    $fullname_err = "<div class='alert alert-danger mt-2'><strong>Please enter student name.<strong></div>";
  } else if (!empty($_POST['fullname']) && empty($_POST['subjectcode'])) {
    $subjcode_err = "<div class='alert alert-danger mt-2'><strong>Please enter a subject code.</strong></div>";
  } else if (empty($_POST['fullname']) && empty($_POST['subjectcode'])) {
    $both_err = "<div class='alert alert-danger mt-2'><strong>Missing fields!</strong></div>";
  }
}*/
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
      
      <title>Student</title>
  </head>

  <body>
    <?php
      $studentNumber = mysqli_real_escape_string($conn, $_GET['student_number']);
    ?>
      <div class="header">
          <div class="header-container container-fluid p-3">
              <div class="d-flex align-items-center mb-3">
                <a href="student.php?student_number=<?php echo $studentNumber; ?>">
                  <img src="logo.svg" alt="Logo" width="85">
                </a>
                  <h1 class="title" style="font-size: 37px; margin-bottom: 0px;">STUDENT ATTENDANCE MANAGEMENT SYSTEM</h1>
                  <a id="logout" href="logout.php" class="ms-auto me-0">Logout</a>
              </div>
          </div>
      </div>

      <div class="container">
        <?php
          if(isset($_GET['student_number'])) {
          $studentNumber = mysqli_real_escape_string($conn, $_GET['student_number']);
          $query = "SELECT * FROM students WHERE student_number='$studentNumber'";
          $query_run = mysqli_query($conn, $query);

            if(mysqli_num_rows($query_run) > 0) {
              $student = mysqli_fetch_array($query_run);
              ?>
              <?php echo $status3; ?>
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <img src="user.svg">
                    <h1 class="teachername mb-0" style="font-size: 50px; margin-top: 0px; margin-bottom: 0px; margin-left: 10px;"><strong><!--<?php echo $student['full_name'];?>-->STUDENT PROFILE</strong>
                    </h1> 
                    <a class="btn text-white ms-auto me-0 w-17" href="change_password_student.php?student_number=<?= $studentNumber; ?>" id="chgpass" style="font-size: 12px;">Change Password</a>
                  </div>
                </div>

                <div class="card-body">
                  <div class="p-container">
                    <div class="line1">
                      <p>Full name: <strong><?php echo $student['full_name'];?></strong></p>
                      <p>Gender: <strong><?php echo $student['gender'];?></strong></p>
                      <p>Date of Birth: <strong><?php echo $student['birthdate'];?></strong></p>
                      <p>City: <strong><?php echo $student['city'];?></strong></p>
                    </div>
                    <div class="line2">
                      <p>Student Number: <strong><?php echo $student['student_number'];?></strong></p>
                      <p>Year: <strong><?php echo $student['year'];?></strong></p>
                      <p>Course: <strong><?php echo $student['course'];?></strong></p>
                      <p>Contact Number: <strong><?php echo $student['contact'];?></strong></p>
                      <p>E-mail: <strong><?php echo $student['email'];?></strong></p>
                    </div>
                  </div>
                </div>

              </div>
              <?php
            }  
          }
        ?>
      </div> 
      
      <!--<div class="container mt-3">
          <div class="col-auto">
            <?php echo $status1; ?>
            <?php echo $status; ?>
            <?php echo $both_err; ?>
            <?php echo $fullname_err; ?>
            <?php echo $subjcode_err; ?>
            <h1 style="color: #004500; margin-right: 20px;">Select a Student:</h1>
          </div>
          <div class="col">
            <?php
              if(isset($_GET['EMP'])) {
              $teacher_id = mysqli_real_escape_string($conn, $_GET['EMP']);
              $query = "SELECT * FROM teachers WHERE EMP='$teacher_id'";
              $query_run = mysqli_query($conn, $query);

              if(mysqli_num_rows($query_run) > 0) {
                $teacher = mysqli_fetch_array($query_run);
                ?>
                <form id="teacher-form" method="POST" action="teacher.php?EMP=<?php echo $teacher_id; ?>">
                <input type="hidden" name="teacher_id" value="<?= $teacher_id?>">
                    <div class="row">
                      <div class="col">
                        <div>
                          <label for="fullname" class="form-label">Student Name:</label
                          <input type="text" class="form-control" id="fullname" placeholder="Enter student full name" name="fullname" autocomplete="off">
                        </div>
                      </div>
                      <div class="col">
                        <div>
                          <label for="subjectcode" class="form-label">Subject Code:</label>
                          <input type="text" class="form-control" id="subjectcode" placeholder="Enter subject code" name="subjectcode" autocomplete="off">
                        </div>
                      </div>
                    </div>
                    <div class="d-flex gap-2 mt-4 mb-2">
                      <button type="submit" name="submit_student" id="teachersbmt" class="btn text-white" style="background-color: #004500;">Submit</button>
                      <a class="btn text-white" href="teacher.php?EMP=<?php echo $teacher_id; ?>" role="button" id="cancel" style="background-color: #004500;">Cancel</a>
                    </div>
                </form>
              <?php
                } else {
                  echo "No such teacher found!.";
                }
            }
            ?>
          </div>
      </div>-->

      <div class="container mt-3">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <h1 class="text-white mb-0">Attendance Record</h1>
              <div class="d-flex align-items-center">
                <input type="text" id="search-input" class="form-control me-2" placeholder="Search">
                <button class="btn btn-sm text-white mt-2 mb-2 me-0" id="search-button" style="background-color: #004500;">
                  <img src="search.svg">
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <table id="attendance-table" class="table table-hover table-striped">
            <thead class="table-success">
              <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Year</th>
                <th>Course</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Status</th>
                <!--<th>Action</th>-->
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php

                  $studentNumber = mysqli_real_escape_string($conn, $_GET['student_number']);
                  $query = "SELECT * FROM attendance WHERE student_number='$studentNumber' ORDER BY date DESC";
                  $query_run = mysqli_query($conn, $query);

                  if(mysqli_num_rows($query_run) > 0) {
                    foreach($query_run as $student) {
                      ?>
                        <tr id="attendance-row-<?= $student['attendance_id'] ?>" data-attendance-id="<?= $student['attendance_id'] ?>">
                            <td><?= $student['student_number']; ?></td>
                            <td><?= $student['full_name']; ?></td>
                            <td><?= $student['year']; ?></td>
                            <td><?= $student['course']; ?></td>
                            <td><?= $student['subj_code']; ?></td>
                            <td><?= $student['date']; ?></td>
                            <td class="status-cloumn">
                              <?php if ($student['status'] === 'present') { ?>
                                <img src="present.svg" alt="Present">
                              <?php } elseif ($student['status'] === 'absent') { ?>
                                <img src="absent.svg" alt="Absent">
                              <?php } else { ?>
                                <span class="status-icon"></span>
                                  <img src="no-attendance.svg" alt="Status">
                              <?php } ?>
                            </td>
                            <!--<td>
                                <a href="attendance-edit.php?attendance_id=<?= $student['attendance_id']; ?>&teacher_id=<?= $student['teacher_id']; ?>" class="btn btn-sm">
                                    <img src="user-edit.svg">
                                </a>
                                <form action="#" method="POST" class="d-inline">
                                    <button type="submit" name="delete_teacher" value="#" class="btn btn-sm delete-row-btn">
                                        <img src="user-remove.svg">
                                    </button>
                                </form>
                            </td>-->
                        </tr>
                        <?php
                    }
                } else {
                  ?>
                  <tr>
                      <td colspan="8" style="text-align: center;">No attendance record found.</td>
                  </tr>
                  <?php
                }
                ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- script -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script>
        /* Function to handle button clicks
        function handleButtonClick(attendanceId, status) {
          // Create a new XMLHttpRequest object
          var xhr = new XMLHttpRequest();
        
          // Prepare the request
          xhr.open("POST", "update_attendance.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
          // Define the data to be sent to the server
          var data = "attendance_id=" + encodeURIComponent(attendanceId) + "&status=" + encodeURIComponent(status);
        
          // Send the request
          xhr.send(data);
        
          // Handle the response from the server
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Response received, update the status column
              var statusColumn = document.querySelector("#attendance-row-" + attendanceId + " .status-icon");
              if (status === "present") {
                statusColumn.innerHTML = '<img src="present.svg" alt="Present">';
              } else if (status === "absent") {
                statusColumn.innerHTML = '<img src="absent.svg" alt="Absent">';
              }

              Remove the buttons
              var presentButton = document.querySelector("#attendance-row-" + attendanceId + " .present-btn");
              var absentButton = document.querySelector("#attendance-row-" + attendanceId + " .absent-btn");
              presentButton.remove();
              absentButton.remove();

              Remove the row from the table
              var attendanceRow = document.querySelector("#attendance-row-" + attendanceId);
              attendanceRow.remove();
            }
          };
        }
        
        // Add event listeners to the present and absent buttons
        var presentButtons = document.getElementsByClassName("present-btn");
        for (var i = 0; i < presentButtons.length; i++) {
          presentButtons[i].addEventListener("click", function(e) {
            e.preventDefault();
            var attendanceId = this.closest("tr").getAttribute("data-attendance-id");
            handleButtonClick(attendanceId, "present");
          });
        }
        
        var absentButtons = document.getElementsByClassName("absent-btn");
        for (var i = 0; i < absentButtons.length; i++) {
          absentButtons[i].addEventListener("click", function(e) {
            e.preventDefault();
            var attendanceId = this.closest("tr").getAttribute("data-attendance-id");
            handleButtonClick(attendanceId, "absent");
          });
        }*/

        // Function to handle search button click
        function fetchSearchResults() {
          // Get the search input value
          var searchInput = document.getElementById("search-input").value;

          // Get the EMP parameter value
          var empParameter = "<?php echo $_GET['student_number']; ?>";

          // Create a new XMLHttpRequest object
          var xhr = new XMLHttpRequest();

          // Prepare the request
          xhr.open("GET", "search_attendance_student.php?search=" + encodeURIComponent(searchInput) + "&student_number=" + encodeURIComponent(empParameter), true);

          // Send the request
          xhr.send();

          // Handle the response from the server
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              // Response received, update the table with search results
              var table = document.getElementById("attendance-table");
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