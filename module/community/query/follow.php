<?php

//Проверяем были ли мы подписаны на это сообщество ранее
$AmIFollower = mysqli_fetch_array(mysqli_query($COMMUNITYBD, "SELECT * FROM `".$module."Followers` WHERE `userid` = '".$_SESSION['id']."'"));
$community = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT * FROM `communities` WHERE `url` = '".$module."'"));

if (!$AmIFollower) {
  //Далее подписываемся как follower этого сообщества
mysqli_query($COMMUNITYBD , "INSERT INTO `".$module."Followers`  VALUES ('', '".$_SESSION['id']."', 'follower','0')");
} else {
  //Далее подписываемся как подписчик этого сообщества
  mysqli_query($COMMUNITYBD , "UPDATE `".$module."Followers` SET `status`='follower' WHERE `userid` = '".$_SESSION['id']."'");
};
//Дальше добавляем к пользователю УРЛ данного проекта
$user = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'"));
if (!$user['communities']) {
mysqli_query($CONNECT,"UPDATE `users` SET `communities`=CONCAT(`communities`,'".$module."') WHERE `id` = '".$_SESSION['id']."'");
} else {
mysqli_query($CONNECT,"UPDATE `users` SET `communities`=CONCAT(`communities`,'/".$module."') WHERE `id` = '".$_SESSION['id']."'");
}

//Далее прибавляем 1 к счетчику подписчиков
$newNumber = $community['followers'] + 1;
mysqli_query($CONNECT,"UPDATE `communities` SET `followers`='".$newNumber."' WHERE `url` = '".$module."'");


MessageSend(3,"Вы подписались на ".$community['name'],"/".$module);

 ?>
