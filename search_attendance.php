<?php
include("db_conn.php");

// Retrieve the search query from the URL parameter
$searchQuery = $_GET['search'];
$emp = $_GET['EMP'];

if (!empty($searchQuery)) { 

    // Perform the database query to fetch the search results
    // Modify the query based on your table structure and search logic
    $query = "SELECT * FROM attendance WHERE teacher_id='$emp' AND (full_name LIKE '%$searchQuery%'
            OR student_number LIKE '%$searchQuery%'
            OR year LIKE '%$searchQuery%'
            OR course LIKE '%$searchQuery%'
            OR subj_code LIKE '%$searchQuery%'
            OR date LIKE '%$searchQuery%'
            OR status LIKE '%$searchQuery%')";

    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        ?>
        <table id="attendance-table" class="table table-hover table-striped">
            <thead class="table-success">
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
            <tbody>
            <?php
    // Loop through the search results and generate HTML rows
    foreach ($query_run as $student) {
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
                                    <a href="#" class="btn present-btn">
                                        <img src="present.svg">
                                    </a>
                                    <a href="#" class="btn absent-btn">
                                        <img src="absent.svg">
                                    </a>
                    <?php } ?>
                </td>
                <td>
                    <a href="attendance-edit.php?attendance_id=<?= $student['attendance_id']; ?>&teacher_id=<?= $student['teacher_id']; ?>" class="btn btn-sm">
                    <img src="user-edit.svg">
                    </a>
                    <form action="#" method="POST" class="d-inline">
                    <button type="submit" name="delete_teacher" value="#" class="btn btn-sm delete-row-btn">
                        <img src="user-remove.svg">
                    </button>
                    </form>
                </td>
                </tr>
            </tbody>
        </table>
            <?php
        }
        } else {
        echo "No matching records found.";
        }        
} else {
    // Fetch all records from the attendance table
    $teacher_id = mysqli_real_escape_string($conn, $_GET['EMP']);
    $query = "SELECT * FROM attendance WHERE teacher_id='$teacher_id'";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        ?>
        <table id="attendance-table" class="table table-hover table-striped">
            <thead class="table-success">
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
            <tbody>
        <?php
        foreach ($query_run as $student) {
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
                        <a href="#" class="btn present-btn">
                            <img src="present.svg">
                        </a>
                        <a href="#" class="btn absent-btn">
                            <img src="absent.svg">
                        </a>
                    <?php } ?>
                </td>
                <td>
                    <a href="attendance-edit.php?attendance_id=<?= $student['attendance_id']; ?>&teacher_id=<?= $student['teacher_id']; ?>" class="btn btn-sm">
                        <img src="user-edit.svg">
                    </a>
                    <form action="#" method="POST" class="d-inline">
                        <button type="submit" name="delete_teacher" value="#" class="btn btn-sm delete-row-btn">
                            <img src="user-remove.svg">
                        </button>
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
            </tbody>
        </table>
        <?php
    } else {
        echo "No student records found.";
    }
}


?>