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
        print_r($result_to_array);

        header("Location: ./php/user_home.php?id=$result_to_array[0]&username=$result_to_array[1]&table_index=0");
    }
    else {
        echo "it was false";
    }
}

?>

<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Login Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link href="./css/login.css" rel="stylesheet">
        <script type="module" src="js/generateUsers.js"></script>
    </head>
    <body class="text-center">

    <div id="signin-container">
        <form class="form-signin" method="post">
            <img  src="https://149373412.v2.pressablecdn.com/wp-content/uploads/2019/03/stateICONS-MISSOURI.png" style="padding:0;" width="100" height="100">
            <h3 style="font-family: Impact, Charcoal, sans-serif;">MO Racin'</h3>
            <br>
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="user_email">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="user_password">
            <div class="checkbox mb-3">
                <label>
                <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">© 2020</p>
        </form>
    </div>


    </body>
</html>