
<?php
/*This Runs as a service that will constantly wait for
@@new users to register, and when that happens this will run
@@This will update all of the tables needed for the first time
*/
include "dbConnect.php";
include "functions.php";
include "mongoconnect.php";


while(true){
	$date= date('m-d-y');
	$db1=mysqli_connect("localhost","root","password","profile");
	
	//get the number of rows in the table
	$numrows=mysqli_num_rows(mysqli_query($db1,'select * from tbluser;'));
	
	
	
	
	/*echo $getLastDate['lastUpdated'];
	if($getLastDate['lastUpdated']==$date){
		echo 'dates match';	
	}*/
		/*Reads through the tbluser table by row. 
		@@Then Grabs the selected row's steamid and date
		@@Then Checks the date, if it is null then it will		
		@@add the users friends to the userstable, and the tblusers users gameslist to mongo		
		*/
		for($i=0;$i<$numrows;$i++){
		$getLastDate=mysqli_query($db1,"select lastUpdated from tbluser limit $i,1;");//select 1 row at index i
		$userdate= mysqli_fetch_assoc($getLastDate);
		//echo $userdate["lastUpdated"];
		$fetchid=mysqli_query($db1,"select steamid from tbluser limit $i,1;");		
		$sid=mysqli_fetch_assoc($fetchid);
		$steamid=$sid["steamid"];
		if($userdate["lastUpdated"] == null){
			if(mysqli_fetch_assoc($getLastDate) != $date){
				echo 'dates dont match';
				$newDate = "UPDATE tbluser SET lastUpdated='$date' WHERE steamid='$steamid'";
				$sendquery=mysqli_query($db1,$newDate);

				addFriendsToUsers($steamid);
				sendMongo($steamid,2);
			}//end if1
		}//end if0
	}//end for
}//end while
?>
