
<?php
session_start();

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: admin.php');
    exit;
}

// Display the admin dashboard HTML
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
<div class="wrapper">
 	<div class="heading">
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    
    <ul>
        <li><a href="admin.php"><h2><b>View Bookings</b></h2></a></li>
        
        <li><a href="logout.php"><h3>Logout<h3></a></li>
    </ul>
</div>
</div>
</body>
</html>
