<?php 
$table_index = intval(filter_input(INPUT_GET, "table_index"));
$user_id = intval(filter_input(INPUT_GET, "id"));

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
$tblArr[] = "personal_records";


$table_name = $tblArr[$table_index];
// WILL BE THE TABLE NAMES OF THE DATABASE

$sql = "SHOW COLUMNS FROM $table_name";
$get_columns = mysqli_query($conn, $sql);

while ($column_name = mysqli_fetch_array($get_columns)) { // this will get the column headers
    $column_names[] = $column_name['0']; // fields array created here.
}

$user_events_sql = "SELECT * FROM  $table_name WHERE `Runner_id` = $user_id";
$table_query = mysqli_query($conn, $user_events_sql);

while ($event_result = mysqli_fetch_array($table_query)) {
  $event_results[] = $event_result;



  
}
echo count($event_results);


$other_runners_sql = "SELECT Runner_id,	Runner_Time, Finish_Position FROM  $table_name WHERE NOT `Runner_id` = $user_id AND `Result_id` = " . $event_results[0][0] .";";
$other_table_query = mysqli_query($conn, $other_runners_sql);

while ($competitor_result = mysqli_fetch_array($other_table_query)) {
    $competitor_results[] = $competitor_result;
}

print_r($competitor_results[1]);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>MO Racin' <?php echo $_GET["username"] ?> </title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../css/user_home.css">
    <link rel="stylesheet" href="../css/main_styles.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
            <img  src="https://149373412.v2.pressablecdn.com/wp-content/uploads/2019/03/stateICONS-MISSOURI.png" style="padding:0;" width="100" height="100">
            <h3 style="font-family: Impact, Charcoal, sans-serif;">MO Racin'</h3>
            </div>

            <ul class="list-unstyled components">
                <p style="font-weight: bold;">🏃‍♂️ <?php echo $_GET["username"] ?> 🏃‍♂️</p> 
                <!-- Fill with the actual username. -->
                
                <li>
                    <a href="#">My profile</a>
                </li>
                <li>
                    <a href="#">Update my profile</a>
                </li>
                <li>
                    <a href="#">My personal records</a>
                </li>

                <li>
                    <a href="#">Friends</a>
                </li>
                <li class="active">
                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Find events</a>
                    <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li class="drop-down-top-element">
                            <span> Choose a city </span>
                        </li>
                        <?php foreach($cities as $key=>$val) {?>
                            <li>
                                <a href="#"><?php echo $key; ?></a>
                            </li>
                        <?php         
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                        
                    <button style="margin-left: 3%;" type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                </div>
            </nav>
            <h2 style="margin-left: 5%;">USER COMPLETED EVENTS</h2>

            <div class="content-container">
             <!-- Display a new table for each of the user's event results -->
             <!-- e.g. if a user has competed in multiple events then we should see that amount of tables -->
                <?php for ($j = 0; isset($event_results) && $j < count($event_results) ; $j++) { ?>        
                        <?php echo '<table class="table table-light result-table">
                                    <thead style="background-color: #5DADEC;">'?>
                    <!-- DISPLAYING THE COLUMN HEADERS -->
                    <tr>
                        <?php foreach ($column_names as $number => $name) {
                                if ($name !== "Result_id") {
                                    echo "<td class='header-td'><strong>$name</strong></td>";
                                    // don't display the event id because the racename will be shown at the top.
                                }
                            }
                        ?>
                        <td></td>
                        <!-- FOR SPACING PURPOSES -->
                    </tr>

                </thead>
                
                    <tbody>
                        <tr style="background-color: grey;">
                            <?php for ($i = 1; isset($event_results) && $i <= count($event_results); $i++) { ?>
                            <!-- LOOP OVER ALL OF THE event_resultS FROM THE DATABASE -->
                                <td class="event_results">
                                        <!-- ECHO OUT ALL OF THE COLUMN VALUES IN EACH event_result -->
                                        <?php echo $event_results[$j][$i];?>
                                </td>
                                
                            <?php } ?>
                            <td class="buttons">
                                        <button>ADD FRIEND</button>
                                        <button style="margin-left: 1em;">VIEW PERSONAL RECORDS</button>
                                        <button style="margin-left: 1em;">VIEW RUNNER'S EVENTS</button>
                            </td>
                        </tr>
                        
                            <?php for ($k = 0; isset($competitor_results) && $k < count($competitor_results); $k++) { ?>
                                <tr style="background-color: white;">
                            <!-- LOOP OVER ALL OF THE event_resultS FROM THE DATABASE -->
                                <?php for ($z = 0; isset($event_results) && $z < count($event_results); $z++) { ?>
                                    <td class="event_results">
                                        <!-- ECHO OUT ALL OF THE COLUMN VALUES IN EACH event_result -->
                                        <?php echo $competitor_results[$k][$z];?>
                                </td>

                                <?php } ?>
                                <td class="buttons">
                                        <button>ADD FRIEND</button>
                                        <button style="margin-left: 1em;">VIEW PERSONAL RECORDS</button>
                                        <button style="margin-left: 1em;">VIEW RUNNER'S EVENTS</button>
                                </td>
                            <?php } ?>



                 <?php echo '</tbody>
                             </table> '
                ?>
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