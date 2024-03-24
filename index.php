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

// Update iscomplete column based on expiry date
$currentDateTime = date('Y-m-d H:i:s');
$sql_update = "UPDATE orders SET iscomplete = 1 WHERE expiry < ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("s", $currentDateTime);
$stmt_update->execute();
$stmt_update->close();

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>cars Website</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        text-decoration: none;
        list-style: none;
        font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande",
          "Lucida Sans", Arial, sans-serif;
      }

      :root {
        --color-primary: rgb(23, 67, 227);
        --color-white: #eaeaea;
        --color-dark: #333;
        --color-black: #222;
      }

      .container {
        max-width: 1620px;
        width: 90%;
        margin: 0 auto;
      }

      /* .......................Start Nav Bar...................... */
      nav {
        width: 100%;
        height: 8%;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 100;
        display: grid;
        place-items: center;
       
      }

      .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .nav-container ul {
        display: flex;
        align-items: center;
        gap: 30px;
      }

      .logo h3 {
        font-size: 25px;
        color: var(--color-black);
        opacity: 0;
        animation: logoAni 1s ease forwards;
      }

      .nav-link li a {
        color: var(--color-black);
        font-size: 17px;
        transition: 0.4s ease;
        display: inline-block;
        animation: NavliaAni forwards 1s ease;
        animation-delay: calc(0.2s * var(--i));
        opacity: 0;
      }

      .nav-link li a:hover {
        color: var(--color-primary);
      }

      .nav-link li .active {
        color: var(--color-primary);
      }

      /* .......................End Nav Bar...................... */

      /* .......................Animation Start...................... */
      @keyframes logoAni {
        0% {
          transform: translateX(-100px);
          opacity: 0;
        }

        100% {
          transform: translateX(0);
          opacity: 1;
        }
      }

      @keyframes NavliaAni {
        0% {
          transform: translateY(100px);
          opacity: 0;
        }

        100% {
          transform: translateY(0);
          opacity: 1;
        }
      }


      footer {
  background-color: #1743e3;
  color: white;
  padding: 20px 0;
  text-align: center;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  position: relative;
}

.contact-info {
  width: 100%;
  text-align: left;
  padding-right: 20px;
  box-sizing: border-box;
  margin-left: auto;
  margin-right: auto;
}

#map-frame {
  width: calc(50% - 20px);
  height: 300px;
  margin-top: 20px;
  overflow: hidden;
  border-radius: 10px;
 
}

#map {
  width: 100%;
  height: 100%;
  position: relative;
  right: 20%;
}

.footer-copyright {
  color: white;
  position: absolute;
  bottom: 10px;
  left: 10px;
}



@keyframes slideInFromBottom {
  0% {
    transform: translateY(100%);
    opacity: 0;
  }

  100% {
    transform: translateY(0);
    opacity: 1;
  }
}



      .infobox {
        
        width: calc(30% - 20px);
        margin: 10px;
        padding: 20px;
        border: 1px solid transparent;
        overflow: hidden;
        display: inline-block;
        vertical-align: top;
      }

      img {
        max-width:  40%;
        max-height: 40%;
      }

      @media only screen and (max-width: 591px) {
        .infobox {
          width: calc(100% - 25px);
        }
        footer {
    flex-direction: column;
        }
      }

      .video-container {
        position: relative;
        width: 85%;
        padding-block: 25%;
        overflow: hidden;
        display: inline-block;
        vertical-align: top;

      }

      .video-container video {
        position: absolute;
        top: 15%;
        width: 90%;
        height: 80%;
      }
      
    </style>
  </head>

  <body class="container">
    <section>
      <!-- ..................Start Navbar................... -->
      <nav>
        <div class="container nav-container">
          <a href="" class="logo">
            <h3>AutoElegance.</h3>
          </a>
          <ul class="nav-link">
            <!--<li><a href="" style="--i:1;" class="active">Home</a></li> -->
            <li><a href="about.php" style="--i: 2">About</a></li>
            <li><a href="login.php" style="--i: 2">Login</a></li>
            <li><a href="registration.php" style="--i: 2">Register</a></li>
          </ul>
        </div>
      </nav>
      <div class="video-container">
        <video src="images/WP-FINAL.mp4" autoplay muted loop></video>
      </div>
      <!-- ..................End Navbar................... -->
    </section>

    <!-- Electric Car Section -->
    <section>

      <h2>Why Electric Cars?</h2>

      <div class="infobox">
        <div class="box-content">
          <img src="images/high-performance.png" alt="High Performance" />
          <p>
            Experience high-performance with lightning-fast acceleration, making every drive exhilarating and efficient.
          </p>
        </div>
      </div>
      <div class="infobox">
        <div class="box-content">
          <img src="images/green-economy.png" alt="Green Economy" />
          <p>
            Embrace a green economy with pocket-friendly electric cars, reducing carbon footprint while saving money.
          </p>
        </div>
      </div>
      <div class="infobox">
        <div class="box-content">
          <img src="images/eco-energy.png" alt="Eco Energy" />
          <p>
            Choose eco-energy vehicles for a planet-friendly ride, contributing to sustainability.
          </p>
        </div>
      </div>
    </section>

    <section>
      <h2>Why Autoelegance ?</h2>
      <div class="infobox">
        <div class="box-content">
          <img src="images/car.png" alt="" />
          <p>
            Autoelegance offers top-notch products, providing customers with an exceptional driving experience.
          </p>
        </div>
      </div>
      <div class="infobox">
        <div class="box-content">
          <img src="images/rating_3773000.png" alt="" />
          <p>
            Trust our stellar reviews, ensuring the best-in-class service and satisfaction.
          </p>
        </div>
      </div>
      <div class="infobox">
        <div class="box-content">
          <img src="images/networking_1239608.png" alt="" />
          <p>
            Join a community of enthusiasts, connecting through a shared passion for eco-friendly transportation.
          </p>
        </div>
      </div>
    </section>

    <section>
      <footer>
        <div class="contact-info">
          <h3>Contact Us</h3>
          <p>Email: info@autoelegance.com</p>
          <p>Phone: +1 123-456-7890</p>
          <p>Address: 123 Main St, City, Country</p>
        </div>
        <!-- Google Maps API Integration -->
        <div id="map-frame">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15090.677740708084!2d73.1173691153526!3d18.990200947700366!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7e866de88667f%3A0xc1c5d5badc610f5f!2sPillai%20College%20of%20Engineering%2C%20New%20Panvel%20(Autonomous)!5e0!3m2!1sen!2sin!4v1707241870504!5m2!1sen!2sin"
            width="600"
            height="450"
            style="border: 0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
        <div class="footer-copyright">
          <p>&copy; 2024 AutoElegance. All Rights Reserved.</p>
        </div>
      </footer>
      
    </section>
  </body>
</html>
