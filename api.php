<?php
header('content-type:text/html;charset=utf-8');
mysql_query('set names utf8');
		$username =  $_COOKIE['user'];
      	$day = $_POST['day-info'];  
        $time = $_POST['movie-info'];
        $seat = $_POST['seat-info'];
        $total = $_POST['zong'];
		$name = $_POST['name-info'];
        echo $day + $time + $total+ $name;
$con = mysql_connect("localhost:3306","root","");
if (!$con)
 {
 die('Could not connect: ' . mysql_error());
 }
mysql_select_db("movie_info", $con);
mysql_query("INSERT INTO buy_info (username,day,showing,seat,total,name) 
VALUES ('$username','$day', '$time','$seat','$total','$name')");
mysql_close($con);
?>