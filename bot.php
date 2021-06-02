<?php

require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$channelAccessToken = 'lrQ6WSZ9K2TOPbDRzsqx2vN7QWCgA7B6FkBcxfnM6PuOBYQDB3oD/wCjAXax8niPmwAr8mkXef4h02RyLQYUaLhUEWFegp+h6R8AaoxtIfM4CfFOobNqnTyoFeGY7Gqn4bjVGlfjDZ+J91GUuokpIQdB04t89/1O/w1cDnyilFU=';
$channelSecret = '7a84953aa557a61bfe757fe788f9fa8c';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$groupId 	= $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp	= $client->parseEvents()[0]['timestamp'];
$type 		= $client->parseEvents()[0]['type'];

$message 	= $client->parseEvents()[0]['message'];
$messageid 	= $client->parseEvents()[0]['message']['id'];

$profil = $client->profil($userId);

$pesan_datang = explode(" ", $message['text']);

$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}

# require_once('./src/function/search-1.php');
# require_once('./src/function/download.php');
# require_once('./src/function/random.php');
# require_once('./src/function/search-2.php');
# require_once('./src/function/hard.php');


if ($type == 'join' || $command == '/help') {
    $text = "Halo Jing!\ncommand:\n1. /zoomlink = zoom link";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}
if ($type == 'join' || $command == '/zoomlink') {
    $text = "https://zoom.us/j/98435942294?pwd=WDhRYXBmWWZnYkNMT1MvTGlPVldaUT09";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}
else if($message['type']=='sticker'){	
	$balas = array(
		'replyToken' => $replyToken,														
		'messages' => array(
			array(
				'type' => 'text',									
				'text' => 'Makasih Kak Stikernya ^_^'										
									
			)
		)
	);						
}
if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();

    file_put_contents('./balasan.json', $result);


    $client->replyMessage($balas);
}
?>
