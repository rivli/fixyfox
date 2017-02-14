<?php

$query = "SELECT * FROM `users` WHERE (`id` = '".$page."')";
$result = mysqli_query($CONNECT, $query);
$user1 = mysqli_fetch_array($result);
if (!$user1) {
  MessageSend(1,"Такого пользователя не существует","/".$_SESSION['id']);
};


$title="Сообщения"; include 'blocks/header.php';
?>
<script type="text/javascript">
$(document).ready(function() {
$('#messblock').scrollTop(100000);
});
</script>
<?php
$umessages = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `umessages` WHERE `user` = '".$_SESSION['id']."'")); //or die("Ошибка MySQL: " . mysql_error());//получаем собесетников
if (!$umessages) {//если таблицы собеседников нет,то создаем
  mysqli_query($CONNECT , "INSERT INTO `umessages`  VALUES ('','".$_SESSION['id']."', '".$page."')");
}
$umessages = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `umessages` WHERE `user` = '".$_SESSION['id']."'")); //обновляем собеседников
if (!$umessages['companions']) {
    mysqli_query($CONNECT,"UPDATE `umessages` SET `companions`=CONCAT(`companions`,'".$page."') WHERE `id` = '".$_SESSION['id']."'");
} else {
  $companions = explode("/",$umessages['companions']);//получаем собеседников пользователя и добавляем нового если нет его в списке
  if (!in_array($page,$companions)) {
    mysqli_query($CONNECT,"UPDATE `umessages` SET `companions`=CONCAT(`companions`,'/".$page."') WHERE `id` = '".$_SESSION['id']."'");
  };
  }

//далее добавляем таблицу собеседников для переговорщика
//если таковой нет
//и в собеседники приписываем пользователя

$umessagesNew = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `umessages` WHERE `user` = '".$page."'")) ;//получаем собесетников
if (!$umessagesNew) {
  mysqli_query($CONNECT , "INSERT INTO `umessages`  VALUES ('','".$page."','".$_SESSION['id']."')");
}
$umessagesNew = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `umessages` WHERE `user` = '".$page."'")) ;//получаем собесетников

if (!$umessagesNew['companions']) {
    mysqli_query($CONNECT,"UPDATE `umessages` SET `companions`=CONCAT(`companions`,'".$_SESSION['id']."') WHERE `id` = '".$page."'");
} else {
  $companionsNew = explode("/",$umessagesNew['companions']);
  if (!in_array($_SESSION['id'],$companionsNew)) {
    mysqli_query($CONNECT,"UPDATE `umessages` SET `companions`=CONCAT(`companions`,'/".$_SESSION['id']."') WHERE `id` = '".$page."'");
  }
  }

//далее получаем сообщения между пользователями

if ($page < $_SESSION['id']) {$tableName = $page."-".$_SESSION['id'];} else {$tableName = $_SESSION['id']."-".$page;};
$messages = mysqli_fetch_array(mysqli_query($MESSAGEBD, "SELECT * FROM `".$tableName."`"));
if (!$messages) {
  $sql = "CREATE TABLE `".$tableName."` ( `id` INT NOT NULL AUTO_INCREMENT , `status` VARCHAR(255) NOT NULL , `sender` INT(255) NOT NULL , `recipient` INT(255) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
  mysqli_query($MESSAGEBD, $sql);
};
$companion = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$page."'"));



echo 'Переписка с <a href="/'.$page.'" class="postname" >'.$companion['name'].' '.$companion['lastname'].'</a>';
echo '  <img src="'.$companion['avatar'].'" title="'.$companion['name']." ".$companion['lastname'].'" class="usersMessagingAva" ><br>';

$messagesNumber = mysqli_fetch_array(mysqli_query($MESSAGEBD , "SELECT COUNT(*) FROM `".$tableName."`"));
$i = 0;
echo '<br><br><div id="messblock" style="overflow-y: scroll;height:300px;  display:inline-block;width:100%;">';
while ($i <= $messagesNumber[0]) {
$message = mysqli_fetch_array(mysqli_query($MESSAGEBD, "SELECT * FROM `".$tableName."` WHERE `id` = '".$i."'"));
if ($message['sender'] == $_SESSION['id']) {
  if ($message['status']==0) {$NewMessage='style="background:#919191;"';} else {$NewMessage='style="background:#b0e8dc;"';};
  echo '
  <div style="width:100%;display:inline-block;"><div  class="usersMessaging" '.$NewMessage.'> <span style="font-size:10px;">'.$message['date']." ".$message['time']."</span><br>".$message['text'].'</div></div>
  ';
} else {
  if ($message['status']==0) {$NewMessage='style="background:#b56464;"';} else {$NewMessage='style="background:#b0e8dc;"';};
  echo '
  <div style="width:100%;display:inline-block;"><div class="usersMessaging2" '.$NewMessage.' ><span style="font-size:10px;">'.$message['date']." ".$message['time']."</span><br>".$message['text'].'</div></div>
  ';
};
$i++;
};
echo '</div>';
?>
<br><br>
<form class="" action="/users/query/message" method="post">
  <input type="hidden" name="recipient" value="<?php echo $page; ?>" >
  <input type="hidden" name="tablename" value="<?php echo $tableName; ?>" >
  <div style="display:inline-block;width:90.1%;">
    <textarea type="text" id="textarea" name="text" placeholder="Text"  required></textarea>
  </div><br>
    <div class="addButton" style="display:inline-block;width:30px;" title="Вставить ссылку" id="addhref">С</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить изображение" id="addimage">И</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить аудиозапись" id="addaudio">А</div>
      <div class="addButton" style="display:inline-block;width:30px;" title="Вставить видео" id="addvideo">В</div>


  <input style="float:right;position:relative;top:15px;" type="submit" name="add" value="Отправить">
</form>
<?php

mysqli_query($MESSAGEBD, "UPDATE `".$tableName."` SET `status` = '1' WHERE `recipient` = '".$_SESSION['id']."'");
//Помечаем непрочитанные сообщения прочитанными
 include 'blocks/content.php';include 'blocks/sidebars/messaging.php'; ?>
