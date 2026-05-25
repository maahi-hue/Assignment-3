<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration Form</title>
    <link rel="stylesheet" href="registration.css" />
    <style>
      /* Floating Alert Styles */
      .alert {
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        width: 90%;
        max-width: 500px;
        padding: 15px;
        border-radius: 5px;
        text-align: center;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        animation: fadeInOut 5s ease-in-out;
      }

      .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
      }

      .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
      }

      @keyframes fadeInOut {
        0% {
          opacity: 0;
          transform: translate(-50%, -20px);
        }
        10% {
          opacity: 1;
          transform: translate(-50%, 0);
        }
        90% {
          opacity: 1;
          transform: translate(-50%, 0);
        }
        100% {
          opacity: 0;
          transform: translate(-50%, -20px);
        }
      }
    </style>
  </head>
  <body>
    <?php
    // Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'real_estate';

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    session_start(); // Start session to retrieve messages
    ?>

    <!-- Floating Alerts -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success">
        <?php 
          echo $_SESSION['success']; 
          unset($_SESSION['success']); // Clear the success message
        ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-error">
        <?php 
          echo $_SESSION['error']; 
          unset($_SESSION['error']); // Clear the error message
        ?>
      </div>
    <?php endif; ?>

    <div class="wrapper">
      <form id="registration" action="process-registration.php" method="post" novalidate>
        <h1>Registration</h1>
        <!-- Form Fields -->
        <div class="input-box">
          <div class="input-field">
            <input type="text" placeholder="Full Name" id="fullname" name="fullname" required />
          </div>
          <div class="input-field">
            <input type="text" placeholder="Username" id="username" name="username" required />
          </div>
        </div>

        <div class="input-box">
          <div class="input-field">
            <input type="email" placeholder="Email" id="email" name="email" required />
          </div>
          <div class="input-field">
            <input type="number" placeholder="Phone Number" id="number" name="number" required />
          </div>
        </div>

        <div class="input-box">
          <div class="input-field">
            <input type="password" placeholder="Password" id="password" name="password" required />
          </div>
          <div class="input-field">
            <input type="password" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" required />
          </div>
        </div>

        <p style="text-align: center">
          <input type="checkbox" id="terms" name="terms" required />
          I agree to the <a href="#" style="color: white; text-decoration: underline;">terms and conditions</a>.
        </p>

        <button type="submit" class="btn">Register</button>

        <p style="text-align: center">
          Already have an account?
          <a style="color: white" href="login.php">Login</a>
        </p>
      </form>
    </div>
  </body>
</html>