<?php
include("db_conn.php");

// Retrieve the search query from the URL parameter
$searchQuery = $_GET['search'];

if (!empty($searchQuery)) { 

    // Perform the database query to fetch the search results
    // Modify the query based on your table structure and search logic
    $query = "SELECT * FROM attendance WHERE (full_name LIKE '%$searchQuery%'
            OR student_number LIKE '%$searchQuery%'
            OR year LIKE '%$searchQuery%'
            OR course LIKE '%$searchQuery%'
            OR subj_code LIKE '%$searchQuery%'
            OR date LIKE '%$searchQuery%'
            OR status LIKE '%$searchQuery%'
            or teacher_id LIKE '%$searchQuery%') ORDER BY date DESC";

    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        ?>
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
                                  <img src="no-attendance.svg" alt="Status">
                    <?php } ?>
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
    $query = "SELECT * FROM attendance ORDER BY date DESC";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        ?>
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
                        <img src="no-attendance.svg" alt="Status">
                    <?php } ?>
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