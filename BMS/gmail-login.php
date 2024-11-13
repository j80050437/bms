<?php
require_once 'vendor/autoload.php'; // Include Google API PHP Client

session_start();

$client = new Google_Client();
$client->setClientId('your_client_id');
$client->setClientSecret('your_client_secret');
$client->setRedirectUri('https://yourwebsite.com/gmail-login.php');
$client->addScope("email");
$client->addScope("profile");

if (!isset($_GET['code'])) {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
} else {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $oauth2 = new Google_Service_Oauth2($client);
    $userinfo = $oauth2->userinfo->get();
    $email = $userinfo->email;

    // Check if user exists in the database
    include 'db.php';
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $_SESSION['user_id'] = $user_id;
        header("Location: dashboard.php");
        exit();
    } else {
        // Register new user with Gmail details
        $name = $userinfo->name;
        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email) VALUES (?, ?, ?)");
        $name_parts = explode(" ", $name);
        $stmt->bind_param('sss', $name_parts[0], $name_parts[1], $email);
        $stmt->execute();
        $_SESSION['user_id'] = $conn->insert_id;
        header("Location: dashboard.php");
        exit();
    }
}
