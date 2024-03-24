<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Include connection script
require_once('connection.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_SESSION['user_id'];
    $descr = $_POST['descr'];
    $modelname = $_POST['modelname'];
    $city = $_POST['city'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $connector = $_POST['connector'];
    $drange = $_POST['drange'];

    $file_name = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = "images/".$file_name;

    // $file_name = $_FILES['image']['name'];
    // $tempname = $_FILES['image']['tmp_name'];
    // $folder = "images/".$filename;


    // Insert car details into database
    $sql = "INSERT INTO vehicles (hid, descr, modelname, city, capacity, connector, drange, price, file) 
            VALUES ('$user_id', '$descr', '$modelname', '$city', '$capacity', '$connector', '$drange', '$price', '$file_name')";

    if ($conn->query($sql) === TRUE && move_uploaded_file($tempname, $folder)) {
        $_SESSION['success_message'] = "New car added successfully!";
    
        // Redirect to home page
        header("Location: home.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        header {
            background-color: #f5f5f5;
            padding: 20px 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .signin-container {
            position: fixed;
            bottom: 50%;
            left: 50%;
            transform: translate(-50%, 50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 600px; /* Increase max-width */
            width: 100%;
            box-sizing: border-box;
        }

        .signin-form {
            display: flex;
            flex-direction: column;
        }

        .city-selector-dealer {
            margin-top: 10px;
        }

        #submitButton {
            margin-top: 20px; /* Increase margin-top for better spacing */
        }

        /* Style for the file input container */
        
        /* Style for the actual file input */
        

        /* Style for the file input button */
        .file-input-button {
            border: 1px solid #ccc;
            padding: 8px 15px;
            background-color: #f9f9f9;
            cursor: pointer;
            /* Add some styles to make the button visible */
            display: inline-block;
            color: #333;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="signin-container">
                <h2>Add your Details</h2>
                <form class="signin-form" method = "post" enctype = 'multipart/form-data' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                    <input type="text" name = "modelname" placeholder ="Car Name" required>
                    <input type="text" name = 'price' placeholder ="Price/Day" required>
                    <input type="text" name = 'descr' placeholder="Description" required>
                    <input type="text" name = 'drange' placeholder="Driving Range" required>
                    <div class="city-selector-dealer">
                        <label for="connector">Select connector type: </label>
                        <select id="connector" name = 'connector'>
                            <option value="IEC60309 Mennekes">IEC60309 Mennekes</option>
                            <option value="IEC62196-2">IEC62196-2</option>
                            <option value="GB/T">GB/T</option>
                            <option value="CCS2">CCS2</option>
                            <option value="CHAdeM0">CHAdeM0</option>
                        </select>
                    </div>
                    <div class="city-selector-dealer">
                        <label for="capacity">Select seat capacity: </label>
                        <select id="capacity" name = 'capacity'>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="7">7</option>
                        </select>
                    </div>
                    <div class="city-selector-dealer">
                        <label for="city">Select a city: </label>
                        <select id="city" name="city">
                        <option value="Belapur">Belapur</option>
                        <option value="Nerul">Nerul</option>
                        <option value="Sanpada">Sanpada</option>
                        <option value="Vashi">Vashi</option>
                        <option value="Kopar Kharaine">Kopar Kharaine</option>
                        <option value="Ghansoli">Ghansoli</option>
                        <option value="Airoli">Airoli</option>
                        
                    </select>

                    </div>
                    
                    <!-- File input container -->
                    <div class="file-input-container">
                        <label for="imageInput" class="file-input-button">Upload Image</label>
                        <input type="file" name="image" id="imageInput" accept=".jpg, .jpeg, .png" >
                    </div>

                    <button type="submit" id="submitButton">
                        <a class="button-link">Submit</a>
                    </button>
                </form>
            </div>
        </div>
    </header>
</body>
<script>
    document.getElementById('submitButton').addEventListener('click', function() {
        const carName = document.querySelector('input[placeholder="Car Name"]').value;
        const range = document.querySelector('input[placeholder="Range"]').value;
        const connectorType = document.querySelector('input[placeholder="Connector Type"]').value;
        const seats = document.querySelector('input[placeholder="Seats"]').value;
        const pricePerDay = document.querySelector('input[placeholder="Price/Day"]').value;
        const description = document.querySelector('input[placeholder="Description"]').value;
        const city = document.getElementById('city').value;
        
        const imageInput = document.getElementById('imageInput');
        const selectedImage = imageInput.files[0];

        if (selectedImage) {
            window.location.href = 'cars.html';
        } else {
            alert("Please select an image!");
        }
    });
</script>
</html>

