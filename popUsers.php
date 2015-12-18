<?php
/*This Runs as a service that will constantly wait for
@@new users to register, and when that happens this will run
@@This will update all of the tables needed for the first time
*/
include "dbConnect.php";
include "functions.php";


while(true){
	$date= date('m-d-y');
	$db1=mysqli_connect("localhost","root","password","profile");
	$getLastDate=mysqli_fetch_assoc(mysqli_query($db1,'select lastUpdated,steamid from tbluser order by steamid desc limit 1;'));
	/*echo $getLastDate['lastUpdated'];
	if($getLastDate['lastUpdated']==$date){
		echo 'dates match';	
	}*/
	if($getLastDate!=null){
		if($getLastDate['lastUpdated'] != $date){
			echo 'dates dont match';
			$getLastIdEntry='select steamid from tbluser order by steamid desc limit 1;';
			$sendquery=mysqli_query($db1,$getLastIdEntry);
			$id=mysqli_fetch_assoc($sendquery);
			$steamid = $id["steamid"];
			$newDate = "UPDATE tbluser SET lastUpdated='$date' WHERE steamid='$steamid'";
			$sendquery=mysqli_query($db1,$newDate);

			addFriendsToUsers($steamid);
		}
	}
}
?>
