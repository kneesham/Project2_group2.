<?php
// File Creator: Ted Nesham
// Last Edited: 05-01-2020

$user_id = intval(filter_input(INPUT_GET, "view"));

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "project2";
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname) or die("Connection failed");
// connection to the database.

$json_file = "../js/cities.json";
$city_json = file_get_contents($json_file);
$cities = json_decode($city_json);
// getting all of the city data, key for CITIES is 'city':'../php/events.php?city="cityname"

$tblArr = array();
$tblArr[] = "event_results";

$table_name = $tblArr[0];
// WILL BE THE TABLE NAMES OF THE DATABASE

$sql = "SHOW COLUMNS FROM $table_name;";
$get_columns = mysqli_query($conn, $sql);

while ($column_name = mysqli_fetch_array($get_columns)) { // this will get the column headers
    $column_names[] = $column_name['0']; // fields array created here.
}

$user_events_sql = "SELECT * 
                    FROM  $table_name t
                    WHERE t.`Runner_id` = $user_id
                    and t.`Result_id` IN
                        (SELECT Result_id
                         FROM event_results 
                        );";

$table_query = mysqli_query($conn, $user_events_sql);

$events = array();
$events_dates = array();
// this will be all of the evets ran by the user.

$count = 0;

while ($event_result = mysqli_fetch_array($table_query)) {
  $event_results[] = $event_result;

  if (!in_array($event_results[$count][0], $events)) {
      // push the user's event into the event array.
    array_push($events, $event_results[$count][0]);
    
  }
  $count++;
}

for ($j = 0; isset($events) && $j < count($events) ; $j++) {

    $user_events_sql = "SELECT `Race_Name` , `Race_Date` 
    FROM  `event`
    WHERE `Event_id` = $events[$j]
    ORDER BY `Race_Date` DESC;";
    
    $get_name = mysqli_query($conn, $user_events_sql);
    $event_data = mysqli_fetch_array($get_name);
    
    $events[$j] = str_replace("!", "", $event_data[0]);
    array_push($events_dates, $event_data[1]);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>MO Racin' </title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../css/user_home.css">
    <link rel="stylesheet" href="../css/main_styles.css">

    <!-- For Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
    <script src="../js/chart.js"> </script>
</head>

<body onload="<?php echo "createChart(" . "''" . ", " ."['" . implode("', '", $events_dates) . "']" . ")"; ?> "> 
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
            <img  src="https://149373412.v2.pressablecdn.com/wp-content/uploads/2019/03/stateICONS-MISSOURI.png" style="padding:0;" width="100" height="100">
            <h3 style="font-family: Impact, Charcoal, sans-serif;">MO Racin'</h3>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="javascript:history.back()">User Home Page</a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                </div>
            </nav>
            <h2 style="margin-left: 5%;">USER COMPLETED EVENTS</h2>

            <label id="date-label">viewing races for:</label>
            <select class="btn btn-primary" id="dateSelector"></select>
            <!-- for the selection of the year for the graph -->

            <canvas id="myRaceChart" width="400" height="100"></canvas>
            <!-- This is the graph for how many races the user has competed in -->

            <div class="content-container">
             <!-- Display a new table for each of the user's event results -->
             <!-- e.g. if a user has competed in multiple events then we should see that amount of tables -->
                <?php for ($j = 0; isset($events) && $j < count($events) ; $j++) { ?>  

                        <?php
                             echo "<h3 class='table-name'>" . $events[$j] .  "</h3>
                                    <table class='table table-light result-table'>
                                    <thead style='background-color: #5DADEC;'>"; 
                        ?>
                    <!-- DISPLAYING THE COLUMN HEADERS -->
                    <tr>
                        <?php foreach ($column_names as $number => $name) {
                                if ($name !== "Result_id") {
                                    echo "<td class='header-td'><strong>$name</strong></td>";
                                    // don't display the event id because the racename will be shown at the top.
                                }
                            }
                        ?>
                        <td> <?php echo "<strong> DATE </strong>"?></td>
                        
                        <!-- FOR SPACING PURPOSES -->
                    </tr>

                </thead>
                    <tbody>
                        <tr style="background-color: #ceebea;">
                            <?php for ($i = 1; isset($column_names) && $i < count($column_names); $i++) { ?>
                            <!-- LOOP OVER ALL OF THE event_resultS FROM THE DATABASE -->
                                <td class="event_results">
                                        <!-- ECHO OUT ALL OF THE COLUMN VALUES IN EACH event_result -->
                                        <?php echo $event_results[$j][$i];?>
                                </td>
                                
                            <?php } ?>
                                <td> <?php echo "<strong>( $events_dates[$j] )</strong>"?></td>
                        </tr>
                 <?php echo '</tbody>
                             </table> ';?>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript" src="../js/sidebar.js"></script>
    <!-- FOR the sidebar toggle -->
    </body>
</html>

<?php  
mysqli_close($conn);
?> 
