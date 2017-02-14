<?php
$post = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `uarticles` WHERE `id` = '".$_POST['postid']."'"));
if ($_SESSION['position'] != 'admin' and $post['author'] != $_SESSION['id']) {MessageSend(1,"Вы не можете просматривать эту страницу",$_POST['post']);} else {

$_POST['name'] = FormChars($_POST['name']);
$vowels = array("<br />", "<br /><br />", "<br /><br /><br />");
$_POST['text'] = str_replace($vowels, "<br />", nl2br(trim($_POST['text'])));
if ($_SESSION['position'] == 'admin') {$status = "verified";} else {$status = "inspection";};
/*echo $_POST['postid'];
echo $_POST['name'];
echo $_POST['tags'];*/
mysqli_query($CONNECT , "UPDATE `uarticles` SET `name` = '".$_POST['name']."',`status` = '".$status."' ,`tags` = '".$_POST['tags']."',`text` = '".$_POST['text']."' WHERE `id` = '".$_POST['postid']."'");

MessageSend(2, 'Запись отредактирована.', $_POST['post']);
}

 ?>
