<?php


//Дальше добавляем к пользователю УРЛ данного проекта
$user = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'"));
if (!$user['follow']) {
mysqli_query($CONNECT,"UPDATE `users` SET `follow`=CONCAT(`follow`,'".$module."') WHERE `id` = '".$_SESSION['id']."'");
} else {
mysqli_query($CONNECT,"UPDATE `users` SET `follow`=CONCAT(`follow`,'/".$module."') WHERE `id` = '".$_SESSION['id']."'");
}

//Дальше добавляем к пользователю УРЛ данного проекта
$user2 = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$module."'"));
if (!$user2['followers']) {
mysqli_query($CONNECT,"UPDATE `users` SET `followers`=CONCAT(`followers`,'".$_SESSION['id']."') WHERE `id` = '".$module."'");
} else {
mysqli_query($CONNECT,"UPDATE `users` SET `followers`=CONCAT(`followers`,'/".$_SESSION['id']."') WHERE `id` = '".$module."'");
}


MessageSend(3,"Вы подписались на ".$user2['name'],"/".$module);

 ?>
