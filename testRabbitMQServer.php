#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include 'functions.php';
//
/*
function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    return true;
    //return false if not valid
}
*/
function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
/*
    case "login":
      //return doLogin($request['username'],$request['password']);
      $auth=doLogin($request['username'],$request['password']);
	if($auth==true){
		return array('hello'=>'world');	
	}

*/
    //case "validate_session":
      //return doValidate($request['sessionId']);

	//in case friends this will return a list of friends from
	//the the steam user, and send it in an array to the client.
   case "showFriends":
	//echo "hello";
	//echo $request['steamid'];
	//print_r("yo");	
	return showFriends($request['steamid']);
	break;

    case "showFriends2":
	//echo "hello";
	//echo $request['steamid'];
	//print_r("yo");	
	return showFriends($request['steamid']);
	break;
  case "fofLoad":
				
		return compareGames("76561198011789036","76561197978534933");	
	break;
	//return array("returnCode" => '0', 'message'=>"Server received request and processed");
  }
  //return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

$server->process_requests('requestProcessor');
exit();
?>

