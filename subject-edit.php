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
    if(isset($_POST['subject_edit'])) {
        $subject_id = mysqli_real_escape_string($conn, $_POST['subject_id']);
        $selectedCourse = mysqli_real_escape_string($conn, $_POST['dropdown']);
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $subjectCode = mysqli_real_escape_string($conn, $_POST['code']);

        $query = "UPDATE subjects SET course='$selectedCourse', subj_name='$subject', subj_code='$subjectCode'
                WHERE subj_id='$subject_id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            session_start();
            $_SESSION['status'] = "Subject updated successfully.";
            header("Location: admin-course&subj.php");
            exit();
        } else {
            session_start();
            $_SESSION['status1'] = "Subject update unsuccessful.";
            header("Location: admin-course&subj.php");
            exit();
        }
    } /*else {
        $notfound_err = "<div class='alert alert-danger mt-2'><strong>Incorrect password.</strong></div>";
    }*/
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
      
      <title>Teacher Edit</title>
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
                            <h1>EDIT SUBJECT:</h1>
                            <?php echo $notfound_err; ?>
                    </div>
                    <?php
                        if(isset($_GET['subj_id'])) {
                            $subject_id = mysqli_real_escape_string($conn, $_GET['subj_id']);
                            $query = "SELECT * FROM subjects WHERE subj_id='$subject_id'";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0) {
                                $subject = mysqli_fetch_array($query_run);
                                ?>
                                    <form action="subject-edit.php" method="POST">
                                        <input type="hidden" name="subject_id" value="<?= $subject_id?>">

                                        <div class="dropdown d-grid dropdown-menu-end">
                                            <label for="dropdown" class="form-label mt-3"><h1 style="color: #fff;">COURSE:</h1></label>
                                            <button type="button" class="btn dropdown-toggle text-white" data-bs-toggle="dropdown" id="dropdown" style="background-color: #004500;">
                                                <?php echo $subject['course']; ?>
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
                                            <label for="subject" class="form-label mt-3"><h1 style="color: #fff;">Subject Name:</h1></label>
                                            <input type="text" class="form-control" id="subject" placeholder="Enter subject name" value="<?=$subject['subj_name'];?>" name="subject" autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Subject Code:</label>
                                            <input type="text" class="form-control" id="code" placeholder="Enter subject code" value="<?=$subject['subj_code'];?>" name="code" autocomplete="off">
                                        </div>

                                            <div class="d-flex justify-content-center gap-2 mt-4 mb-2">
                                            <button type="submit" name="subject_edit" id="teachersbmt" class="btn">Update</button>
                                            <a class="btn text-white" href="admin-course&subj.php" role="button" id="cancel">Cancel</a>
                                            </div>
                                    </form>
                                <?php
                            } else {
                                echo "No such subject found!.";
                            }
                        }
                    ?>
                      
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

    </script>
    </body>
  </html>