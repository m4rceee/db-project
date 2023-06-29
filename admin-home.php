<?php
include("db_conn.php");

// Query to fetch teacher count
$teacherCountQuery = "SELECT COUNT(*) AS count FROM teachers";
$teacherCountResult = mysqli_query($conn, $teacherCountQuery);
$teacherCountRow = mysqli_fetch_assoc($teacherCountResult);
$teacherCount = $teacherCountRow['count'];

// Query to fetch student count
$studentCountQuery = "SELECT COUNT(*) AS count FROM students";
$studentCountResult = mysqli_query($conn, $studentCountQuery);
$studentCountRow = mysqli_fetch_assoc($studentCountResult);
$studentCount = $studentCountRow['count'];

// Query to fetch course count
$courseCountQuery = "SELECT COUNT(*) AS count FROM subjects";
$courseCountResult = mysqli_query($conn, $courseCountQuery);
$courseCountRow = mysqli_fetch_assoc($courseCountResult);
$courseCount = $courseCountRow['count'];

// Query to fetch attendance count
$attendanceCountQuery = "SELECT COUNT(*) AS count FROM attendance WHERE status IN ('present', 'absent') ";
$attendanceCountResult = mysqli_query($conn, $attendanceCountQuery);
$attendanceCountRow = mysqli_fetch_assoc($attendanceCountResult);
$attendanceCount = $attendanceCountRow['count'];

?>

<!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
      <link rel="stylesheet" href="admin-home-style.css">

      <!-- fonts -->
      <style>
          @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
          @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

          #calendar {
            max-width: 1200px;
            margin: 0 auto;
          }

          #clock {
            font-size: 24px;
            text-align: center;
            margin-top: 20px;
          }
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
                    <a class="nav-link" href="admin-home.php" id="nav-item0">Dashboard</a>
                </li>
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

                <div class="row mt-3">

                  <div class="col-md-3">
                    <div class="info-box teacher">
                      <span>
                        <img src="teacher.svg" class="img">
                      </span>
                      <h2 class="label">Teacher</h2>
                      <p class="label1"><strong style="font-size: 20px;"><?php echo $teacherCount; ?></strong> registered teachers</p>
                      
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="info-box student">
                      <span">
                        <img src="student.svg" class="img">
                      </span>
                      <h2 class="label">Student</h2>
                      <p class="label1"><strong style="font-size: 20px;"><?php echo $studentCount; ?></strong> registered students</p>
                      
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="info-box course">
                      <span>
                        <img src="subject.svg" class="img">
                      </span>
                      <h2 class="label">Subject</h2>
                      <p class="label1"><strong style="font-size: 20px;"><?php echo $courseCount; ?></strong> registered subjects</p>
                      
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="info-box course">
                      <span>
                        <img src="attendance.svg" class="img">
                      </span>
                      <h2 class="label">Attendance</h2>
                      <p class="label1"><strong style="font-size: 20px;"><?php echo $attendanceCount; ?></strong> recorded attendances</p>
                      
                    </div>
                  </div>

                </div>

                <div class="row mt-1">

                  <div class="col-md-12">
                    <div class="text-white mb-3" id="clock" style="font-weight: bold; font-size: 50px; background-color: #004500; border-radius: 5px;"></div>
                  </div>

                  <div class="col-md-7">
                    <div id="calendar"></div>
                  </div>

                  <div class="col-md-5">
                  <div class="card">
          <div class="attendanceRecord card-header">
            <div class="d-flex justify-content-between align-items-center">
              <h1 class="mb-0">N-Y-R</h1>
              <div class="d-flex align-items-center">
                <input type="text" id="search-input" class="form-control me-2" placeholder="Search" style="width: 150px;">
                <button class="btn btn-sm text-white mt-2 mb-2 me-0" id="search-button" style="background-color: #018100;">
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
                <th>Teacher ID</th>
                  <th>Name</th>
                  <th>Subject</th>
                  <th>Date</th>
                  <th>Status</th>
              </tr>
          </thead>
          <tbody>
              <?php
              include("db_conn.php");
              $query = "SELECT * FROM attendance WHERE status = 'not yet recorded' ORDER BY date DESC";
              $query_run = mysqli_query($conn, $query);

              if (mysqli_num_rows($query_run) > 0) {
                  foreach ($query_run as $student) {
                      ?>
                      <tr id="attendance-row-<?= $student['attendance_id'] ?>" data-attendance-id="<?= $student['attendance_id'] ?>">
                        <td><?= $student['teacher_id']; ?></td>
                          <td><?= $student['full_name']; ?></td>
                          <td><?= $student['subj_code']; ?></td>
                          <td><?= $student['date']; ?></td>
                          <td class="status-column">
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
                  ?>
                  <tr>
                      <td colspan="8" style="text-align: center;">No student attendance record found.</td>
                  </tr>
                  <?php
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
                
              </div>
        </div>
    </div>

  

      <!-- script -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script>

        // When the document is ready
        $(document).ready(function() {
          // Initialize the FullCalendar
          $('#calendar').fullCalendar({
            // Configure options and callbacks as per your requirement
            // For example, you can set the header, default view, events source, etc.
            header: {
              left: 'prev,next today',
              center: 'title',
              right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'month',
            events: [
              {
                title: 'Defense Day',
                start: '2023-06-30',
                color: '#018100',
                backgroundColor: '#018100',
              },
            ]
          });

          // Call the function to start the clock
          startTime();
        });

        // Function to display the real-time clock
        function startTime() {
          const today = new Date();
          let h = today.getHours();
          let m = today.getMinutes();
          let s = today.getSeconds();
          m = checkTime(m);
          s = checkTime(s);
          document.getElementById('clock').innerHTML = h + ":" + m + ":" + s;
          setTimeout(startTime, 1000);
        }

        // Function to add leading zeros to numbers less than 10
        function checkTime(i) {
          if (i < 10) {
            i = "0" + i;
          }
          return i;
        }

        // Call the startTime function when the document is ready
        document.addEventListener("DOMContentLoaded", function() {
          startTime();
        });
        
        function fetchSearchResults() {
        // Get the search input value
        var searchInput = document.getElementById("search-input").value;

        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Prepare the request
        xhr.open("GET", "search_attendance_admin1.php?search=" + encodeURIComponent(searchInput), true);

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