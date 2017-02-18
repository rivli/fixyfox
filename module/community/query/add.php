<?php

if ($_SESSION['status'] != 'login') {MessageSend(1,"Вы не можете просматривать эту страницу","/");} else {

$_POST['url'] = FormChars($_POST['url']);
//Здесь проверяем занят ли УРЛ или нет
  $projectsarray = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `arrays` WHERE `name` = 'communities'")); //обновляем собеседников
  $pagesArray = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `arrays` WHERE `name` = 'pages'")); //обновляем собеседников
  if (!$projectsarray['array']) {
      mysqli_query($CONNECT,"UPDATE `arrays` SET `array`=CONCAT(`array`,'".$_POST['url']."') WHERE `name` = 'communities'");
  } else {
    $projarray = explode("/",$projectsarray['array']);//получаем УРЛи добавляем новый если нет его в списке
    if (!in_array($_POST['url'],$projarray)) {
      mysqli_query($CONNECT,"UPDATE `arrays` SET `array`=CONCAT(`array`,'/".$_POST['url']."') WHERE `name` = 'communities'");
    } else {
      MessageSend(1,"Извените,но URL \"".$_POST['url']."\" уже занят","/".$_SESSION['id']);
    };};

    $pageArray = explode("/",$pagesArray['array']);//получаем УРЛи добавляем новый если нет его в списке
    if (in_array($_POST['url'],$pageArray)) {
      MessageSend(1,"Извените,но URL \"".$_POST['url']."\" используется системой и его невозможно использовать","/".$_SESSION['id']);
    };

$_POST['name'] = FormChars($_POST['name']);
$_POST['description'] = nl2br(trim($_POST['description']));
mysqli_query($CONNECT , "INSERT INTO `communities`  VALUES ('', '".$_POST['name']."', '".$_POST['url']."', '".$_POST['description']."','".$_SESSION['id']."','','".$_POST['versions']."')");

$sql1 = "CREATE TABLE `".$_POST['url']."Articles` ( `id` INT NOT NULL AUTO_INCREMENT , `status` VARCHAR(255) NOT NULL , `name` VARCHAR(255) NOT NULL , `text` TEXT NOT NULL , `author` INT(255) NOT NULL , `date` DATE NOT NULL , `visits` INT(255) NOT NULL , `comments` INT(255) NOT NULL , `tags` TEXT NOT NULL , `commacces` INT(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($COMMUNITYBD, $sql1);//создаем таблицу для статей сообщества

$sql2 = "CREATE TABLE `".$_POST['url']."Images` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , `status` VARCHAR(255) NOT NULL , `url` VARCHAR(255) NOT NULL , `description` TEXT NOT NULL , `likes` INT(255) NOT NULL , `comments` INT(255) NOT NULL , `album` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($COMMUNITYBD, $sql2);//создаем таблицу для Изображений сообщества

$sql3 = "CREATE TABLE `".$_POST['url']."Followers` ( `id` INT NOT NULL AUTO_INCREMENT , `userid` INT(255) NOT NULL , `status` VARCHAR(255) NOT NULL , `articles` INT(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
mysqli_query($COMMUNITYBD, $sql3);//создаем таблицу для Подписчиков сообщества

if ($_POST['versions'] == 1) {
  $sql3 = "CREATE TABLE `".$_POST['url']."Versions` ( `id` INT NOT NULL AUTO_INCREMENT , `name` INT(255) NOT NULL , `describtion` TEXT NOT NULL , `status` VARCHAR(255) NOT NULL , `url` VARCHAR(255) NOT NULL , `mirrorURL` VARCHAR(255) NOT NULL , `GitURL` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
  mysqli_query($COMMUNITYBD, $sql3);//создаем таблицу для версий продукта сообщества
}

//Далее подписываемся как создатель этого сообщества
mysqli_query($COMMUNITYBD , "INSERT INTO `".$_POST['url']."Followers`  VALUES ('', '".$_SESSION['id']."', 'creator','0')");


//Дальше добавляем к пользователю УРЛ его проекта
$user = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `id` = '".$_SESSION['id']."'"));
if (!$user['communities']) {
mysqli_query($CONNECT,"UPDATE `users` SET `communities`=CONCAT(`communities`,'".$_POST['url']."') WHERE `id` = '".$_SESSION['id']."'");
} else {
mysqli_query($CONNECT,"UPDATE `users` SET `communities`=CONCAT(`communities`,'/".$_POST['url']."') WHERE `id` = '".$_SESSION['id']."'");
}

$query = "SELECT * FROM `communities` WHERE (`name` = '".$_POST['name']."') and (`creator` = '".$_SESSION['id']."')";
$result = mysqli_query($CONNECT, $query);
$project = mysqli_fetch_array($result);

MessageSend(2, 'Запись отправлена на проверку', '/'.$project['url']);
}

 ?>
