<?php
require_once 'Facebook/autoload.php'; // Include Facebook SDK

session_start();

$fb = new \Facebook\Facebook([
  'app_id' => 'your_app_id',
  'app_secret' => 'your_app_secret',
  'default_graph_version' => 'v2.10',
]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (!isset($accessToken)) {
  $loginUrl = $helper->getLoginUrl('https://yourwebsite.com/facebook-login.php');
  header('Location: ' . $loginUrl);
  exit;
}

try {
  $response = $fb->get('/me?fields=id,name,email', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();
$email = $user['email'];

// Check if the user exists in your database
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
    // Register new user with Facebook details
    $name = $user['name'];
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email) VALUES (?, ?, ?)");
    $name_parts = explode(" ", $name);
    $stmt->bind_param('sss', $name_parts[0], $name_parts[1], $email);
    $stmt->execute();
    $_SESSION['user_id'] = $conn->insert_id;
    header("Location: dashboard.php");
    exit();
}
