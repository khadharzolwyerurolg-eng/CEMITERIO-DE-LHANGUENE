<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientID(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setRedirectUri(GOOGLE_REDIRECT_URI);
$client->addScope("email");
$client->addScope("profile");


if(!isset($_GET['code'])){
    $auth_url = $client->createAuthUrl();
    header('Location: '. filter_var($auth_url, FILTER_SANITIZE_URL));
    exit;
}else{
    $client->authenticate($_GET['code']);
    $token = $client->getAccessToken();
    $client->setAccessToken();

    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();


    // Store in DB::

    $stmt = $conn->prepare("SELECT * FROM users WHERE oauth_uid = ? oauth_provider = 'google'");
    $stmt->bind_param("s", $userInfo->id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        $stmt = $conn->prepare("INSERT INTO users (oauth_provider, oauth_uid, name, email, picture) VALUES ('google', ?, ?, ?, ?)");
        $stmt->bind_param("ssss", $userInfo->id, $userInfo->name, $userInfo->email, $userInfo->picture);
        $stmt->execute();
    }

    $_SESSION['user'] = [
        'name' => $userInfo->name,
        'email' => $userInfo->email
    ];

    header("Location: dashboard.php");
    exit;

}
