<?php
$post = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$_POST['communityname']."Articles` WHERE `id` = '".$_POST['postid']."'"));

if ($_SESSION['position'] != 'admin' and $post['author'] != $_SESSION['id']) {MessageSend(1,"Вы не можете просматривать эту страницу",$_POST['post']);} else {

$_POST['name'] = FormChars($_POST['name']);
$vowels = array("<br />", "<br /><br />", "<br /><br /><br />");
$_POST['text'] = str_replace($vowels, "<br />", nl2br(trim($_POST['text'])));
if ($_SESSION['position'] == 'admin') {$status = "verified";} else {$status = "inspection";};
mysqli_query($COMMUNITYBD , "UPDATE `".$_POST['communityname']."Articles` SET `name` = '".$_POST['name']."',`status` = '".$status."' ,`tags` = '".$_POST['tags']."',`text` = '".$_POST['text']."' WHERE `id` = '".$_POST['postid']."'");

MessageSend(2, 'Запись отредактирована.', $_POST['post']);
}

 ?>
