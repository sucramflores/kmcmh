
<?php

	//passing arguments
	if($argc<2){
		echo "\n-----------------------------------------------------------------\n";
		echo "You din't pass any parameter\nPlease, run the script again with a valid URL\n";
		echo "-----------------------------------------------------------------\n";
		exit();
	}
	else{
		$url = $argv[1]; //the arguments passed
	}

	// Initializing cUrl
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	$result=curl_exec($ch);

	echo "\n--------------------------------------------------------------------------\n";
	// Checking if it went through
	if(!curl_errno($ch)){ 
		$info = curl_getinfo($ch); 
		if(isJson($result)){
			$content = json_decode($result);
			writeIntoFile($content);
		}
		else{
			echo "The URL did not return a valid JSON or the JSON is empty\n";
		}
		echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url']."\n"; 

	} else {
		echo 'Curl error: ' . curl_error($ch)."\n"; 
	} 
	curl_close($ch);
	echo "--------------------------------------------------------------------------\n\n\n";



	function writeIntoFile($string) {
		if(file_put_contents('output.txt', print_r($string, true))){
			echo "The object was succesfully saved into 'output.txt'\n";
		}else{
			echo "Opz! Something went wrong\nCouldn't create the file";
		}

	}


	function isJson($string) {
		$empty = empty(json_decode($string, true));
		$isjson = json_last_error(); 
		if($empty || $isjson!=0)
			return false;
		else
			return true;
		
	}


?>