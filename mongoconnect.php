<?php
/*
@There is some data that we are pulling from steam, that is too large
@for sql. This will connetct to mongo lab. I would like to include mongo local storage for optmization
@this will be where I store all of the information for users achievements, and game libraries.
*/
include "dbConnect.php";




function sendMongo($steamId,$type){

//function mongoConnect($steamId,$type,$collection){
	switch($type){
			case 1: //gets the player Summaries
				$fetch_pInfo="http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?		key=238E8D6B70BF7499EE36312EF39F91AA&steamids=$steamId";
			break;
			case 2://gets the players Game Library
				$fetch_pInfo="http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=238E8D6B70BF7499EE36312EF39F91AA&steamid=$steamId&format=json";
			break;
			/*		
			case 3://gets the players achievements
				//steam api for players achievements.
			break;
			case 4://may have to get other stats,
				//will use this maybe for players over all steam rank.
			break;
		
			*/

		}//end switch data


		$jsonO=file_get_contents($fetch_pInfo);
		var_dump($jsonO);

		$connection = new MongoClient( "mongodb://alex:password@ds041643.mongolab.com:41643/steamdata");
		$mongodb = $connection->selectDB('steamdata');
		$collection = new MongoCollection($mongodb,'gameLibrary');

		//var_dump($connection);
		//var_dump($collection);

		$send=array();
			$send["_id"] = $steamId;
			$send["info"] = $jsonO;
			$collection->insert($send);
}//end mongo

//}
?>
