<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $guests = $_POST['guests'];
    $leaving = $_POST['leaving'];
    $tourName = $_POST['tour_name'];
    $arrivals = $_POST['arrivals'];
    
    
    // Validate form data
    $errors = array();
    
    if (empty($tourName)) {
        $errors[] = "Tour name is required.";
    }
    
    if (empty($arrivals)) {
        $errors[] = "Tour date is required.";
    }
    
    // Check tour limit
    $tourLimit = 10; // Set the tour limit here
    
    // Assuming you have a database connection
    $host= 'localhost';
    $user='root';
    $pass='';
    $dbname='book_db';

    
    
    $conn = mysqli_connect($host, $user, $pass, $dbname);


    $query = "SELECT COUNT(*) AS booked_tours FROM book_form WHERE arrivals = '$arrivals'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $bookedTours = $row['booked_tours'];
        
        if ($bookedTours >= $tourLimit) {
            $errors[] = '<script type="text/javascript">alert("Tour fully booked for the selected date. Please choose another date.")</script>';
        }
    }
    
    // Display errors or proceed with booking
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    } else {
        // Insert booking into database
        $insertQuery = "INSERT INTO book_form (name,email,phone,address,tour_name,guests,arrivals,leaving) VALUES ('$name','$email','$phone','$address','$tourName','$guests','$arrivals','$leaving')";
        $insertResult = mysqli_query($conn, $insertQuery);
        
        if ($insertResult) {
            echo '<script type="text/javascript">alert("Tour booked successfully!")</script>';
        } else {
            echo "Error occurred while booking the tour.";
        }
    }
    
    
   

    // Close database connection
    mysqli_close($conn);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>book</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
		function validateFunction() {
        console.log('Validating form...');
        let bookingDate = new Date(document.getElementById('arrivals').value);
        let leavingDate = new Date(document.getElementById('leaving').value);
        let currentDate = new Date();

        if (bookingDate < currentDate) {
            console.log('Booking date error');
            document.getElementById('booking-date-error').textContent = "Sorry, we cannot accept bookings from past dates.";
            return false;
        } else {
            document.getElementById('booking-date-error').textContent = "";
        }

        if (leavingDate < currentDate) {
            console.log('Leaving date error');
            document.getElementById('leaving-date-error').textContent = "Sorry, leaving date cannot be in the past.";
            return false;
        } else {
            document.getElementById('leaving-date-error').textContent = "";
        }

        if (leavingDate < bookingDate) {
            console.log('Leaving date error');
            document.getElementById('leaving-date-error').textContent = "Sorry, leaving date must be after booking date.";
            return false;
        } else {
            document.getElementById('leaving-date-error').textContent = "";
        }
        
        let email = document.getElementById('email').value;
            let emailRegex = /^\S+@\S+\.\S+$/;
        if (!emailRegex.test(email)) {
            console.log('Email error');
            document.getElementById('email-error').textContent = "Please enter a valid email address.";
        return false;
            } else {
                document.getElementById('email-error').textContent = "";
                }

            let phoneNumber = document.getElementById('phone').value;
            if (phoneNumber.length !== 10 || isNaN(phoneNumber)) {
                console.log('Phone number error');
                document.getElementById('phone-number-error').textContent = "Please enter a valid 10-digit phone number.";
                return false;
            } else {
                document.getElementById('phone-number-error').textContent = "";
            }

            console.log('Validation successful!');
            return true;
            }

            function submitFunction() {
    if (!validateFunction()) {
        alert("Form not submitted. Please fix errors in the form.");
        return false;
    }
    return true;
}

            /*function submitFunction(event) {
            event.preventDefault();
            if (validateFunction()) {
                console.log('Submitting form...');
                document.getElementById('book-form').submit();
            } else {
                alert('Please correct the errors in the form before submitting.');
            }
            }*/
                document.getElementById('book-form').addEventListener('submit', submitFunction);
		
	</script>
    
</head>

