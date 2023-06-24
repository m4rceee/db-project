<?php
include("db_conn.php");

// Retrieve the search query from the URL parameter
$searchQuery = $_GET['search'];

if (!empty($searchQuery)) {

    // Perform the database query to fetch the search results
    // Modify the query based on your table structure and search logic
    $query = "SELECT * FROM subjects WHERE (subj_name LIKE '%$searchQuery%'
                OR subj_id LIKE '%$searchQuery%'
                OR course LIKE '%$searchQuery%'
                OR subj_code LIKE '%$searchQuery%'
                OR date_added LIKE '%$searchQuery%')";

    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        ?>
        <table id="subject-table" class="table table-hover table-striped">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Course</th>
                    <th>Subject Name</th>
                    <th>Subject Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the search results and generate HTML rows
                foreach ($query_run as $courses_subj) {
                    ?>
                    <tr>
                        <td><?= $courses_subj['subj_id']; ?></td>
                        <td><?= $courses_subj['course']; ?></td>
                        <td><?= $courses_subj['subj_name']; ?></td>
                        <td><?= $courses_subj['subj_code']; ?></td>
                        <td>
                            <a href="subject-edit.php?subj_id=<?= $courses_subj['subj_id']; ?>" class="btn btn-sm">
                                <img src="user-edit.svg">
                            </a>
                            <form action="subject-delete.php" method="POST" class="d-inline">
                                <button type="submit" name="delete_course_subj" value="<?= $courses_subj['subj_id']; ?>" class="btn btn-sm">
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