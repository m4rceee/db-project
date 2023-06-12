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
                      </div>
                      <form action="admin-teacher.php" method="POST">
                          <div class="mb-3 mt-3">
                              <label for="fullname" class="form-label">Full Name:</label>
                              <input type="text" class="form-control" id="fullname" placeholder="Enter full name" name="fullname" autocomplete="off" required> 
                            </div>
                            <div class="mb-3">
                              <label for="gender" class="form-label">Gender:</label>
                              <input type="text" class="form-control" id="gender" placeholder="Enter gender" name="gender" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                              <label for="birthdate" class="form-label">Date of Birth:</label>
                              <input type="date" class="form-control" id="birthdate" placeholder="Enter birth date" name="birthdate" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                              <label for="city" class="form-label">City:</label>
                              <input type="text" class="form-control" id="city" placeholder="Enter city" name="city" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                              <label for="department" class="form-label">Department:</label>
                              <input type="text" class="form-control" id="department" placeholder="Enter department" name="department" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                              <label for="contact" class="form-label">Contact Number:</label>
                              <input type="text" class="form-control" id="contact" placeholder="Enter contact number" name="contact" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                              <label for="email" class="form-label">E-mail:</label>
                              <input type="email" class="form-control" id="email" placeholder="Enter e-mail" name="email" autocomplete="off" required>
                            </div>
                            <div class="d-flex justify-content-center gap-2 mt-4 mb-2">
                              <button type="submit" id="teachersbmt" class="btn">Log In</button>
                              <a class="btn text-white" href="#" role="button" id="cancel">Cancel</a>
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
                      <table class="table table-striped" id="table-bg">
                          <thead>
                            <tr>
                              <th>EMP</th>
                              <th>Name</th>
                              <th>Department</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>0001</td>
                              <td>Kahit Sino</td>
                              <td>Information Technology</td>
                              <td>
                                  <button class="btn btn-primary">Edit</button>
                                  <button class="btn btn-danger">Delete</button>

                              </td>
                            </tr>
                            <tr>
                              <td>0002</td>
                              <td>Kahit Sino</td>
                              <td>Information Technology</td>
                              <td>
                                  <button class="btn btn-primary">Edit</button>
                                  <button class="btn btn-danger">Delete</button>

                              </td>
                            </tr>
                            <tr>
                              <td>0003</td>
                              <td>Kahit Sino</td>
                              <td>Information Technology</td>
                              <td>
                                  <button class="btn btn-primary">Edit</button>
                                  <button class="btn btn-danger">Delete</button>

                              </td>
                            </tr>
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