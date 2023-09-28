<?php
    $connection = mysqli_connect('localhost','root','','book_db');
    
    // Check if the connection to the database was successful
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Retrieve all form submissions from the book_form table
    $query = "SELECT * FROM book_form";
    $result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Admin Panel</h1>

    <?php
        // Check if there are any form submissions
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Submission ID</th>';
            echo '<th>Name</th>';
            echo '<th>Email</th>';
            echo '<th>Phone</th>';
            echo '<th>Address</th>';
            echo '<th>TourName</th>';
            echo '<th>Guests</th>';
            echo '<th>Arrivals</th>';
            echo '<th>Leaving</th>';
            echo '<th>Action</th>';
            echo '</tr>';

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['phone'] . '</td>';
                echo '<td>' . $row['address'] . '</td>';
                echo '<td>' . $row['tour_name'] . '</td>';
                echo '<td>' . $row['guests'] . '</td>';
                echo '<td>' . $row['arrivals'] . '</td>';
                echo '<td>' . $row['leaving'] . '</td>';
                echo '<td><button class="delete-btn" onclick="deleteSubmission(' . $row['id'] . ')">Delete</button></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo "<p>No form submissions found.</p>";
        }

        // Close the database connection
        mysqli_close($connection);
    ?>

    <script>
        function deleteSubmission(submissionId) {
            if (confirm("Are you sure you want to delete this submission?")) {
                // Send an AJAX request to delete the submission
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_submission.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Refresh the page to reflect the updated data
                        window.location.reload();
                    }
                };
                xhr.send("submissionId=" + submissionId);
            }
        }
    </script>
</body>
</html>
