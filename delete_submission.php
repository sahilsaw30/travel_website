<?php
    $connection = mysqli_connect('localhost', 'root', '', 'book_db');

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the submissionId parameter is provided
    if (isset($_POST['submissionId'])) {
        $submissionId = $_POST['submissionId'];

        // Construct the delete query
        $query = "DELETE FROM book_form WHERE id = '$submissionId'";

        // Execute the delete query
        if (mysqli_query($connection, $query)) {
            // Deletion successful
            echo "Submission deleted successfully";
        } else {
            // Error in deletion
            echo "Error deleting submission: " . mysqli_error($connection);
        }
    } else {
        // No submissionId parameter provided
        echo "Invalid request";
    }

    // Close the database connection
    mysqli_close($connection);
?>
