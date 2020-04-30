<?php 
$table_index = intval(filter_input(INPUT_GET, "table_index"));

// might be useful to know who is viewing the race so they don't see races they already signed up for
$user_id = intval(filter_input(INPUT_GET, "id"));
$city_value= intval(filter_input(INPUT_GET, "cityValue"));


// echo "city value:"+$city_value;


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

// ***ADDED  event table here******* 
$tblArr[] = "event";

if(isset($_POST['racesubmit'])){
    $getcity = $_POST['citySelector'];
    // echo $getcity;
    
    $getyear = $_POST['yearSelector'];
    // echo $getyear;
    
    $getmonth = $_POST['monthSelector'];
    // echo $getmonth;
    
    $getday = $_POST['daySelector'];
    // echo $getday;

    $table_name = $tblArr[$table_index];
    // WILL BE THE TABLE NAMES OF THE DATABASE
    
    $sql = "SHOW COLUMNS FROM $table_name;";
    $get_columns = mysqli_query($conn, $sql);
    
    while ($column_name = mysqli_fetch_array($get_columns)) { // this will get the column headers
        $column_names[] = $column_name['0']; // fields array created here.
    }
    // HERE IS MY QUERY FOR ST LOUIS RACES
    $date1 = strftime("%F", strtotime($getyear."-".$getmonth."-".$getday));

    $user_events_sql = "SELECT * 
                        FROM  `event` t
                        WHERE t.`Race_Date` >=  $date1 && t.`Race_Location` = '$getcity' && TIMESTAMPDIFF(DAY, CURDATE(),t.`Race_Date` )  >= 0;";
    
    $table_query = mysqli_query($conn, $user_events_sql);

    while ($row = mysqli_fetch_array($table_query)) { /// MYSQL_ASSOC DOES NOT WORK REMove this also just use mysqli_fetch_array its much newer.
        $rows[] = $row;
    }
}		
else {    
    $table_name = $tblArr[$table_index];
    
    $sql = "SHOW COLUMNS FROM $table_name;";
    $get_columns = mysqli_query($conn, $sql);

    while ($column_name = mysqli_fetch_array($get_columns)) { // this will get the column headers
        $column_names[] = $column_name['0']; // fields array created here.
    }
}
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
    <!-- <script src="../js/stlouis.js"> </script> -->
 <!-- <script src="../js/stlouis.js"> </script> -->


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
                    <a href='<?php echo  "./user_home.php?id= " . $_GET['id'] . "&username="  . $_GET['username']  . "&table_index=0"  ?>' >My profile</a>
                </li>
                <li>
                    <a href="./selectedUserPr.php">My personal records</a>
                </li>

                <li>
                    <a href="#">Friends</a>
                </li>
        </nav>

        <!-- Page Content  -->
        <div id="content">

        <form method="POST">
            <h2 style="margin-left: 5%;"> FUTURE EVENTS</h2>
			
			<label id="date-label">PICK YOUR CITY:</label>
            <select class="btn btn-primary" id="citySelector" name="citySelector"></select>
            <!-- for the selection of the city for table -->
			
			  <label id="date-label">PICK YOUR YEAR:</label>
            <select class="btn btn-primary" id="yearSelector" name="yearSelector"></select>
            <!-- for the selection of the year for the table -->

			<label id="date-label">PICK YOUR MONTH:</label>
            <select class="btn btn-primary" id="monthSelector" name="monthSelector"></select>
            <!-- for the selection of the month for the table -->
			
			 <label id="date-label">PICK YOUR DAY:</label>
            <select class="btn btn-primary" id="daySelector" name="daySelector" ></select>
            <!-- for the selection of the day for the table -->

          <!-- SUBMIT BUTTON -->
		  <input type="submit" name="racesubmit" value="get selected races" />	
		</form>

    <?php if (isset($_POST['racesubmit'])) {  ?>

            <table class="table table-light">
            <thead style="background-color: #93C47D;">
                <!-- DISPLAYING THE COLUMN HEADERS -->
                <tr>
                    <?php foreach ($column_names as $number => $name) {
                            if($number !== 0){
                                echo "<td class='header-td'><strong>$name</strong></td>";
                            }
                        }
                    ?>

                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; isset($rows) && $i < count($rows); $i++) { ?>
                    <!-- LOOP OVER ALL OF THE ROWS FROM THE DATABASE -->
                    <tr class="rows">
                        <?php for ($j=1; isset($column_names) && $j < count($column_names) ; $j++) { ?>
                            <!-- ECHO OUT ALL OF THE COLUMN VALUES IN EACH ROW -->
                            <td><?php echo $rows[$i][$j];?></td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                    <tr class="button-row">
                        <?php for ($i = 1; $i < count($column_names) ; $i++) { ?>
                        <!-- LOOP FOR THE ASCENDING AND DECENDING BUTTONS -->
                            <td>
                                <button type="button">ASC</button>
                                    <button type="button"> DEC</button>
                            </td>
                        <?php } ?>
                    </tr>
                </tbody>
            </table>

<?php } ?>

            </div> <!-- close id content-->
        </div> <!-- close wrapper>-->
      
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

    <script type="text/javascript" src="../js/sidebar.js"></script>
    <script src="../js/stlouis.js"> </script>
    <!-- FOR the sidebar toggle -->
</body>

</html>
