<!DOCTYPE html>
<html>
<head>
    <title>Teacher Attendance System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Teacher Attendance System</h1>
        <hr>

        <!-- Display Teacher Details -->
        <h3>Teacher Details</h3>
        <?php
        // Connect to teachers_db and retrieve teacher details
        $dbHost = "localhost";
        $dbUser = "username";
        $dbPass = "password";
        $dbName = "teachers_db";

        $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Assuming you have a table named 'teachers' with columns 'teacher_id', 'teacher_name', 'teacher_email', etc.
        $teacherId = 1; // Assuming the teacher's ID is 1

        $query = "SELECT * FROM teachers WHERE teacher_id = $teacherId";
        $result = mysqli_query($conn, $query);
        $teacher = mysqli_fetch_assoc($result);

        if ($teacher) {
            echo "<p>Teacher ID: " . $teacher['teacher_id'] . "</p>";
            echo "<p>Teacher Name: " . $teacher['teacher_name'] . "</p>";
            echo "<p>Teacher Email: " . $teacher['teacher_email'] . "</p>";
        } else {
            echo "<p>Teacher details not found.</p>";
        }

        mysqli_close($conn);
        ?>

        <hr>

        <!-- Attendance Form -->
        <h3>Attendance Form</h3>
        <form method="post" action="">
            <div class="form-group">
                <label for="student">Student:</label>
                <select class="form-control" id="student" name="student">
                    <?php
                    // Connect to students_db and retrieve student options
                    $dbHost = "localhost";
                    $dbUser = "username";
                    $dbPass = "password";
                    $dbName = "students_db";

                    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Assuming you have a table named 'students' with columns 'student_id', 'student_name', 'year', 'course', etc.
                    $query = "SELECT * FROM students";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['student_id'] . "'>" . $row['student_name'] . "</option>";
                    }

                    mysqli_close($conn);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Subject Code:</label>
                <select class="form-control" id="subject" name="subject">
                    <?php
                    // Connect to courses_subj_db and retrieve subject options
                    $dbHost = "localhost";
                    $dbUser = "username";
                    $dbPass = "password";
                    $dbName = "courses_subj_db";

                    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Assuming you have a table named 'courses_subj' with columns 'subject_id', 'subject_code', 'subject_name', etc.
                    $query = "SELECT * FROM courses_subj";
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['subject_id'] . "'>" . $row['subject_code'] . "</option>";
                    }

                    mysqli_close($conn);
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>

        <hr>

        <!-- Display Attendance Table -->
        <h3>Attendance</h3>
        <?php
        if (isset($_POST['submit'])) {
            $studentId = $_POST['student'];
            $subjectId = $_POST['subject'];

            if (empty($studentId) || empty($subjectId)) {
                echo '<div class="alert alert-danger" role="alert">Please select a student and subject code.</div>';
            } else {
                // Connect to attendance_db and store attendance data
                $dbHost = "localhost";
                $dbUser = "username";
                $dbPass = "password";
                $dbName = "attendance_db";

                $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Assuming you have a table named 'attendance' with columns 'attendance_id', 'teacher_id', 'student_id', 'subject_id', 'status', etc.
                $teacherId = 1; // Assuming the teacher's ID is 1
                $status = "Present";

                $query = "INSERT INTO attendance (teacher_id, student_id, subject_id, status) VALUES ($teacherId, $studentId, $subjectId, '$status')";
                if (mysqli_query($conn, $query)) {
                    echo '<div class="alert alert-success" role="alert">Attendance recorded successfully.</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error recording attendance.</div>';
                }

                mysqli_close($conn);
            }
        }
        ?>

        <!-- Display Attendance Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Full Name</th>
                    <th>Year</th>
                    <th>Course</th>
                    <th>Subject Code</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to attendance_db and retrieve attendance records for the teacher
                $dbHost = "localhost";
                $dbUser = "username";
                $dbPass = "password";
                $dbName = "attendance_db";

                $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $teacherId = 1; // Assuming the teacher's ID is 1

                $query = "SELECT s.student_number, s.full_name, s.year, s.course, c.subject_code, a.status 
                          FROM attendance a 
                          JOIN students_db.students s ON a.student_id = s.student_id
                          JOIN courses_subj_db.courses_subj c ON a.subject_id = c.subject_id
                          WHERE a.teacher_id = $teacherId";

                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['student_number'] . "</td>";
                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['course'] . "</td>";
                    echo "<td>" . $row['subject_code'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "</tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
