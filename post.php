<?php
session_start();
$_SESSION['name']=$_POST["name"];
if(isset($_POST['name'])){
    $text = $_POST['text'];
     
    $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>". $_POST['name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
     
    file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
}
?>