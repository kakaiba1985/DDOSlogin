<?php
date_default_timezone_set("Asia/Manila");
$dbhost = '195.35.10.163';
$dbuser = 'u844717466_thunderbolt';
$dbpass = 'kakaibA123A';
$dbname = 'u844717466_thunder';
header('Content-Type: application/json');
//database connection
$connection = new MySQLi($dbhost, $dbuser, $dbpass, $dbname);

//Check connection
if ($connection->connect_errno)
{
    printf("Failed to connect to database");
    exit();
} 

function calc_time($seconds)
{
    $hours = 0;
    $minutes = 0;
    $days = (int)($seconds / 86400);
    $seconds -= ($days * 86400);
    if ($seconds)
    {
        $hours = (int)($seconds / 3600);
        $seconds -= ($hours * 3600);
    }
    if ($seconds)
    {
        $minutes = (int)($seconds / 60);
        $seconds -= ($minutes * 60);
    }
    $time = array(
        'days' => (int)$days,
        'hours' => (int)$hours,
        'minutes' => (int)$minutes,
        'seconds' => (int)$seconds
    );
    return $time;
}
if (isset($_GET['username'], $_GET['password']))
{
$userid = $_GET['username'];
$userpass = $_GET['password'];


//$auth1 = $connection->query("SELECT user_name,user_pass FROM users WHERE user_name='$userid' AND auth_vpn=md5('$userpass')");
    $get_result = $connection->query("SELECT COUNT(*) FROM users where user_name='$userid' AND auth_vpn=md5('$userpass')")->fetch_array(MYSQLI_NUM);
     if ($get_result[0] != 0){
        $json_data = array(
                "auth" => true,
                "device_match" => true
            );
			 echo json_encode($json_data, JSON_PRETTY_PRINT);
    }
    else
    {
        $json_data = array(
            "auth" => false,
            "device_match" => 'none'
        );
        echo json_encode($json_data, JSON_PRETTY_PRINT);
    
    }
 
}
else
{
   $json_data = array(
                "auth" => true,
                "device_match" => true
            );
			 echo json_encode($json_data, JSON_PRETTY_PRINT);

}
$connection->close();

?>
