<?php

//Это для Самого пользователя
//Дальше удаляем со страницы пользователя данное сообщество
$user = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'"));
$follow = explode("/",$user['follow']);
$followNumber = count($follow);
$followNumber -= 1;
//Далее очищаем списки сообществ и добавляем заного
mysqli_query($CONNECT,"UPDATE `users` SET `follow`='' WHERE `id` = '".$_SESSION['id']."'");

$i=0;
while ($i <= $followNumber) {
  if ($follow[$i] != $module  and $follow[$i] !='') {
  if (!$user['follow']) {
  mysqli_query($CONNECT,"UPDATE `users` SET `follow`=CONCAT(`follow`,'".$follow[$i]."') WHERE `id` = '".$_SESSION['id']."'");
  } else {
  mysqli_query($CONNECT,"UPDATE `users` SET `follow`=CONCAT(`follow`,'/".$follow[$i]."') WHERE `id` = '".$_SESSION['id']."'");
};};
  $i++;
}

//А это для пользователя от которого отписываемся
//Дальше удаляем со страницы пользователя данное сообщество
$user2 = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$module."'"));
$follow2 = explode("/",$user2['followers']);
$followNumber2 = count($follow2);
$followNumber2 -= 1;
//Далее очищаем списки сообществ и добавляем заного
mysqli_query($CONNECT,"UPDATE `users` SET `followers`='' WHERE `id` = '".$module."'");

$i=0;
while ($i <= $followNumber2) {
  if ($follow2[$i] != $_SESSION['id'] and $follow2[$i] !='') {
  if (!$user2['followers']) {
  mysqli_query($CONNECT,"UPDATE `users` SET `followers`=CONCAT(`followers`,'".$follow2[$i]."') WHERE `id` = '".$module."'");
  } else {
  mysqli_query($CONNECT,"UPDATE `users` SET `followers`=CONCAT(`followers`,'/".$follow2[$i]."') WHERE `id` = '".$module."'");
};};
  $i++;
}


MessageSend(3,"Вы отписались от ".$user2['name'],"/".$module);


 ?>
