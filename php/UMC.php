<?php

$umessages = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `umessages` WHERE `user` = '".$_SESSION['id']."'"));//получаем собесетников
if ($umessages['companions']) {
  $companions = explode("/",$umessages['companions']);
  $i = count($companions);//companionsNumber
$i--;
$unreadMessagesSumm = "0";
  while ($i >= 0) {
    if ($companions[$i] < $_SESSION['id']) {$tableName = $companions[$i]."-".$_SESSION['id'];} else {$tableName = $_SESSION['id']."-".$companions[$i];};
$unreadMessagesCount = mysqli_fetch_array(mysqli_query($MESSAGEBD, "SELECT COUNT(*) FROM `".$tableName."` WHERE `recipient` = '".$_SESSION['id']."' and `status` = '0'"));
  $unreadMessagesSumm += $unreadMessagesCount[0];
  $i--;
  };
}

 ?>
