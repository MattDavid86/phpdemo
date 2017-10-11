<?php
/* User login process, checks if user exists and password is correct */

// Escape email to protect against SQL injections
$email = $_POST['email'];
$query = "SELECT * FROM users WHERE email='$email'";

$safecheck = $connection->prepare($query);
$safecheck->execute();
$result = $safecheck->rowCount(); 
print_r($result);

if ( $result > 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist!";
    header("location: error.php");
}
else { // User exists
    // $user = $connection->fetch();

    if ( password_verify($_POST['password'], $user['password']) ) {
        
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['position'] = $user['position'];
        $_SESSION['active'] = $user['active'];
        
        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;

        header("location: profile.php");
    }
    else {
        $_SESSION['message'] = "You have entered wrong password, try again!";
        header("location: error.php");
    }
}

