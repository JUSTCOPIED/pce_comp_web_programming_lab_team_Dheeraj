<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body.signin-page {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Set height to 100vh for full viewport height */
        }

        .signin-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            padding: 3%;
            width: 80%; /* Adjust the width as needed */
            text-align: center; /* Center the text */
            max-width: 400px; /* Set a maximum width */
            margin-top: 5vh; /* Adjust the top margin as needed */
        }

        .signin-container h2 {
            margin-bottom: 20px;
        }

        .signin-form input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .signin-form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
        }

        .signin-form button:hover {
            background-color: #0056b3;
        }

        .checkbox-container {
            text-align: left;
            white-space: nowrap;
        }

        .checkbox-container label {
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        @keyframes formAni {
            0% {
                transform: translateY(-100px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .signin-form input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Media Query for smaller screens */
        @media (max-width: 768px) {
            .signin-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
<?php
// Database connection details (replace with your actual credentials)
$servername = "localhost";
$username = "root"; // MySQL User Name
$password = ""; // MySQL Password
$dbname = "user"; // MySQL DB Name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$error = '';
$success = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape user input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $phone = intval($phone);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $sql1 = "SELECT * FROM users WHERE username = '$username'";
    $sql2 = "SELECT * FROM users WHERE phone = '$phone'";
    $sql3 = "SELECT * FROM users WHERE email = '$email'";
    $result1 = $conn->query($sql1);
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);

    if ($result1->num_rows == 1) {
        $error = "Username already exists";
    }
    if ($result2->num_rows == 1) {
        $error = "Phone number already exists. Please go to login page if account already exists";
    }
    if ($result3->num_rows == 1) {
        $error = "Email already exists. Please go to login page if account already exists";
    }
    if ($result1->num_rows == 1 && $result2->num_rows == 1)
    {
        $error = "Username and phone number already exist. Please go to login page if account already exists";
    }
    if ($result2->num_rows == 1 && $result3->num_rows == 1)
    {
        $error = "Phone number and email already exist. Please go to login page if account already exists";
    }
    if ($result1->num_rows == 1 && $result3->num_rows == 1)
    {
        $error = "Username and email already exist. Please go to login page if account already exists";
    }
    if ($result1->num_rows == 1 && $result3->num_rows == 1 && $result2->num_rows == 1)
    {
        $error = "Username, phone number and email already exist. Please go to login page if account already exists";
    }
    if (empty($error)) {
        // Insert user data if not existing
        
        $sql = "INSERT INTO users (username, password, email, phone, fullname) 
                VALUES ('$username', '$hashed_password', '$email', '$phone', '$fullname')";
        if ($conn->query($sql) === TRUE) {
            // Registration successful
            $success = "Account Registered. Go to Login Page.";  // Replace with your success page
        } else {
            // Registration failed
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
<div class="background">
    <div class="signin-container">
        <h2>Sign Up</h2>
        <?php if (!empty($error)) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success)) : ?>
            <p style="color: green;"><?php echo $success; ?></p>
            <button class="go-back-button" onclick="location.href='login.php'">Go Back to Login Page</button>
        <?php else : ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="signin-form">
                <input type="text" name="username" placeholder="User Name" required>
                <input type="email" name="email" placeholder="Email ID" required>
                <input type="text" name="phone" id="phoneInput" placeholder="Phone Number" required>
                <input type="text" name="fullname" placeholder="Dealership Name/Full Name (as per Driving License)" required>
                <input type="password" name="password" placeholder="Password" required>

                <div class="checkbox-container">
                    <input type="checkbox" id="termsCheckbox" required>
                    <label for="termsCheckbox">I agree to the terms and conditions</label>
                </div>
                <button type="submit">Sign In</button>
                <!-- Add a "Go Back to Login Page" button -->
                <button class="go-back-button" onclick="location.href='login.php'">Go Back to Login Page</button>
                <!-- Add a "Go to Home Page" button -->
                <button class="go-home-button" onclick="location.href='index.php'">Go to Home Page</button>
            </form>
        <?php endif; ?>
    </div>
</div>
<script>
        function showSuccessMessage() {
            const successMessage = document.getElementById("successMessage");
            const passwordInput = document.getElementById("passwordInput");
            const confirmPasswordInput = document.getElementById("confirmPasswordInput");

            if (passwordInput.value !== confirmPasswordInput.value) {
                // Display an error message if passwords do not match
                successMessage.textContent = "Error: Passwords do not match.";
                return false;
            }

            // Show the success message
            successMessage.textContent = "Registration Successful. You can now login.";

            // Hide the form
            const signinForm = document.querySelector(".signin-form");
            signinForm.style.display = "none";

            // Redirect to the login page after a delay (e.g., 3 seconds)
            setTimeout(function () {
                location.href = "login.html";
            }, 3000);

            // Prevent the form submission
            return false;
        }

        // Phone number validation
        // const phoneInput = document.getElementById("phoneInput");
        // phoneInput.addEventListener("input", function () {
        //     const phoneNumber = phoneInput.value;
        //     if (!/^\d{10}$/.test(phoneNumber)) {
        //         // Display an error message or take appropriate action
        //         phoneInput.setCustomValidity("Phone number must be a 10-digit number");
        //     } else {
        //         phoneInput.setCustomValidity("");
        //     }
        // });
    </script><script>
        function showSuccessMessage() {
            const successMessage = document.getElementById("successMessage");
            const passwordInput = document.getElementById("passwordInput");
            const confirmPasswordInput = document.getElementById("confirmPasswordInput");

            if (passwordInput.value !== confirmPasswordInput.value) {
                // Display an error message if passwords do not match
                successMessage.textContent = "Error: Passwords do not match.";
                return false;
            }

            // Show the success message
            successMessage.textContent = "Registration Successful. You can now login.";

            // Hide the form
            const signinForm = document.querySelector(".signin-form");
            signinForm.style.display = "none";

            // Redirect to the login page after a delay (e.g., 3 seconds)
            setTimeout(function () {
                location.href = "login.html";
            }, 3000);

            // Prevent the form submission
            return false;
        }

        // Phone number validation
        const phoneInput = document.getElementById("phoneInput");
        phoneInput.addEventListener("input", function () {
            const phoneNumber = phoneInput.value;
            if (!/^\d{10}$/.test(phoneNumber)) {
                // Display an error message or take appropriate action
                phoneInput.setCustomValidity("Phone number must be a 10-digit number");
            } else {
                phoneInput.setCustomValidity("");
            }
        });
    </script>
</body>
</html>
