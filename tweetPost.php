<?php
        $accessToken = '939769892223442945-4Q5eXB6UzmSU02Vys5PX2W4PXYnNjrk';
        $accessTokenSecret = 'AFgyEnfmuEdBqyxTVWLmSrsIhnZIedzbuPH3ZyoGRVz9h';


	define( 'TWITTER_CONSUMER_KEY', '7GLsYt6FwAe5jljETTAfOjJla' );
	define( 'TWITTER_CONSUMER_SECRET', 'MQecu6A0NS0VaNjzz3lvryb1NwM5NLoPxMPfRNrnLGOx3WLGw8' );
	
	
	define( 'TWITTER_ACCESS_TOKEN', $accessToken );
	define( 'TWITTER_ACCESS_TOKEN_SECRET', $accessTokenSecret );
	
	
	// include config and twitter api wrappe

	require_once( 'TwitterAPIExchange.php' );

	// settings for twitter api connection
	$settings = array(
		'oauth_access_token' => TWITTER_ACCESS_TOKEN, 
		'oauth_access_token_secret' => TWITTER_ACCESS_TOKEN_SECRET, 
		'consumer_key' => TWITTER_CONSUMER_KEY, 
		'consumer_secret' => TWITTER_CONSUMER_SECRET
	);

	// twitter api endpoint
	$url = 'https://api.twitter.com/1.1/statuses/update.json';
	
	// twitter api endpoint request type
	$requestMethod = 'POST';

	// twitter api endpoint data
	$apiData = array(
	    'status' => 'What about the day?',
	);

	// create new twitter for api communication
	$twitter = new TwitterAPIExchange( $settings );

	// make our api call to twiiter
	$twitter->buildOauth( $url, $requestMethod );
	$twitter->setPostfields( $apiData );
	$response = $twitter->performRequest( true, array( CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_SSL_VERIFYPEER => 0 ) );

	// display response from twitter
    echo '<pre>';
    print_r( json_decode( $response, true ) );
    
    
    // ...............For sending image and video..................
    
    
    $file = file_get_contents(DIR . '/img/logo.png');
$data = base64_encode($file);

// Upload image to twitter
$url = "https://upload.twitter.com/1.1/media/upload.json";
$method = "POST";
$params = array(
"media_data" => $data,
);

$json = $twitter
->buildOauth($url, $method)
->setPostfields($params)
->performRequest();

// Result is a json string
$res = json_decode($json);
// Extract media id
$id = $res->media_id_string;

$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';
$postfields = array(
'media_ids' => $id,
'status' => 'This is machine test' );

if(strlen($postfields['status']) <= 140)
{
//$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
->setPostfields($postfields)
->performRequest();
}else{
echo "140 char exceed";
}
    
    
    // .....................Alternative way to upload image......................
    $url = 'https://upload.twitter.com/1.1/media/upload.json';
$requestMethod = 'POST';

$image = 'full/path/to/image.jpg';

$postfields = array(
  'media_data' => base64_encode(file_get_contents($image))
);

$response = $twitter->buildOauth($url, $requestMethod)
  ->setPostfields($postfields)
  ->performRequest();

// get the media_id from the API return
$media_id = json_decode($response)->media_id;

// then send the Tweet along with the media ID
$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = 'POST';

$postfields = array(
  'status' => 'My amazing tweet',
  'media_ids' => $media_id
);

$response = $twitter->buildOauth($url, $requestMethod)
  ->setPostfields($postfields)
  ->performRequest();
    
    
    
    
?>