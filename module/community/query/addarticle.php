<?php

if ($_SESSION['status'] != 'login') {MessageSend(1,"Вы не можете просматривать эту страницу","/");} else {

  if ($_SESSION['position'] == 'admin') {$status = "verified";} else {$status = "inspection";};


$_POST['name'] = FormChars($_POST['name']);
$_POST['text'] = nl2br(trim($_POST['text']));
mysqli_query($COMMUNITYBD , "INSERT INTO `".$_POST['url']."Articles`  VALUES ('','".$status."', '".$_POST['name']."', '".$_POST['text']."', '".$_SESSION['id']."',NOW(),0,0,'".$_POST['tags']."','".$_POST['commacces']."')");


$query = "SELECT * FROM `".$_POST['url']."Articles` WHERE (`name` = '".$_POST['name']."') and (`author` = '".$_SESSION['id']."')";
$result = mysqli_query($COMMUNITYBD, $query);
$post = mysqli_fetch_array($result);


  $sql = "CREATE TABLE `".$_POST['url'].$post['id']."` ( `id` INT NOT NULL AUTO_INCREMENT , `mainid` INT(255) NOT NULL , `user` INT(255) NOT NULL , `text` TEXT NOT NULL , `date` DATE NOT NULL , `time` TIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
  mysqli_query($COMMENTBD, $sql);


MessageSend(2, 'Запись отправлена на проверку', '/'.$_POST['url'].'/'.$post['id']);
}

 ?>
