
<?php
# Logging in with Steam accounts requires setting special identity, so this example shows how to do it.
# http://steamcommunity.com/dev/
require 'openid.php';
require 'functions.php';
require 'testRabbitMQClient.php';
/*
#connects to my database and checks to make sure its connected.
*/
//$apikey="key";
try {
   

  
   
 
 $openid = new LightOpenID('localhost');
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }

?>
<h1>Hey ____ thank you for using FOF.com</h1>

<br>
<?php 
	//showFriends(xxxxxxxxxxxxxxxxx); 
	//calls function from testRabbitMQClient.php	
	
	//send is a function from testRabbitMQClient.php which is not working	
	//send("friends");

?>
<form action="?login" method="post">
    <input type="image" src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png">
</form>
<?php

} elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()) {
                $id = $openid->identity;
                // identity is something like: http://steamcommunity.com/openid/id/76561197994761333
                // we only care about the unique account ID at the end of the URL.
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
		session_start();
		$_SESSION['sid']=$matches[1];
		//echo $_SESSION['sid'];
		header('location: /loginPage/490project/registerInput.php');                
		
		//echo "User is logged in (steamID: $matches[1])\n";
	} 
	else 
	{
                echo "User is not logged in.\n";
        }

    }

} catch(ErrorException $e) {
    echo $e->getMessage();
}
?>
