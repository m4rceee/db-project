<?php

$con = mysqli_connect("localhost", "root", "", "teachers_db");

    if(!$con) {
      die("Connection Failed: ". mysqli_connect_error());
    }

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
      
      <title>Admin-Teacher</title>
  </head>

  <body>
      <div class="header">
          <div class="header-container container-fluid p-3">
              <div class="d-flex align-items-center mb-3">
                  <img src="logo.svg" alt="Logo" width="85">
                  <h1 class="title" style="font-size: 37px;">STUDENT ATTENDANCE MANAGEMENT SYSTEM</h1>
                  <a id="logout" href="logout.php">Logout</a>
                </div>
              
          </div>
      </div>

      <div class="container-fluid">
        <?php
          if(isset($_GET['EMP'])) {
          $teacher_id = mysqli_real_escape_string($con, $_GET['EMP']);
          $query = "SELECT * FROM teachers WHERE EMP='$teacher_id'";
          $query_run = mysqli_query($con, $query);

            if(mysqli_num_rows($query_run) > 0) {
              $teacher = mysqli_fetch_array($query_run);
              ?>
              <h1 class="teachername"><?php echo $teacher['full_name'];?></h1>
              <h5 class="deptname">Department: <?php echo $teacher['department'];?></h5>
              <?php
            }  
          }
        ?>
      </div>
      
      <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-sm-4">
                <div class="card mt-3" id="infocard">
                    <div class="card-body">
                      <div class="card-title">
                        <h3 style="color: #fff;">Other Details:</h3>
                      </div>
                        <?php
                          if(isset($_GET['EMP'])) {
                              $teacher_id = mysqli_real_escape_string($con, $_GET['EMP']);
                              $query = "SELECT * FROM teachers WHERE EMP='$teacher_id'";
                              $query_run = mysqli_query($con, $query);

                              if(mysqli_num_rows($query_run) > 0) {
                                  $teacher = mysqli_fetch_array($query_run);
                                  ?>
                                    <form action="teacher.php" method="POST">
                                          <input type="hidden" name="teacher_id" value="<?= $teacher_id?>">

                                              <div class="mb-3">
                                              <label for="gender" class="form-label">Gender:</label>
                                              <p class="form-control"><?=$teacher['gender'];?></p>
                                              </div>

                                              <div class="mb-3">
                                              <label for="birthdate" class="form-label">Date of Birth:</label>
                                              <p class="form-control"><?=$teacher['birthdate'];?></p> 
                                              </div>

                                              <div class="mb-3">
                                              <label for="city" class="form-label">City:</label>
                                              <p class="form-control"><?=$teacher['city'];?></p>
                                              </div>

                                              <div class="mb-3">
                                              <label for="contact" class="form-label">Contact Number:</label>
                                              <p class="form-control"><?=$teacher['contact'];?></p>
                                              </div>

                                              <div class="mb-3">
                                              <label for="email" class="form-label">E-mail:</label>
                                              <p class="form-control"><?=$teacher['email'];?></p>
                                              </div>

                                              <div>
                                              <a class="btn text-white pull-right" href="teacher.php" role="button" id="cancel">Back</a>
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

            <div class="col-sm-8">
                <div class="card mt-3" id="teachercard">
                    <div class="card-body">
                        <div class="card-title">
                          <h1 style="color: #004500;">ADD STUDENT:</h1>
                        </div>
                        <!-- ADD THE ADDING STUDENT FORM -->
                        <div class="card-title">
                          <h1 style="color: #004500;">MARK ATTENDANCE</h1>
                        </div>
                        <div class="table-responsive">
                          <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                  <th>Student ID</th>
                                  <th>Name</th>
                                  <th>Year</th>
                                  <th>Course</th>
                                  <th>Subject</th>
                                  <th>Date</th>
                                  <th>Status</th>
                                  <th>Action</th>
                                </tr>
                            </thead>  
                          </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      

      <!-- Bootstrap modal
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
      </div> -->

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
      </script>
    </body>
</html>