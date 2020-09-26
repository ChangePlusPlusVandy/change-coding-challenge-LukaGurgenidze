<?php
$link = mysqli_connect("localhost", "qrumuvmy_WPEYB", "guessthetweeterDBpassword", "qrumuvmy_guessthetweeterDB");

if(!$link){
    die('ERROR: Unable to connect:' . mysqli_connect_error() . "               " .mysqli_connect_errno());
    echo "<script>window.alert('Oops.. Something went wrong!')</script>";
};

require_once('TwitterAPIExchange.php');
 
$settings = array(
    'oauth_access_token' => "1169792177158836226-x5J3qJomNNLD7d98fgovNV9JbzuFFr",
    'oauth_access_token_secret' => "YrJzq6HtfmgDBA0Itdv2MctVe1CCY7N4tEcq123C3JenQ",
    'consumer_key' => "Zx0wfhPA9pSLFhAGKHXvwiC4p",
    'consumer_secret' => "SgcJHQPTBYp4QoednE05yFYPEQesp8wnQiA4zctayp40lJrzmE"
);
 
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfieldElon = '?screen_name=elonmusk&count=3200&exclude_replies=true&include_rts=false&include_entities=false';
$getfieldKanye = '?screen_name=kanyewest&count=3200&exclude_replies=true&include_rts=false&include_entities=false';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);


$jsonElon = $twitter->setGetfield($getfieldElon)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

$jsonElon = json_decode($jsonElon, true);

$jsonKanye = $twitter->setGetfield($getfieldKanye)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

$jsonKanye = json_decode($jsonKanye, true);

?>



<!DOCTYPE html>
<html>
<head>
    <title>Whose Tweet is that?</title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    </head>
<body>
<div id="container">
    <div id="lives"></div>
    <button id="start" onclick="startGame()">Start</button>
    <div id="score">Score: <span id=scoreVal></span></div>
    <div id="display">
      <div id="tweet" class="tweetFrame">
            <img id="tweetIMG" src=""></img>
      </div>



      <div id="Kayne" class="face">
        <img src="kanye.webp" width="200" height="160">
      </div>
      <div id="Elon" class="face">
        <img src="elon.webp" width="200" height="160">
      </div>

    </div>
    <div id="result"><p id="over">GAME OVER!</p><p id="finalScore">Your Score is: <span id="finalScoreVal"></span></p></div>
    <div id="instruction">Guess the author of the tweet!</div>
    </div>
</body>


<script>
    var correct = 0;
    var answer = "";

   function startGame() {
        randomTweet();
   }
   
   function randomTweet() {
    var x = Math.floor((Math.random() * 2));
    if (x==0) {
        answer = "K";
 
        document.getElementById("tweet").innerHTML = "<?php
        $rand = mt_rand(0,99);  echo $jsonKanye[$rand]["text"] ?>";
        } else {
            answer = "E";
            
        document.getElementById("tweet").innerHTML = "<?php 
        $rand = mt_rand(0,99);  echo $jsonElon[$rand]["text"] ?>";
        
        $("#tweetIMG").attr("src", "<?php echo $jsonElon[$rand]["url"]; ?>");
        }
        
        
   }
   
   $(".face").click(function() {
      if ($(this).attr('id')[0] == answer) {
          correct++;
          document.getElementById("scoreVal").innerHTML = correct;
      } 
    
    randomTweet();

});
   
</script>
</html>
