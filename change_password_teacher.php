<?php
include("db_conn.php");
$teacher_id = $_GET['EMP'];

session_start();

 "";

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

if (isset($_SESSION['status3'])) {
    $status3 = "<div class='alert alert-warning alert-dismissible fade show mt-2'><strong>{$_SESSION['status3']}</strong></div>";
    unset($_SESSION['status3']);
} 

$status2 = $status1 = $status = $emptyFields =  $incorrectPass = $status3 = $notMatch = "";

    //UPDATE RECORD
    if(isset($_POST['update_teacher_password'])) {

        $fieldsToValidate = array('current_password', 'new_password', 'confirm_password',);
        $allFieldsNotEmpty = true;

        // VALIDATION FOR EMPTY FIELDS
        foreach ($fieldsToValidate as $field) {
            if (empty($_POST[$field])) {
                $allFieldsNotEmpty = false;
                $emptyFields = "<div class='alert alert-danger mt-2'><strong>Missing field/s.</strong></div>";
                break;
            }
        }
    
    if ($allFieldsNotEmpty) {

        $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
        $currentPassword = mysqli_real_escape_string($conn, $_POST['current_password']);
        $newPassword = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);

        if ($newPassword !== $confirmPassword) {
            $notMatch = "<div class='alert alert-danger mt-2'><strong>Passwords do not match.</strong></div>";
            /*header("Location: change_password_teacher.php?EMP=" . $teacher_id);
            exit();*/

        } else {
            $query = "SELECT password from teachers WHERE EMP = '$teacher_id'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            
            if (!password_verify($currentPassword, $row['password'])) {
                $incorrectPass = "<div class='alert alert-danger mt-2'><strong>Current password is incorrect.</strong></div>";
            }
            
                // Update the password in the database
                $update_query = "UPDATE teachers SET password = '$newPassword' WHERE EMP = '$teacher_id'";
                if (mysqli_query($conn, $update_query)) {
                    session_start();
                    $_SESSION['status3'] = "Password Updated Successfully!";
                    header("Location: teacher.php?EMP=$teacher_id");
                    exit();
                } else {
                    $_SESSION['status3'] = "Password Update Unuccessfully!";
                    header("Location: teacher.php?EMP=$teacher_id");
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
      <link rel="stylesheet" href="teacher-edit.css">

      <!-- fonts -->
      <style>
          @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
          @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
      </style>
      
      <title>Change Password</title>
  </head>

  <body>
    <?php
      $teacherId = mysqli_real_escape_string($conn, $_GET['EMP']);
    ?>
      <div class="header">
        <div class="container-fluid p-3">
                <div class="d-flex align-items-center mb-3">
                <a href="teacher.php?EMP=<?php echo $teacherId; ?>">
                  <img src="logo.svg" alt="Logo" width="85">
                </a>
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
                            <h1>CHANGE PASSWORD:</h1>
                            <?php echo $emptyFields; ?>
                    </div>
                    <?php
                        if(isset($_GET['EMP'])) {
                            $teacher_id = mysqli_real_escape_string($conn, $_GET['EMP']);
                            $query = "SELECT * FROM teachers WHERE EMP='$teacher_id'";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0) {
                                $teacher = mysqli_fetch_array($query_run);
                                ?>
                                    <form action="change_password_teacher.php?EMP=<?php echo $teacher_id; ?>" method="POST">
                                        <input type="hidden" name="teacher_id" value="<?= $teacher_id?>">

                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Current Password:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="current_password" placeholder="Enter current password" name="current_password" autocomplete="off">
                                                <div class="input-group-text">
                                                    <button class="btn toggle-password" type="button" data-target="current_password">
                                                        <img src="eye-slash.svg">
                                                    </button>
                                                </div>
                                            </div>
                                            <?php echo $incorrectPass; ?>
                                        </div>

                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">New Password:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="new_password" placeholder="Enter new password" name="new_password" autocomplete="off">
                                                <div class="input-group-text">
                                                    <button class="btn toggle-password" type="button" data-target="new_password">
                                                        <img src="eye-slash.svg">
                                                    </button>
                                                </div>
                                            </div>
                                            <?php echo $notMatch; ?>
                                        </div>

                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm Password:</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="confirm_password" placeholder="Re-enter New Password" name="confirm_password" autocomplete="off">
                                                <div class="input-group-text">
                                                    <button class="btn toggle-password" type="button" data-target="confirm_password">
                                                        <img src="eye-slash.svg">
                                                    </button>
                                                </div>
                                            </div>
                                            <?php echo $notMatch; ?>
                                        </div>


                                            <div class="d-flex justify-content-center gap-2 mt-4 mb-2">
                                            <button type="submit" name="update_teacher_password" id="teachersbmt" class="btn">Update</button>
                                            <a class="btn text-white" href="teacher.php?EMP=<?php echo $teacher_id; ?>" role="button" id="cancel">Cancel</a>
                                            </div>
                                    </form>
                                <?php
                            } else {
                                echo "No such teacher found!.";
                            }
                        }
                    ?>
                      
                  </div>
              </div>
          </div>

                <!-- script -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
      <script>
        const toggleButtons = document.querySelectorAll('.toggle-password');

        toggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                const icon = button.querySelector('img');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.src = 'eye.svg';
                } else {
                    passwordInput.type = 'password';
                    icon.src = 'eye-slash.svg';
                }
            });
        });

    </script>
    </body>
  </html>