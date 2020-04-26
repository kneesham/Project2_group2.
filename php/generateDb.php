<?php
function queryToTest($connection, $query_string){
    // USED TO SIMPLIFY CODE PERFORMING ERROR CHECKING AT THE SAME TIME
    // RELOAD THE THE PAGE WITH ONLY THE TABLE INDEX FROM WHERE IT LEFT OFF.
    if (mysqli_query($connection, $query_string) === TRUE) {
        // echo "$query_string";
        echo "successfull:    ";
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
     echo "Success WOOOOOOOOOOOOOOOOOO:    ";
else 
     echo "Fail";



$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname) or die("Connection failed");
// connection to the database.


$isSubmitted = $_GET["submitted"];
$formJson = $_POST["json-from-js"];

$formJson1 = $_POST["json-from-js1"];
$formJson2 = $_POST["json-from-js2"];


$formData1 = json_decode($formJson);



if($isSubmitted){
    // $add_row_sql = "INSERT INTO `users` (`Id`,`Name`,`Num_races`,`City`, `email`, `password`) VALUES
    // (1,'test', 0,'St. Louis','zach@asdafasdfasdfadsfl.com', 'password');";
    $add_row_sql = "INSERT INTO `users` (`Id`,`Name`,`Num_races`,`City`, `email`, `password`) VALUES " ;
    for ($i = 0; $i < count($formData1); $i++) { 

       $add_row_sql .=  "( " . $formData1[$i]->Id . ", '" . $formData1[$i]->FullName . "', " 
                            . $formData1[$i]->NumRaces . ", '" . $formData1[$i]->City . "',  "
                            . " '" . $formData1[$i]->Email . "'," .  " '" . $formData1[$i]->UserPass . "' ";

        if ($i - count($formData1) === - 1 ) {
            $add_row_sql .= ");";
        }
        else {
            $add_row_sql .= "), ";
        }   
    }

    queryToTest($conn, $add_row_sql);

    $formData3 = json_decode($formJson2);
    $add_event_sql = "INSERT INTO `event` (`Event_id`, `Race_Name`, `Race_Location`, `Race_Date`, `Race_Type`, `Distance`) VALUES ";


    for ($i = 0; $i < count($formData3); $i++) { 

        $add_event_sql .=  "( " . $formData3[$i]->EventId . ", '" . $formData3[$i]->RaceName . "', '" 
                             . $formData3[$i]->RaceLocation . "', '" . $formData3[$i]->RaceDate . "',  "
                             . " '" . $formData3[$i]->RaceType . "'," .  " " . $formData3[$i]->RaceDistance . " ";
 
         if ($i - count($formData3) === - 1 ) {
             $add_event_sql .= ");";
         }
         else {
             $add_event_sql .= "), ";
         }   
     }

     queryToTest($conn, $add_event_sql);


    $formData2 = json_decode($formJson1);
    $add_eventRes_sql = "INSERT INTO `event_results` (`Result_id`, `Runner_id`, `Runner_Time`, `Finish_Position`) VALUES ";

    for ($i = 0; $i < count($formData2); $i++) { 

        $add_eventRes_sql .=  "( " . $formData2[$i]->ResultId . ", " . $formData2[$i]->RunnerId . ", '" 
                             . $formData2[$i]->time . "', " . $formData2[$i]->place . "  ";
 
         if ($i - count($formData2) === - 1 ) {
             $add_eventRes_sql .= ");";
         }
         else {
             $add_eventRes_sql .= "), ";
         }   
     }


    // echo "$add_event_sql";

    queryToTest($conn, $add_eventRes_sql);


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
                <textarea name="json-from-js" id="textArea" cols="200" rows="30"></textarea>
                <textarea name="json-from-js1" id="textArea1" cols="200" rows="30"></textarea>
                <textarea name="json-from-js2" id="textArea2" cols="200" rows="30"></textarea>
                </form>';
            } 
        ?>
    </body>
</html>