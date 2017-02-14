<?php

$_POST['email'] = FormChars($_POST['email']);
$_POST['password'] = GenPass(FormChars($_POST['password']), $_POST['email']);
$_POST['name'] = FormChars($_POST['name']);
$_POST['lastname'] = FormChars($_POST['lastname']);

 if ($_POST['sex']=='male') {
   $avatar = "http://zakilven.bget.ru/resources/avatars/male.png";
    } else {
    $avatar = "http://zakilven.bget.ru/resources/avatars/female.png";
};

$Row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `email` FROM `users` WHERE `email` = '".$_POST['email']."'"));
if ($Row['email']) exit('E-Mail <b>'.$_POST['email'].'</b> уже используеться.');
mysqli_query($CONNECT , "INSERT INTO `users`  VALUES ('','user', '".$_POST['name']."', '".$_POST['lastname']."', '".$_POST['email']."', '".$_POST['password']."',NOW(),'0','".$avatar."','','','".$_POST['sex']."','','','')");


$query = "SELECT * FROM `users` WHERE (`email` = '".$_POST['email']."') and (`password` = '".$_POST['password']."')";
$result = mysqli_query($CONNECT, $query);
$user = mysqli_fetch_array($result);


$_SESSION['id'] = $user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['lastname'] = $user['lastname'];
$_SESSION['position'] = $user['position'];
$_SESSION['status'] = "login";



$Code = base64_encode($_POST['email']);
mail($_POST['email'], 'Регистрация на Bloff', 'Ссылка для активации: http://zakilven.bget.ru/users/query/verification/'.substr($Code, -5).substr($Code, 0, -5), 'From: Ilvir@bloff.ru');
MessageSend(3, 'Регистрация акаунта успешно завершена. На указанный E-mail адрес <b>'.$_POST['email'].'</b> отправленно письмо о подтверждении регистрации.', "/".$_SESSION['id']);


?>
