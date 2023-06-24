<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="admin-attendance-style.css">

    <!-- fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
    </style>
    
    <title>Admin-Attendance</title>
</head>

<body>
    <div class="header">
        <div class= "container-fluid p-3" id="header">
            <div class="d-flex align-items-center mb-3">
                <img src="logo.svg" alt="Logo" width="85">
                <h1 class="title" style="font-size: 37px; margin-bottom: 0px;">STUDENT ATTENDANCE MANAGEMENT SYSTEM</h1>
              </div>
        </div>
        <div class="container-fluid mt-3 mb-3">
            <div class="card">
                <div class="adminheader card-header">
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
                    <div class="container-fluid mt-3">
        <div class="card">
          <div class="attendanceRecord card-header">
            <div class="d-flex justify-content-between align-items-center">
              <h1 class="mb-0">ATTENDANCE RECORDS</h1>
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
                <th>Year & Section</th>
                <th>Course</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php

                  //$teacher_id = mysqli_real_escape_string($conn, $_GET['EMP']);
                  include("db_conn.php");
                  $query = "SELECT * FROM attendance ORDER BY date DESC";
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
                        </tr>
                        <?php
                    }
                } else {
                    echo "No student record found.";
                }
                ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
                </div>
            </div>
        </div>
    </div>

    


    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
    // Function to handle search button click
    function fetchSearchResults() {
        // Get the search input value
        var searchInput = document.getElementById("search-input").value;

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Prepare the request
        xhr.open("GET", "search_attendance_admin.php?search=" + encodeURIComponent(searchInput), true);

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