<?php
if (!$_POST['recipient']) {MessageSend(2, 'Хех.Ну ты пытался.', '/users/message/');} else {
if (!$_POST['text']) {MessageSend(2, 'Вы отправили пустое сообщение', '/users/message/'.$_POST['recipient']);
} else {

$_POST['text'] = nl2br(trim($_POST['text']));
mysqli_query($MESSAGEBD , "INSERT INTO `".$_POST['tablename']."`  VALUES ('','0','".$_SESSION['id']."', '".$_POST['recipient']."', '".$_POST['text']."', NOW(), '".date("H:i:s")."')") or die("Ошибка подключения к базе данных".mysql_error());



MessageSend(2, 'Сообщение отправлено', '/m/'.$_POST['recipient']);
};};

 ?>
