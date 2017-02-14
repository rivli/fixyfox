<?php
if (!$_SESSION['USER_ACTIVE_EMAIL']) {
$Email = base64_decode(substr($ident2, 5).substr($ident2, 0, 5));
if (strpos($Email, '@') !== false) {
mysqli_query($CONNECT, "UPDATE `users`  SET `acc_verification` = 1 WHERE `email` = '$Email'");
$_SESSION['USER_ACTIVE_EMAIL'] = $Email;
MessageSend(3, 'E-mail <b>'.$Email.'</b> подтвержден.', '/');
}
else MessageSend(1, $Email.'E-mail адрес не подтвержден.', '/');
}
else MessageSend(1, 'E-mail адрес <b>'.$_SESSION['USER_ACTIVE_EMAIL'].'</b> уже подтвержден.', '/');echo $Email;


?>