<body>
    <!--header section starts-->
    <section class="header">
        <a href="home.php" class="logo">travel.</a>
        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="package.php">package</a>
            <a href="tour.php">book tour</a>
            <a href="login.php">admin login</a>
        </nav>
        <div id="menu-btn" class="fas fa-bars"></div>
    </section>
    <!--header section ends-->

    <div class="heading" style="background:url(bg3.jpg) no-repeat">
        <h1>book now</h1>
    </div>

    <!--booking section starts-->
    <section class="booking">
        <h1 class="heading-title">book your trip !</h1>
        <form onsubmit="return validateFunction();" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="book-form" id="book-form">
      
            <div class="flex">
                <div class="inputBox">
                    <span>name :</span>
                    <input type="text" placeholder="enter your name" name="name" required oninput="validateFunction()"> 
                    <span id="name-error" style="color: red;"></span>
                </div>
                <div class="inputBox">
                    <span>email :</span>
                    <input type="email" id="email" placeholder="enter your email" name="email" required oninput="validateFunction()">
                    <span id="email-error" style="color: red;"></span>
                </div>
                <div class="inputBox">
                    <span>phone :</span>
                    <input type="number" placeholder="enter your number" id="phone" name="phone" required oninput="validateFunction()">
            <span id="phone-number-error" style="color: red;"></span>
                </div>
                <div class="inputBox">
                    <span>address :</span>
                    <input type="text" placeholder="enter your address" name="address" required>
                </div>
                <div class="inputBox">
                    <span><label>where to :</label></span><br>
                    <select name="tour_name" required>
                        <option value="none" selected disabled hidden>Select Your Tour</option>
                        <option value="tajmahal">Taj Mahal</option>
                        <option value="murudjanjira">Murud Janjira Fort</option>
                        <option value="tadoba">Tadoba National Park</option>
                        <option value="matheran">Matheran</option>
                        <option value="khanapur">Khanapur Camping</option>
                        <option value="alibaug">Alibaug Beach</option>
                        <option value="manali">Manali</option>
                        <option value="Kachh">Kachh Desert</option>
                        <option value="london">London Tour</option>
                        <option value="andaman">Andaman Island</option>
                        <option value="sydney">Sydney Tour</option>
                        <option value="diudaman">Diu & Daman</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>how many :</span>
                    <input type="number" placeholder="number of guests" name="guests" required>
                </div>
                <div class="inputBox">
                    <span>arrivals :</span>
                    <input type="date" id="arrivals" name="arrivals" required oninput="validateFunction()">
                    <span id="booking-date-error" style="color: red;"></span>
                </div>
                <div class="inputBox">
                    <span>leaving :</span>
                    <input type="date" id="leaving" name="leaving" required oninput="validateFunction()">
                    <span id="leaving-date-error" style="color: red;"></span>
                </div>
            </div>
            <input type="submit" value="Book Tour" class="btn" name="Book Tour" onclick="submitFunction()">
        </form>
    </section>
    <!--booking section ends-->



















    <!--footer section starts-->
    <section class=" footer">
        <div class="box-container">
            <div class="box">
                <h3>quick links</h3>
                <a href="home.php"><i class="fas fa-angle-right"></i> home</a>
                <a href=" about.php"><i class="fas fa-angle-right"></i> about</a>
                <a href="package.php"><i class="fas fa-angle-right"></i> package</a>
                <a href="book.php"><i class="fas fa-angle-right"></i> book</a>

            </div>

            <div class="box">
                <h3>extra links</h3>
                <a href="#"><i class="fas fa-angle-right"></i> ask questions</a>
                <a href="#"><i class="fas fa-angle-right"></i> about us</a>
                <a href="#"><i class="fas fa-angle-right"></i> privacy policy</a>
                <a href="#"><i class="fas fa-angle-right"></i> terms of use</a>

            </div>

            <div class="box">
                <h3>contact info</h3>
                <a href="#"><i class="fas fa-phone"></i> 919-370-1855 </a>
                <a href="#"><i class="fas fa-phone"></i> 919-323-1823 </a>
                <a href="#"><i class="fas fa-envelope"></i> traveltours@gmail.com </a>
                <a href="#"><i class="fas fa-map"></i> pune, india - 411002 </a>


            </div>

            <div class="box">
                <h3>follow us</h3>
                <a href="#"><i class="fab fa-facebook-f"></i> facebook </a>
                <a href="#"><i class="fab fa-twitter"></i> twitter </a>
                <a href="#"><i class="fab fa-instagram"></i> instagram </a>
                <a href="#"><i class="fab fa-linkedin"></i> linkedin </a>
            </div>
        </div>
        <div class="credit"> created by<span><b><i> Travel & Tours </b></i></span>| all rights reserved !</div>
    </section>
    <!--footer section ends-->








    <script src=" https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js">
    </script>
    <script src="script.js"></script>
    <script>
        $(document).ready(function(){
            $('#icon').click(function(){
                $('ul').toggleClass('show');
            });
        });
    </script>


</body>

</html>