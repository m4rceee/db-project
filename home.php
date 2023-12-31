<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <link rel="stylesheet" href="style.css">
    
    <!-- fonts -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        .tagline {
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 25px;
        }
    </style>
    
    <title>Home Page</title>
</head>
<body>
    <!-- header -->
    <div class="header bg-transparent">
        <div class="container-fluid p-3 white text-center">
            <img src="logo.svg" alt="logo" width="175">
            <h1 class="title text-center text-uppercase text-white mt-2">Student Attendance Management System</h1>
            <p class="tagline">Empowering Education with an Efficient Attendance System</p>
        </div>
    </div>

    <!-- identification -->
    <div class="cn-1 container">
        <div class="card mx-auto">
            <div class="card-body">
                <div class="card-title text-center mt-3">
                    <h5>Welcome!</h5>
                </div>
                <p class="card-text" style="font-family: 'Poppins', sans-serif; font-size: 14px; color: black;">Please select your identification:</p>
            </div>
            <div class="d-grid gap-3">
                <a class="btn btn-block" href="admin-login.php" role="button" id="adminbtn">Admin</a>
                <a class="btn btn-block" href="teacher-login.php" role="button" id="teacherbtn">Teacher</a>
                <a class="btn btn-block mb-4" href="student-login.php" role="button" id="studentbtn">Student</a>
            </div>
        </div>
    </div>

    <!-- footer -->
    <!--<div class="footer">
        <div class="ftr-ctn container-fluid pt-3 pb-1 text-white text-center">
            <p class="ftr-1">Student Attendance Management System is a project developed by the 2nd Year Computer Science students
                of Cavite State University - Silang Campus. 
            </p>
             <p class="ftr-2"><strong>Contact Us:</strong> ryanpaul.marcelino@cvsu.edu.ph; ericemartin.delacruz@cvsu.edu.ph; vinroemann.leones@cvsu.edu.ph
            </p>
        </div>
    </div>-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        document.getElementById("adminbtn").addEventListener("click", function() {
        window.location.href = "admin-login.php";
    });
    </script>
</body>
</html>