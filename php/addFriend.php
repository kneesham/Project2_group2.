<?php 
$user_to_add = intval(filter_input(INPUT_POST, "userToAdd"));
$user_id = intval(filter_input(INPUT_POST, "logedInUser"));

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "project2";
$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname) or die("Connection failed");

$check_user_exists = "SELECT * 
                    FROM `has_friends` h
                    WHERE h.`user_id` = $user_id
                    AND h.`friend_id` = $user_to_add;";

$table_of_friends = mysqli_query($conn, $check_user_exists);

if( mysqli_fetch_array($table_of_friends) === null ) {
    // if it does not return an sql object then insert the value && count(mysqli_fetch_array($table_of_friends)) !== 1
    echo "you are adding a friend! " . "adding: $user_to_add to $user_id's friend list!!!!";
    $add_friend_sql = "INSERT into `has_friends` VALUES ($user_id,$user_to_add)";
    mysqli_query($conn, $add_friend_sql);
}
else {
    echo "This user is already in your friend's list.";
}


mysqli_close($conn);
?>