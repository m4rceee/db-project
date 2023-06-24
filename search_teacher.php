<?php
include("db_conn.php");

// Retrieve the search query from the URL parameter
$searchQuery = $_GET['search'];

if (!empty($searchQuery)) {

    // Perform the database query to fetch the search results
    // Modify the query based on your table structure and search logic
    $query = "SELECT * FROM teachers WHERE (full_name LIKE '%$searchQuery%'
                OR EMP LIKE '%$searchQuery%'
                OR department LIKE '%$searchQuery%'
                OR date_added LIKE '%$searchQuery%'
                or teacher_id LIKE '%$searchQuery%')";

    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        ?>
        <table id="teacher-table" class="table table-hover table-striped">
            <thead class="table-success">
                <tr>
                    <th>EMP</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the search results and generate HTML rows
                foreach ($query_run as $teacher) {
                    ?>
                    <tr>
                        <td><?= $teacher['EMP']; ?></td>
                        <td><?= $teacher['full_name']; ?></td>
                        <td><?= $teacher['department']; ?></td>
                        <td>
                            <a href="teacher-view.php?EMP=<?= $teacher['EMP']; ?>" class="btn btn-sm">
                                <img src="view.svg">
                            </a>
                            <a href="teacher-edit.php?EMP=<?= $teacher['EMP']; ?>" class="btn btn-sm">
                                <img src="user-edit.svg">
                            </a>
                            <form action="teacher-delete.php" method="POST" class="d-inline">
                                <button type="submit" name="delete_teacher" value="<?= $teacher['EMP']; ?>" class="btn btn-sm">
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