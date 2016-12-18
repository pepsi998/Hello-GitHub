<?php
session_start();
require_once 'dbcontroller.php';

//Google API PHP Library includes
require_once 'Google/Client.php';
require_once 'Google/Service/Oauth2.php';

// Fill CLIENT ID, CLIENT SECRET ID, REDIRECT URI from Google Developer Console
 $client_id = '74198217920-h20hkqva42s7j3r67h9pd5s7a6id8kp5.apps.googleusercontent.com';
 $client_secret = 'd3nYUVvPnH1AXloeDMk8Y3Q6';
 $redirect_uri = '<Callback-URL>';
 $simple_api_key = '<Your-API-Key>';
 
//Create Client Request to access Google API
$client = new Google_Client();
$client->setApplicationName("PHP Google OAuth Login Example");
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setDeveloperKey($simple_api_key);
$client->addScope("https://www.googleapis.com/auth/userinfo.email");

//Send Client Request
$objOAuthService = new Google_Service_Oauth2($client);

//Logout
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
  $client->revokeToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL)); //redirect user back to page
}

//Authenticate code from Google OAuth Flow
//Add Access Token to Session
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

//Set Access Token to make Request
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
}

//Get User Data from Google Plus
//If New, Insert to Database
if ($client->getAccessToken()) {
  $userData = $objOAuthService->userinfo->get();
  if(!empty($userData)) {
	$objDBController = new DBController();
	$existing_member = $objDBController->getUserByOAuthId($userData->id);
	if(empty($existing_member)) {
		$objDBController->insertOAuthUser($userData);
	}
  }
  $_SESSION['access_token'] = $client->getAccessToken();
} else {
  $authUrl = $client->createAuthUrl();
}
require_once("loginpageview.php")
?>