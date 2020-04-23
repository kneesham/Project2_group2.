<?php

// ABSOLUTLY NEVER USE REAL PASSWORDS IN THIS FORM, IT IS NOT EVEN SLIGHTLY SECURE

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "project2";


$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname) or die("Connection failed");


if ( isset( $_POST['submit'] ) ) { // check if the email and password exist in the database.

    $user_email = $_POST['user_email']; $password = $_POST['user_password']; // display the results
    $sql = "SELECT Id, name, email, `password` FROM users WHERE email = '$user_email' AND password = '$password'";

    $result = mysqli_query($conn, $sql);
    $result_to_array = mysqli_fetch_array($result);
   
    if ($result_to_array){
        // reroute\
        // print_r($result_to_array);

        header("Location: ./php/user_home.php?id=$result_to_array[0]&username=$result_to_array[1]&table_index=0");
    }
    else {
        //redirect to the signup page that handles creating a user.
        header("Location: ./php/signup.php");
    }
}

?>
<!DOCTYPE html>
<head>
   <meta charset="utf-8">
   <title>Login Page</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="../css/signup.css" rel="stylesheet">
</head>
<body class="text-center">
   <!DOCTYPE html>
   <html lang="en">
      <head>
         <meta charset="utf-8">
         <meta name="description" content="This Is a page practice about HTML 5 inputs & forms">
         <title>Input & Forms</title>
      </head>

      <main>
         <div class="loginBox">
         <img   style="margin-left:50%; margin: 0; width: 200px;" src="https://149373412.v2.pressablecdn.com/wp-content/uploads/2019/03/stateICONS-MISSOURI.png" >
         <h1 style=" color:white; font-family: Impact, Charcoal, sans-serif; margin: 0;">MO Racin'</h1>
         <br>
            <h2>Sign Up</h2>
            <form>
               <p>First Name</p>
               <input type="text" name="fname" placeholder="Firstname">
               <p>Last Name</p>
               <input type="text" name="lname" placeholder="Lastname">
               <p>E-mail Address</p>
               <input type="email" name="email" placeholder="e-mail">
               <p>Password
               <p>
                  <input type="Password" name="pword1" placeholder="Create Password">
               <p>Re-enter Password</p>
               <input type="password" name="pword2" Placeholder="Confirm Password">
               <input type="Submit" name="sbmt">
               <p>Already have an account? <a href="../index.php">Sign In</a></p>
            </form>
         </div>
      </main>
      </body>
   </html>