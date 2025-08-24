<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if (isset($_POST['changePassword'])) {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];

    if ($user['password'] == $oldPassword) {

        $updateSql = "UPDATE users SET password = '$newPassword' WHERE username = '$username'";
        $conn->query($updateSql);
        $passwordChangeSuccess = "Password changed successfully.";
    } else {
        $passwordChangeError = "Incorrect old password.";
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
    
    <section>
    
    <h2>Welcome, <?php echo $user['username']; ?>!</h2>

    <h3>Profile Details</h3>
    <p>Username: <?php echo $user['username']; ?></p>

    <h3>Change Password</h3>
    <form method="post" action="">
        <label for="oldPassword">Old Password:</label>
        <input type="password" id="oldPassword" name="oldPassword" required>
        <br>
        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>
        <br>
        <button type="submit" name="changePassword">Change Password</button>
        <?php if (isset($passwordChangeSuccess)) echo "<p>$passwordChangeSuccess</p>"; ?>
        <?php if (isset($passwordChangeError)) echo "<p>$passwordChangeError</p>"; ?>
    </form>

    <form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>
        
    </section>

    <footer>
        &copy; Devloped by Kunal.P.Sangurmath for CS637.
    </footer>

</body>

</html>



