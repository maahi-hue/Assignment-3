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

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $sql = sprintf("SELECT * FROM user_data
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();

    if ($user) {
        
      if (password_verify($_POST["password"], $user["password_hash"])) {
          
          session_start();
          
          session_regenerate_id();
          
          $_SESSION["user_id"] = $user["id"];
          
          header("Location: homepage.php");
          exit;
      }
    }
  
    $is_invalid = true;
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Form</title>
    <link rel="stylesheet" href="login.css" />
  </head>
  <body>
    <?php require 'partials/_nav.php'?>
    <div class="wrapper">
      
     <?php if ($is_invalid): ?>
        <em>Invalid login</em>
     <?php endif; ?>

      <form method="post" id="loginForm">
        <h1>Login</h1>
        <div class="input-box">
          <input type="text" placeholder="Username" id="username" name="userName" required />
        </div>

        <div class="input-box">
         <input type="email" placeholder="Email" id="email" name="email" required 
         value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"/>
        </div>

        <div class="input-box">
          <input
            type="password"
            placeholder="Password"
            name="password"
            required
          />
        </div>

        <div class="remember-forgot">
          <label><input type="checkbox" />Remember me</label>
          <a href="#" class="href">Forgot password?</a>
        </div>

        <button type="submit" class="btn">Login</button>
        <p>
          Don't have an account?
          <a style="color: white" href="../portfolio1/registration.php" class="href"
            >Register</a
          >
        </p>
      </form>
    </div>

    
  </body>
</html>