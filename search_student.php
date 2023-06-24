<?php
include("db_conn.php");

// Retrieve the search query from the URL parameter
$searchQuery = $_GET['search'];

if (!empty($searchQuery)) {

    // Perform the database query to fetch the search results
    // Modify the query based on your table structure and search logic
    $query = "SELECT * FROM students WHERE (full_name LIKE '%$searchQuery%'
                OR student_number LIKE '%$searchQuery%'
                OR year LIKE '%$searchQuery%'
                OR course LIKE '%$searchQuery%'
                OR date_added LIKE '%$searchQuery%'
                or teacher_id LIKE '%$searchQuery%')";

    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        ?>
        <table id="student-table" class="table table-hover table-striped">
            <thead class="table-success">
                <tr>
                    <th>EMP</th>
                    <th>Name</th>
                    <th>Year & Section</th>
                    <th>Course</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the search results and generate HTML rows
                foreach ($query_run as $student) {
                    ?>
                    <tr>
                        <td><?= $student['student_number']; ?></td>
                        <td><?= $student['full_name']; ?></td>
                        <td><?= $student['year']; ?></td>
                        <td><?= $student['course']; ?></td>
                        <td>
                            <a href="student-view.php?student_number=<?= $student['student_number']; ?>" class="btn btn-sm">
                                <img src="view.svg">
                            </a>
                            <a href="student-edit.php?student_number=<?= $student['student_number']; ?>" class="btn btn-sm">
                                <img src="user-edit.svg">
                            </a>
                            <form action="student-delete.php" method="POST" class="d-inline">
                                <button type="submit" name="delete_student" value="<?= $student['student_number']; ?>" class="btn btn-sm">
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
        echo "No matching records found.";
    }
} else {
    echo "No search query provided.";
}
?>