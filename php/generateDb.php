<?php
function queryToTest($connection, $query_string){
    // USED TO SIMPLIFY CODE PERFORMING ERROR CHECKING AT THE SAME TIME
    // RELOAD THE THE PAGE WITH ONLY THE TABLE INDEX FROM WHERE IT LEFT OFF.
    if (mysqli_query($connection, $query_string) === TRUE) {
        echo "$query_string";
        echo "successfull";
    } else {
        echo "Error: in " . $query_string . "<br>";
    }
}

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "project2";
$db = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);

$query = file_get_contents("../sql/create_db.sql");

$stmt = $db->prepare($query);

if ($stmt->execute())
     echo "Success";
else 
     echo "Fail";



$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname) or die("Connection failed");
// connection to the database.




$isSubmitted = $_GET["submitted"];
$formJson = $_POST["json-from-js"];

$formData = json_decode($formJson);

if($isSubmitted){
    // $add_row_sql = "INSERT INTO `users` (`Id`,`Name`,`Num_races`,`City`, `email`, `password`) VALUES
    // (1,'test', 0,'St. Louis','zach@asdafasdfasdfadsfl.com', 'password');";
    $add_row_sql = "INSERT INTO `users` (`Id`,`Name`,`Num_races`,`City`, `email`, `password`) VALUES " ;
    for ($i = 0; $i < count($formData); $i++) { 
    //    echo "<p>" . $formData[$i]->Id . "   " . $formData[$i]->FullName . "</p>";
       $add_row_sql .=  "( " . $formData[$i]->Id . ", '" . $formData[$i]->FullName . "', " 
                            . $formData[$i]->NumRaces . ", '" . $formData[$i]->City . "',  "
                            . " '" . $formData[$i]->Email . "'," .  " '" . $formData[$i]->UserPass . "' ";

        if ($i - count($formData) === - 1 ) {
            $add_row_sql .= ");";
        }
        else {
            $add_row_sql .= "), ";
        }
        
        
    }
    echo "$add_row_sql";


    queryToTest($conn, $add_row_sql);
}


?> 
<!DOCTYPE html>
    <head>
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if(!$isSubmitted) echo '<script type="module" src="../js/generateUsers.js"></script>'?> 
        
    </head>
    <body>
        <h1>BY LOADING THIS PAGE YOU WILL HAVE POPULATED THE DATABASE WITH DATA</h1>
        <?php
            if (!$isSubmitted){
                echo  '<form id="myJsonForm" action="./generateDb.php?submitted=true" method="POST">
                <textarea name="json-from-js" id="textArea" cols="100" rows="30"></textarea>
                </form>';
            } 
            else {
                // for ($i=0; $i < count($formData); $i++) { 
                //     foreach($formData[$i] as $child) {
                //         echo "<p>$child </p>";
                //      }
                // }
            }
        ?>
        
    </body>
</html>