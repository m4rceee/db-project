<?php
include("db_conn.php");

// Retrieve the attendance ID and status from the POST request
$attendanceId = mysqli_real_escape_string($conn, $_POST['attendance_id']);
$status = mysqli_real_escape_string($conn, $_POST['status']);

// Update the status in the database
$query = "UPDATE attendance SET status='$status' WHERE attendance_id='$attendanceId'";
$query_run = mysqli_query($conn, $query);

if ($query_run) {
  // Update successful, you can send a response if needed
  echo "Attendance status updated successfully.";
} else {
  // Update failed, you can send an error response if needed
  echo "Failed to update attendance status.";
}

// Close the database connection
mysqli_close($conn);
?>