<?php
include("db_conn.php");

session_start();

if (isset($_SESSION['status'])) {
    $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
    unset($_SESSION['status']);
} 
if (isset($_SESSION['status'])) {
  $status = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status']}</strong></div>";
  unset($_SESSION['status']);
} 

$notfound_err = $status = "";

    // UPDATE RECORD
    if(isset($_POST['update_attendance'])) {
        $attendanceId = mysqli_real_escape_string($conn, $_POST['attendance_id']);
        $teacherId = mysqli_real_escape_string($conn, $_POST['teacher_id']);
        $studentNumber = mysqli_real_escape_string($conn, $_POST['student_number']);
        $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
        $year = mysqli_real_escape_string($conn, $_POST['year']);
        $subjectCode = mysqli_real_escape_string($conn, $_POST['subj_code']);
        $course = mysqli_real_escape_string($conn, $_POST['course']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $query = "UPDATE attendance SET status ='$status' WHERE attendance_id ='$attendanceId'";
        $query_run = mysqli_query($conn, $query);
        if($query_run) {
            session_start();
            $_SESSION['status'] = "Record updated successfully.";
            header("Location: teacher.php?EMP=$teacherId");
            exit();
        } else {
            session_start();
            $_SESSION['status'] = "Record update unsuccessful.";
            header("Location: teacher.php?EMP=$teacherId");
            exit();
        }
    }
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
        /* Add custom styles for active button */
        .btn-group .btn.active {
            background-color: #004500; /* Set your desired background color */
        }
      </style>
      
      <title>Attendance Record Edit</title>
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
                            <h1>EDIT RECORD STATUS:</h1>
                            <?php echo $notfound_err; ?>
                    </div>
                    <?php
                        if(isset($_GET['attendance_id'])) {
                            $attendance_id = mysqli_real_escape_string($conn, $_GET['attendance_id']);
                            $teacher_id = mysqli_real_escape_string($conn, $_GET['teacher_id']);
                            $query = "SELECT * FROM attendance WHERE attendance_id='$attendance_id'";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0) {
                                $attendance = mysqli_fetch_array($query_run);
                                ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                        <input type="hidden" name="attendance_id" value="<?= $attendance_id?>">
                                        <input type="hidden" name="teacher_id" value="<?= $teacher_id?>">  
                                        <input type="hidden" id="selected_status" name="status" value="<?=$attendance['status'];?>">
                                        
                                        <div class="mb-3 mt-3">
                                            <p class="text-white"><strong>Student Number: </strong><?=$attendance['student_number'];?></p>
                                            <p></p> 
                                        </div>
                                        
                                        <div class="mb-3 mt-3">
                                            <p class="text-white"><strong>Full Name: </strong><?=$attendance['full_name'];?></p>
                                            <p></p> 
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <p class="text-white"><strong>Year: </strong><?=$attendance['year'];?></p>
                                            <p></p> 
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <p class="text-white"><strong>Course: </strong><?=$attendance['course'];?></p>
                                            <p></p> 
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <p class="text-white"><strong>Subject: </strong><?=$attendance['subj_code'];?></p>
                                            <p></p> 
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label class="form-label"><strong>Status:</strong></label>
                                            <div id="status-buttons" class="btn-group" role="group">
                                                <button type="button" class="btn<?=$attendance['status'] === 'present' ? ' active' : ''?>" name="status" value="present">
                                                    <a href="#">
                                                        <img src="present.svg">
                                                    </a>
                                                </button>
                                                <button type="button" class="btn<?=$attendance['status'] === 'absent' ? ' active' : ''?>" name="status" value="absent">
                                                    <a href="#">
                                                        <img src="absent.svg">
                                                    </a>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center gap-2 mt-4 mb-2">
                                            <button type="submit" name="update_attendance" id="teachersbmt" class="btn">Update</button>
                                            <a class="btn text-white" href="teacher.php?EMP=<?php echo $teacher_id; ?>" role="button" id="cancel">Cancel</a>
                                        </div>
                                    </form>
                                <?php
                            } else {
                                echo "No such record found!.";
                            }
                        }
                    ?>
                      
                  </div>
              </div>
          </div>

                <!-- script -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script>
        // Add event listeners to buttons when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('#status-buttons button');
            buttons.forEach(button => {
                button.addEventListener('click', handleButtonClick);
            });
        });

        function handleButtonClick(event) {
            const clickedButton = event.target.closest('button');
            const status = clickedButton.value;

            // Remove 'active' class from all buttons except the clicked button
            const buttons = document.querySelectorAll('#status-buttons button');
            buttons.forEach(button => {
                if (button !== clickedButton) {
                    button.classList.remove('active');
                }
            });

            // Add 'active' class to the clicked button
            clickedButton.classList.add('active');

            // Update the value of the hidden input field
            const selectedStatusInput = document.getElementById('selected_status');
            selectedStatusInput.value = status;
        }
    </script>
    </body>
  </html>