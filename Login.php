<?php
session_start();

include 'db_connection.php';

$username = '';
$password = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['register'])) {
        $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
        $newPassword = $_POST['password'];
        $checkUsernameQuery = "SELECT * FROM users WHERE username = '$newUsername'";
        $checkResult = $conn->query($checkUsernameQuery);

        if ($checkResult->num_rows > 0) {
            $message = 'Username already exists. Choose a different username.';
        } else {

            $insertQuery = "INSERT INTO users (username, password) VALUES ('$newUsername', '$newPassword')";
            if ($conn->query($insertQuery)) {
                $message = 'Registration complete. You can now login.';
            } else {
                $message = 'Registration failed. Please try again.';
            }
        }
    } else {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password'];
        $loginQuery = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($loginQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['password'] === $password) {
                $_SESSION['username'] = $username;
                header('Location: profile.php');
                exit();
            } else {
                $message = 'Incorrect password.';
            }
        } else {
            $message = 'User not found.';
        }
    }
}
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="Style.css">
    <style>
    section table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px; 
}


section ul {
    list-style: none;
    padding: 0;
}

section li {
    margin-bottom: 10px;
}

section strong {
    display: inline-block;
    width: 120px; 
    font-weight: bold;
}

section {
    line-height: 1.6;
}

section a {
    color: #007bff;
    text-decoration: none;
}

section a:hover {
    text-decoration: underline;
}

    </style>
</head>

<body>
    <header>
        <h1>Geo-Exploration</h1>
    </header>
    
    <nav>
        <a href="Main.html">Home</a>
        <a href="Minerals.php">Minerals</a>
        <a href="search.php">Minerals Composition Search</a>
        <a href="site.php">Site Details</a>
        <a href="commod.php">Seconday Minerals Details</a>
        <a href="Login.php">Login</a>
        <a href="About.html">About</a>
    </nav>
    
    <section>
    
      <h2>User Authentication</h2>

     <h1>Login</h1>

    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
        
<?php echo $message; ?>
        
    <h2>Register</h2>
    <form method="post" action="">
        <label for="newUsername">New Username:</label>
        <input type="text" id="newUsername" name="username" required>
        <br>
        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="password" required>
        <br>
        <input type="submit" name="register" value="Register">
    </form>   
        
    </section>

    <footer>
        &copy; Devloped by Kunal.P.Sangurmath for CS637.
    </footer>

</body>

</html>
