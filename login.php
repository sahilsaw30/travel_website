<?php
session_start();

// Check if the user is already logged in, if yes redirect to the admin dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform login validation here (e.g., check credentials against the database)

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'Password@123') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
<div class="wrapper">
 	<div class="heading">
    <h1>Login</h1>
</div>
    <?php if (isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
 		<form method="post" action="">
 			<span>
 				<i class="fa fa-user"></i>
 				<input type="text" placeholder="Username" name="username">
 			</span><br>
 			<span>
                <i class="fa-solid fa-lock"></i>
 				<input type="password" placeholder="Password" name="password">
 			</span><br>
			<input type="submit" value="Login">
		</form>
 </div>

</body>
</html>

