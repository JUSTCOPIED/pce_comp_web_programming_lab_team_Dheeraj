<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    // Get form data
    $vid = $_POST['vid'];
    $days = $_POST['days'];
    
    // Process the data (e.g., insert into the database)
    // Modify the database connection code as needed

    // Example database connection and query
    $servername = "localhost";
    $username = "root"; // MySQL User Name
    $password = ""; // MySQL Password
    $dbname = "user"; // MySQL DB Name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Example query to insert data into a table
    $sql = "INSERT INTO your_table_name (vid, days) VALUES ('$vid', '$days')";

    if ($conn->query($sql) === TRUE) {
        echo "Form data inserted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    // Handle unauthorized access or missing session
    echo "Unauthorized access";
}
?>
