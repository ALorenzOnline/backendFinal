<?php

$db1=mysqli_connect("localhost","root","password","profile");
			if (!mysqli_ping($db1)) 
			{
		    		echo 'Lost connection, exiting after query #1';
		    		exit;
			}



?>
