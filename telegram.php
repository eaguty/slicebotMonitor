<?php

/**
* 
*/
class Telegram 
{
	
	function sendMessage($chatID, $messaggio, $token) {
    echo "sending message to " . $chatID . "\n";

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);

    $curl = curl_init();
	 
	 
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	 
	$result = curl_exec($curl);
	echo $url;
	curl_close($curl);
    return $result;
	}
}

?>