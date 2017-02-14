<?php $title="Сообщения"; include 'blocks/header.php';



$umessages = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `umessages` WHERE `user` = '".$_SESSION['id']."'"));//получаем собесетников
if ($umessages['companions']) {
  $companions = explode("/",$umessages['companions']);
  $i = count($companions);//companionsNumber
  $i--;
  while ($i >= 0) {
    if ($companions[$i] < $_SESSION['id']) {$tableName = $companions[$i]."-".$_SESSION['id'];} else {$tableName = $_SESSION['id']."-".$companions[$i];};
  $messages = mysqli_fetch_array(mysqli_query($MESSAGEBD, "SELECT * FROM `".$tableName."`"));
  $companion = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$companions[$i]."'"));
  $unreadMessagesCount = mysqli_fetch_array(mysqli_query($MESSAGEBD, "SELECT COUNT(*) FROM `".$tableName."` WHERE `recipient` = '".$_SESSION['id']."' and `status` = '0'"));
  echo '<a href="/m/'.$companions[$i].'" class="postname" >'.$companion['name'].' '.$companion['lastname'].'</a><span style="float:right" title="Непорочитанных">'.$unreadMessagesCount[0].'</span><hr>';
  $i--;
  };
}

else echo "У вас нет переписок";

include 'blocks/content.php'; ?>
