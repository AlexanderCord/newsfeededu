<?php
require_once __DIR__ . '/../vendor/autoload.php'; // change path as needed

require_once __DIR__ . '/habr.php';
require_once __DIR__ . '/config.php';

$fb = new \Facebook\Facebook([
  'app_id' => '2812389959038561',
  'app_secret' => 'e647977453e23ce63e782dfc77d56807',
  'default_graph_version' => 'v2.10',
 // 'default_access_token' => 'a965a02a49fe602f827728821f2eb8ca', // optional
]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
//   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();

try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/me', 
    $accessToken  
  );
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
error_reporting(E_ALL);
$me = $response->getGraphUser();
echo 'Logged in as ' . $me->getName();
list($postTitle, $postUrl) = getHabrPost();
//FB post content
    $message = $postTitle;
    $title = $postTitle;
    $link = $postUrl;
    $description = $postTitle;
    $picture = "";

    $attachment = array(
        'message' => $message,
        //'name' => $title,
        'link' => $link,
        //'description' => $description,
        //'picture'=>$picture,
    );

    try{
        // Post to Facebook
        $fb->post('/newsfeededu/feed', $attachment, $accessToken);
        var_dump($fb);

        // Display post submission status
        echo 'The post was published successfully to the Facebook timeline.';
    }catch(FacebookResponseException $e){
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    }catch(FacebookSDKException $e){
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    } catch(Exception $e) {
        var_dump($e->getMessage());
    }
