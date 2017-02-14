<?php

//Далее подписываемся как не подписчик этого сообщества
mysqli_query($COMMUNITYBD , "UPDATE `".$module."Followers` SET `status`='unfollow' WHERE `userid` = '".$_SESSION['id']."'");
$community = mysqli_fetch_array(mysqli_query($CONNECT , "SELECT * FROM `communities` WHERE `url` = '".$module."'"));

//Далее вычитаем 1 от счетчика подписчиков
$newNumber = $community['followers'];
$newNumber--;
mysqli_query($CONNECT , "UPDATE `communities` SET `followers`='".$newNumber."' WHERE `url` = '".$module."'");


//Дальше удаляем со страницы пользователя данное сообщество
$user = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'"));
$communities = explode("/",$projectsarray['array']);//получаем УРЛи добавляем новый если нет его в списке
$communitiesNumber = count($communities);
$communitiesNumber -= 2;
//Далее очищаем списки сообществ и добавляем заного
mysqli_query($CONNECT,"UPDATE `users` SET `communities`='' WHERE `id` = '".$_SESSION['id']."'");

$i=0;
while ($i <= $communitiesNumber) {
  if ($communities[$i] != $module) {
  if (!$user['communities']) {
  mysqli_query($CONNECT,"UPDATE `users` SET `communities`=CONCAT(`communities`,'".$communities[$i]."') WHERE `id` = '".$_SESSION['id']."'");
  } else {
  mysqli_query($CONNECT,"UPDATE `users` SET `communities`=CONCAT(`communities`,'/".$communities[$i]."') WHERE `id` = '".$_SESSION['id']."'");
};};
  $i++;
}




MessageSend(3,"Вы отписалиь от ".$community['name'],"/".$module);

 ?>
