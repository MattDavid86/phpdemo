<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];
$_SESSION['position'] = $_POST['position'];


//Set the variables
$first_name =$_POST['firstname'];
$last_name = $_POST['lastname'];
$position = $_POST['position'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$hash =  md5( rand(0,1000) );
      
// Check if user with that email already exists
$query = "SELECT * FROM users WHERE email='$email'";
$safecheck = $connection->prepare($query);
$safecheck->execute(['email' =>$email]);
$result = $safecheck->rowCount(); 

// Check to see if the user exists
if ( $result > 0 ) {    
    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");    
}
else {
    $insert = "INSERT INTO users (first_name, last_name, email, password, hash) " 
            . "VALUES ('$first_name','$last_name','$email','$password', '$hash')";

    // Add user to the database
		try{
			$safeinsert = $connection->prepare($insert);
			$safeinsert->execute();
			$resultInsert = $safeinsert->rowCount();
			if($resultInsert>0)
			{
				$_SESSION['active'] = 1; //0 until user activates their account with verify.php
				$_SESSION['logged_in'] = true; // So we know the user has logged in
				$_SESSION['message'] =
						
						 "Confirmation link has been sent to $email, please verify
						 your account by clicking on the link in the message!";

				// Send registration confirmation link (verify.php)
				// $to      = $email;
				// $subject = 'Account Verification';
				// $message_body = '
				// Hello '.$first_name.',
				// Thank you for signing up!
				// Please click this link to activate your account:
				// http://localhost/login-system/verify.php?email='.$email.'&hash='.$hash;  
				// mail( $to, $subject, $message_body );

				header("location: profile.php"); 
			}
			else {
				$_SESSION['message'] = 'Registration failed!';
				header("location: error.php");
			}
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}


}