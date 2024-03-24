<?php
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

// Check if login form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape user input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if username and password are provided
    if (empty($username) || empty($password)) {
        $error = "Please enter your username and password.";
    } else {
        // Fetch user data based on username
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();  // Get user data as an associative array

            // Verify password using password_verify (requires password_hash in registration)
            if (password_verify($password, $user['password'])) {
                // Login successful (redirect or start session)
                session_start();  // Start session if not already started
                $_SESSION['user_id'] = $user['uid'];  // Store user ID in session
                header("Location: home.php");  // Redirect to user home page
                exit; // Stop further execution
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Add your CSS styles here -->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        body.login-page {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Set min-height to 100vh for full viewport height */
        }

        .login-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 90%; /* Adjust the width as needed */
            max-width: 400px; /* Set max-width for better responsiveness */
            margin-top: 50px;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }

        .return-home-button {
            background-color: #ccc;
            color: #000;
            width: 100%; /* Make the button full width */
            padding: 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
        }

        .return-home-button:hover {
            background-color: #999;
        }

        .checkbox-container label {
            display: flex;
            flex-direction: column;
            align-items: center;
            white-space: nowrap;
        }

        .checkbox-container p {
            margin: 5px 0;
        }

        .or-divider {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px 0;
        }

        .or-divider hr {
            flex-grow: 1;
            margin: 0 10px;
            border: none;
            border-top: 1px solid #ccc;
        }

        .or-divider span {
            color: #050404;
        }
    </style>
</head>
<body class="login-page">
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <button class="return-home-button" onclick="location.href='index.php'">Return to Homepage</button>
    </div>
</body>
</html>