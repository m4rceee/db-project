<?php
include("db_conn.php");


session_start();
date_default_timezone_set('Asia/Manila');

$status1 = $status = $emptyField = "";

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 

if (isset($_SESSION['status1'])) {
  $status1 = "<div class='alert alert-danger alert-dismissible fade show mt-2'><strong>{$_SESSION['status1']}</strong></div>";
  unset($_SESSION['status1']);
} 

//$con = mysqli_connect("localhost", "root", "", "courses_subj_db");

if(!$conn) {
  die("Connection Failed: ". mysqli_connect_error());
}

if(isset($_POST['save_course_subj'])) {

  $fieldsToValidate = array('dropdown', 'subject', 'code');
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
    $selectedCourse = $_POST['dropdown'];
    $subject = $_POST['subject'];
    $subjectCode = $_POST['code'];
    $currentDate = date('Y-m-d'); // get current date

    $query = "SELECT * FROM subjects WHERE subj_name = ? AND subj_code = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $subject, $subjectCode);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        session_start();
        $_SESSION['status1'] = "Subject already exists.";
        header("Location: admin-course&subj.php");
        exit();
    } else {
        $query = "INSERT INTO subjects (course, subj_name, subj_code, date_added) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $selectedCourse, $subject, $subjectCode, $currentDate);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            session_start();
            $_SESSION['status'] = "Subject created successfully.";
            header("Location: admin-course&subj.php");
            exit();
        } else {
            session_start();
            $_SESSION['status1'] = "Subject creation unsuccessful.";
            header("Location: admin-course&subj.php");
            exit();
        }
    }
    mysqli_stmt_close($stmt);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="admin-course&subj.css">

    <!-- fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    
    <title>Admin Courses and Subject</title>
</head>

<body>
    <div class="header">
        <div class="headercontainer container-fluid p-3">
            <div class="d-flex align-items-center mb-3">
                <img src="logo.svg" alt="Logo" width="85">
                <h1 class="title" style="font-size: 37px; margin-bottom: 0px;">STUDENT ATTENDANCE MANAGEMENT SYSTEM</h1>
              </div>
        </div>

        <div class="container-fluid mt-3 mb-3">
          <div class="card">
            <div class="card-header">
              <div class="d-flex justify-content-between align-items-center">
                <h1 class="headertext text-white mb-0">Hello, Admin!</h1>
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
                      <?php echo $status1; ?>
                      <?php echo $status; ?>
                      <?php echo $emptyField; ?>
                      <h1 style="color: #fff">SELECT COURSE:</h1>
                    </div>
                    <form action="admin-course&subj.php" method="POST">
                        <div class="dropdown d-grid dropdown-menu-end">
                            <button type="button" class="btn dropdown-toggle text-white" data-bs-toggle="dropdown" id="dropdown">
                              Courses
                            </button>
                            <input type="hidden" id="selectedCourse" name="dropdown" value="">
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <li><a class="dropdown-item" href="#" onclick="updateDropdownButton('Bachelor of Elementary Education')">Bachelor of Elementary Education</a></li>
                              <li><a class="dropdown-item" href="#" onclick="updateDropdownButton('Bachelor of Secondary Education')">Bachelor of Secondary Education</a></li>
                              <li><a class="dropdown-item" href="#" onclick="updateDropdownButton('BS Business Management')">BS Business Management</a></li>
                              <li><a class="dropdown-item" href="#" onclick="updateDropdownButton('BS Computer Science')">BS Computer Science</a></li>
                              <li><a class="dropdown-item" href="#" onclick="updateDropdownButton('BS Hospitality Management')">BS Hospitality Management</a></li>
                              <li><a class="dropdown-item" href="#" onclick="updateDropdownButton('BS Information Technology')">BS Information Technology</a></li>
                              <li><a class="dropdown-item" href="#" onclick="updateDropdownButton('BS Psychology')">BS Psychology</a></li>
                              <li><a class="dropdown-item" href="#" onclick="updateDropdownButton('BS Tourism Management')">BS Tourism Management</a></li>
                            </ul>
                        </div>

                          <div class="mb-3">
                            <label for="subject" class="form-label mt-3"><h1 style="color: #fff;">ADD SUBJECT:</h1></label>
                            <input type="text" class="form-control" id="subject" placeholder="Enter subject name" name="subject" autocomplete="off">
                          </div>
                          <div class="mb-3">
                            <label for="code" class="form-label">Subject Code:</label>
                            <input type="text" class="form-control" id="code" placeholder="Enter subject code" name="code" autocomplete="off">
                          </div>

                          <div class="d-flex justify-content-center gap-2 mt-4 mb-2">
                            <button type="submit" name="save_course_subj" id="studentsbmt" class="btn">Add</button>
                            <a class="btn text-white" href="admin-course&subj.php" role="button" id="cancel">Cancel</a>
                          </div>
                          
                    </form>
        
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="card mt-3" id="course-subjcard">
                <div class="card-body">
                    <div class="card-title">
                      <div class="d-flex justify-content-between align-items-center">
                            <h1 class="mb-0" style="color: #004500;">COURSES & SUBJECTS: </h1>
                            <div class="d-flex align-items-center">
                              <input type="text" id="search-input" class="form-control me-2" placeholder="Search">
                              <button class="btn btn-sm text-white mt-2 mb-2 me-0" id="search-button" style="background-color: #004500;">
                                <img src="search.svg">
                              </button>
                            </div>
                      </div>
                    <table id="subject-table" class="table table-borderless table-striped table-hover">
                        <thead class="table-success">
                          <tr>
                            <th>ID</th>
                            <th>Course</th>
                            <th>Subject Name</th>
                            <th>Subject Code</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $query = "SELECT * FROM subjects";
                          $query_run = mysqli_query($conn, $query);

                          if(mysqli_num_rows($query_run) > 0) {
                            foreach($query_run as $courses_subj) {
                              ?>
                                <tr>
                                  <td><?= $courses_subj['subj_id']; ?></td>
                                  <td><?= $courses_subj['course']; ?></td>
                                  <td><?= $courses_subj['subj_name']; ?></td>
                                  <td><?= $courses_subj['subj_code']; ?></td>
                                  <td>
                                    <a href="subject-edit.php?subj_id=<?= $courses_subj['subj_id']; ?>" class="btn btn-sm">
                                    <img src="user-edit.svg">
                                    </a>
                                    <form action="subject-delete.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this subject and/or course?');">
                                        <button type="submit" name="delete_course_subj" value="<?= $courses_subj['subj_id']; ?>" class="btn btn-sm">
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
        
        

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        function updateDropdownButton(selectedCourse) {
          document.getElementById("dropdown").textContent = selectedCourse;
          document.getElementById("selectedCourse").value = selectedCourse;
        }

        // Function to handle search button click
        function fetchSearchResults() {
            // Get the search input value
            var searchInput = document.getElementById("search-input").value;

            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Prepare the request
            xhr.open("GET", "search_subject.php?search=" + encodeURIComponent(searchInput), true);

            // Send the request
            xhr.send();

            // Handle the response from the server
            xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Response received, update the table with search results
                var table = document.getElementById("subject-table");
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
